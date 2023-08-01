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

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/login/thirdpartyCode2Session.html
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
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/member-management/bindTester.html
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
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/member-management/unbindTester.html
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
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/member-management/getTester.html
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
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/basic-info-management/getAccountBasicInfo.html
     * @return mixed|void
     */
    public function getAccountBasicInfo()
    {
        return Request::getInstance()->send(sprintf(self::GET_ACCOUNT_BASIC_INFO, $this->service->getAccessTokenHandle()->authorizer_access_token));
    }
}