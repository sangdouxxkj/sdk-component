<?php

namespace Sangdou\Component\component;

use Sangdou\Component\core\AbstractAPI;

class TicketService extends AbstractAPI
{
    public const API_START_PUSH_TICKET = 'https://api.weixin.qq.com/cgi-bin/component/api_start_push_ticket';

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/ticket-token/startPushTicket.html
     * @param $component_appid
     * @param $component_secret
     * @return array|false
     */
    public function apiStartPushTicket($component_appid, $component_secret)
    {
        $params = [
            'component_appid' => $component_appid,
            'component_secret' => $component_secret,
        ];

        return $this->doRequest(self::API_START_PUSH_TICKET, $params);
    }
}