<?php

namespace Sangdou\Component\core;

class Request
{

    use Singleton;

    const METHOD_GET = 1;

    const METHOD_POST = 2;

    private $retryTimes;

    private $isHideError;

    const NO_RETRY_URL_MAP = [
        'https://api.weixin.qq.com/cgi-bin/component/api_component_token'
    ];

    public function __construct()
    {
        $this->retryTimes = 3;
        $this->isHideError = false;
    }

    public function setRetryTimes($times)
    {
        if ($times < 1) {
            $times = 1;
        }

        $this->retryTimes = $times;
    }

    public function send($url, $data = [], $method = self::METHOD_POST, int $timeout = 5, $output = false)
    {
        if (in_array($url, self::NO_RETRY_URL_MAP)) {
            $this->retryTimes = 1;
        }
        $result = $this->doAndRetry($method, $url, $data, $timeout, $this->retryTimes, $output);
        $this->setHideError();
        return $result;
    }

    private function doAndRetry($method, $url, $data, $timeout, $timesLimit, $output)
    {
        for ($times = 1; $times <= $timesLimit; $times++) {
            try {
                $ch = $this->buildCurl($method, $url, $data, $timeout);

                if ($ch === false) {
                    throw new \RuntimeException('curl bulid 失败', ErrCode::EXCEPTION_CODE_BUILD);
                }

                // 执行请求
                $response = curl_exec($ch);
                $error = curl_error($ch);
                if ($output) {
                    return $response;
                }
                $result = json_decode($response);
                $error = curl_error($ch);
                if (!empty($error)) {
                    throw new \RuntimeException("curl发生错误:" . $error, ErrCode::EXCEPTION_CODE_CURL);
                }

                if (!empty(json_last_error())) {
                    throw new \RuntimeException("返回的不是合法json字符串:" . $response, ErrCode::EXCEPTION_CODE_JSON);
                }

                if (!$this->isHideError && isset($result->errcode) && $result->errcode != 0) {
                    $errorCode = empty($result->errcode) ? ErrCode::EXCEPTION_CODE_WECHAT : $result->errcode;
                    throw new \RuntimeException("访问微信接口发生错误:" . ($result->errmsg ?? ""), $errorCode);
                }

                curl_close($ch);
                return $result;
            } catch (\Exception $e) {
                if ($times >= $timesLimit) {
                    throw new \RuntimeException(
                        "访问异常,进行第{$times}次重试:" . $e->getMessage(),
                        $e->getCode()
                    );
                }
            }
        }
    }

    /**
     * 构造curl
     *
     * @param $method
     * @param $url
     * @param $data
     * @param int $timeout
     * @return false
     */
    private function buildCurl($method, $url, $data = [], int $timeout = 2)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //连接时间
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        //返回响应时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        if ($method == self::METHOD_POST) {
            // post请求标识
            curl_setopt($ch, CURLOPT_POST, 1);

            // post请求数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method == self::METHOD_GET) {
            if (!empty($data)) {
                $paramsStr = http_build_query($data);
                if (str_contains($url, "?")) {
                    $url .= "&" . $paramsStr;
                } else {
                    $url .= "?" . $paramsStr;
                }
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        return $ch;
    }

    public function setHideError($isHideError = false)
    {
        $this->isHideError = $isHideError;
        return $this;
    }

    public function sendFile($url, string $filePath, int $timeout = 5, $fileExtension = "")
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            //连接时间
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            //返回响应时间
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_NOBODY, true);

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                [
                    "media" => new \CURLFile(realpath($filePath), 'application/octet-stream', basename($filePath) . $fileExtension),
                ]
            );

            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);

            $response = curl_exec($ch);
            $result = json_decode($response);

            $error = curl_error($ch);
            if (!empty($error)) {
                throw new \RuntimeException("curl发生错误:" . $error, ErrCode::EXCEPTION_CODE_CURL);
            }

            if (!empty(json_last_error())) {
                throw new \RuntimeException("返回的不是合法json字符串:" . $response, ErrCode::EXCEPTION_CODE_JSON);
            }

            if (isset($result->errcode) && $result->errcode != 0) {
                throw new \RuntimeException("访问微信接口上传文件发生错误:" . ($result->errmsg ?? ""), ErrCode::EXCEPTION_CODE_WECHAT);
            }

            curl_close($ch);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
