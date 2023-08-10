<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class WxaService extends AbstractAPI
{
    public const JSCODE2SESSION = 'https://api.weixin.qq.com/sns/component/jscode2session?component_access_token=%s';

    public const BIND_TESTER = 'https://api.weixin.qq.com/wxa/bind_tester?access_token=%s';
    public const UNBIND_TESTER = 'https://api.weixin.qq.com/wxa/unbind_tester?access_token=%s';
    public const MEMBERAUTH = 'https://api.weixin.qq.com/wxa/memberauth?access_token=%s';

    public const GET_ACCOUNT_BASIC_INFO = 'https://api.weixin.qq.com/cgi-bin/account/getaccountbasicinfo?access_token=%s';

    public const  API_SUBSCRIBE_SEND = 'https://api.weixin.qq.com/wxa/generatescheme?access_token=%s';

    public const API_GET_WXACODE_UNLIMIT = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=%s';
    public const API_CREATE_QRCODE = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/login/thirdpartyCode2Session.html
     * @param string $js_code
     * @param string $grant_type
     * @return mixed|void
     */
    public function jscodeToSession(string $js_code, string $grant_type = 'authorization_code')
    {
        $params = [
            'appid' => $this->service->getAuthorizerAppid(),
            'grant_type' => $grant_type,
            'component_appid' => $this->service->getComponentAppid(),
            'js_code' => $js_code,
        ];

        return Request::getInstance()->send(sprintf(self::JSCODE2SESSION, $this->service->getComponentTokenHandle()->component_access_token), $params, Request::METHOD_GET);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/member-management/bindTester.html
     * @param string $wechatid
     * @return mixed|void
     */
    public function bindTester(string $wechatid)
    {
        $params = [
            'wechatid' => $wechatid,
        ];

        return Request::getInstance()->send(sprintf(self::BIND_TESTER, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/member-management/unbindTester.html
     * @param string $wechatid
     * @return mixed|void
     */
    public function unbindTester(string $wechatid)
    {
        $params = [
            'wechatid' => $wechatid,
        ];

        return Request::getInstance()->send(sprintf(self::UNBIND_TESTER, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/member-management/getTester.html
     * @param string $action
     * @return mixed|void
     */
    public function memberAuth(string $action = 'get_experiencer')
    {
        $params = [
            'action' => $action,
        ];

        return Request::getInstance()->send(sprintf(self::MEMBERAUTH, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/basic-info-management/getAccountBasicInfo.html
     * @return mixed|void
     */
    public function getAccountBasicInfo()
    {
        return Request::getInstance()->send(sprintf(self::GET_ACCOUNT_BASIC_INFO, $this->service->getAccessTokenHandle()->authorizer_access_token));
    }

    /**
     * @link https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/qrcode-link/url-scheme/generateScheme.html
     * @param array $jump_wxa
     * @param bool $is_expire
     * @param int $expire_type
     * @param int $expire_interval
     * @return mixed|null
     */
    public function getScheme(array $jump_wxa, bool $is_expire = true, int $expire_type = 1, int $expire_interval = 30)
    {
        $params = compact('jump_wxa', 'is_expire', 'expire_type', 'expire_interval');
        return Request::getInstance()->send(sprintf(self::API_SUBSCRIBE_SEND, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/authorization-management/getAuthorizerInfo.html
     * @param $scene
     * @param $page
     * @param $width
     * @param $autoColor
     * @param $lineColor
     * @param $isHyaline
     * @param $envVersion
     * @return mixed|null
     */
    public function appCodeUnlimit($scene = '', $page = '', $width = 280, $autoColor = null, $lineColor = null, $isHyaline = false, $envVersion = 'release')
    {
        $params = [
            'scene' => $scene,
            'page' => $page,
            'width' => $width,
            'auto_color' => $autoColor,
            'line_color' => $lineColor,
            'is_hyaline' => $isHyaline,
            'env_version' => $envVersion,
        ];

        return Request::getInstance()->send(sprintf(self::API_GET_WXACODE_UNLIMIT, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/qrcode-link/qr-code/createQRCode.html
     * @param $path
     * @param $width
     * @return mixed|null
     */
    public function createQRCode($path, $width = 430)
    {
        $params = [
            'path' => $path,
            'width' => $width,
        ];

        return Request::getInstance()->send(sprintf(self::API_CREATE_QRCODE, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }
}