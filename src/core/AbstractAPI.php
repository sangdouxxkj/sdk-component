<?php

namespace Sangdou\Component\core;

use Pimple\Container;
use Sangdou\Component\core\provider\TicketProvider;

abstract class AbstractAPI
{

    /**
     * The request token.
     *
     */
    protected $accessToken;

    protected $pimple;

    /**
     * @description provider map
     * @var string[]
     */
    protected $providers = [
        TicketProvider::class
    ];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->registerProviders(new Container::class);
    }

    public function setAccessToken($accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    private function registerProviders(Container $pimple)
    {
        array_walk($this->providers, static function ($provider) use ($pimple) {
            $pimple->register($provider);
        });
    }

    /**
     * @description curl请求
     * @param string $url
     * @param array $data
     * @param bool $isPost
     * @param array $header
     * @param bool $isJson
     * @param int $timeOut
     * @return array|false
     */
    public function doRequest(string $url, array $data = [], bool $isPost = true, array $header = [], bool $isJson = true, int $timeOut = 0)
    {
        if (empty($url)) {
            return false;
        }

        //初始化curl
        $curl = curl_init();

        //如果curl版本，大于7.28.1，得是2才行 。 而7.0版本的php自带的curl版本为7.40.1.  使用php7以上的，就能确保没问题
        $ssl = (strpos($url, 'https') !== false) ? 2 : 0;
        $options = [
            //设置url
            CURLOPT_URL => $url,

            //将头文件的信息作为数据流输出
            CURLOPT_HEADER => false,

            // 请求结果以字符串返回,不直接输出
            CURLOPT_RETURNTRANSFER => true,

            //identity", "deflate", "gzip“，三种编码方式，如果设置为空字符串，则表示支持三种编码方式。当出现乱码时，可设置此字符串
            CURLOPT_ENCODING => '',

            //设置http版本。HTTP1.1是主流的http版本
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

            //连接对方主机时的最长等待时间。设置为10秒时，如果对方服务器10秒内没有响应，则主动断开链接。为0则，不限制服务器响应时间
            CURLOPT_CONNECTTIMEOUT => 0,

            //整个cURL函数执行过程的最长等待时间，也就是说，这个时间是包含连接等待时间的
            CURLOPT_TIMEOUT => $timeOut,

            //检查服务器SSL证书中是否存在一个公用名
            CURLOPT_SSL_VERIFYHOST => $ssl,

            //设置头信息
            CURLOPT_HTTPHEADER => $header
        ];

        //post和get特殊处理
        if ($isPost) {
            // 设置POST请求
            $options[CURLOPT_POST] = true;

            if ($isJson && $data) {
                //json处理
                $data = json_encode($data);
                $header = array_merge($header, ['Content-Type: application/json']);
                //设置头信息
                $options[CURLOPT_HTTPHEADER] = $header;

                //如果是json字符串的方式，不能用http_build_query函数
                $options[CURLOPT_POSTFIELDS] = $data;
            } else {
                //x-www-form-urlencoded处理
                //如果是数组的方式,要加http_build_query，不加的话，遇到二维数组会报错。
                $options[CURLOPT_POSTFIELDS] = http_build_query($data);
            }
        } else {
            // GET
            $options[CURLOPT_CUSTOMREQUEST] = 'GET';

            //没有？且data不为空,将参数拼接到url中
            if (strpos($url, '?') === false && !empty($data) && is_array($data)) {
                $params_arr = [];
                foreach ($data as $k => $v) {
                    $params_arr[] = $k . '=' . $v;
                }
                $params_string = implode('&', $params_arr);
                $options[CURLOPT_URL] = $url . '?' . $params_string;
            }
        }

        //数组方式设置curl，比多次使用curl_setopt函数设置在速度上要快
        curl_setopt_array($curl, $options);

        // 执行请求
        $response = curl_exec($curl);

        //返回的CONTENT_TYPE类型
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        //返回的http状态码
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $result = ['code' => $httpCode, 'header' => $contentType];
        //没有错误时curl_errno返回0
        if (curl_errno($curl) == 0) {
            $result['errmsg'] = 'SUCCESS';
            if (is_null($response)) {
                $result['body'] = null;
            } else {
                $data = json_decode($response, true);
                if ($data) {
                    //json数据
                    $result['body'] = $data;
                } else {
                    //不是json,则认为是xml数据
                    libxml_disable_entity_loader(true);//验证xml
                    $xml = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);//解析xml
                    $result['body'] = $xml;
                }
            }
        } else {
            $result['errmsg'] = curl_error($curl);
            $result['body'] = null;
        }
        //关闭请求
        curl_close($curl);
        return $result;
    }

}