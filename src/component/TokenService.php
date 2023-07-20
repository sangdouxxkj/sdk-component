<?php

namespace Sangdou\Component\component;

use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;
use Sangdou\Component\core\Singleton;

/**
 * @method string component_access_token
 */
class TokenService extends AbstractAPI
{
    use Singleton;

    public const API_COMPONENT_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';

    public const API_AUTHORIZER_TOKEN = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=%s';

    public function __construct($options)
    {
        parent::__construct($options);
    }

    public function getComponentToken()
    {
        return Request::getInstance()->send(self::API_COMPONENT_TOKEN, [
            'component_appid' => $this->getComponentAppid(),
            'component_appsecret' => $this->getComponentSecret(),
            'component_verify_ticket' => $this->getComponentVerifyTicket(),
        ]);
    }
}