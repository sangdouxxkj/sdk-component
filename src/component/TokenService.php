<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\AccessToken;
use Sangdou\Component\core\Request;
use Sangdou\Component\core\Singleton;

/**
 * @method string component_access_token
 * @method string authorizer_access_token
 */
class TokenService extends AbstractAPI implements AccessToken
{
    use Singleton;

    public const API_COMPONENT_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';

    public const API_AUTHORIZER_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/component_access_token.html
     * @description 三方平台token
     * @return mixed|void
     */
    public function getComponentToken()
    {
        return Request::getInstance()->send(self::API_COMPONENT_TOKEN, [
            'component_appid' => $this->getComponentAppid(),
            'component_appsecret' => $this->getComponentAppsecret(),
            'component_verify_ticket' => $this->getComponentVerifyTicket(),
        ]);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/api_authorizer_token.html
     * @description 获取/刷新接口调用令牌
     * @return mixed|void
     */
    public function getAccessToken()
    {
        return Request::getInstance()->send(sprintf(self::API_AUTHORIZER_TOKEN, $this->getComponentAccessToken() ?? $this->service->accessTokenHandle->component_access_token), [
            'component_appid' => $this->getComponentAppid(),
            'authorizer_appid' => $this->getAuthorizerAppid(),
            'authorizer_refresh_token' => $this->getAuthorizerRefreshToken(),
        ]);
    }
}