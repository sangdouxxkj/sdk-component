<?php

namespace Sangdou\Component\component;

use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;
use Sangdou\Component\core\Singleton;

class TokenService extends AbstractAPI
{
    use Singleton;

    public const API_COMPONENT_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';

    public const API_AUTHORIZER_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=%s';


    public function getComponentToken()
    {
        return Request::getInstance()->send(self::API_COMPONENT_TOKEN, [
            'component_appid' => $this->componentAppid,
            'component_appsecret' => $this->componentSecret,
            'component_verify_ticket' => $this->componentVerifyTicket,
        ]);
    }
}