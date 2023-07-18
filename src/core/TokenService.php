<?php

namespace Sangdou\Component\core;

class TokenService extends AbstractAPI implements AccessToken
{
    public const API_COMPONENT_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
    public const API_AUTHORIZER_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=%s';

    public function getComponentTokenHandle()
    {
        return Request::getInstance()->send(self::API_COMPONENT_TOKEN, [
            'component_appid' => $this->componentAppid,
            'component_appsecret' => $this->componentSecret,
            'component_verify_ticket' => $this->componentVerifyTicket,
        ]);
    }

    public function getAccessToken()
    {
        Request::getInstance()->send(self::API_AUTHORIZER_TOKEN, [
            'component_appid' => $this->componentAppid,
            'authorizer_appid' => $this->appid,
            'authorizer_refresh_token' => $this->authorizerRefreshToken,
        ]);
    }
}