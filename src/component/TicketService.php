<?php

namespace Sangdou\Component\component;

use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\AccessToken;
use Sangdou\Component\core\Request;
use Sangdou\Component\core\TokenHandleTrait;

class TicketService extends AbstractAPI
{
    use TokenHandleTrait;

    public const API_START_PUSH_TICKET = 'https://api.weixin.qq.com/cgi-bin/component/api_start_push_ticket';

    public const API_CREATE_PREAUTHCODE = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?access_token=%s';

    public function __construct(AccessToken $accessToken)
    {
        $this->tokenHandle = $accessToken;
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/ticket-token/startPushTicket.html
     * @return array|false
     */
    public function apiStartPushTicket()
    {
        $params = [
            'component_appid' => $this->componentAppid,
            'component_secret' => $this->componentSecret,
        ];

        return Request::getInstance()->send(self::API_START_PUSH_TICKET, $params);
    }

    public function apiCreatePreauthcode()
    {
        $params = [
            'component_appid' => $this->componentAppid,
        ];
        return Request::getInstance()->send(self::API_CREATE_PREAUTHCODE, $params);
    }
}