<?php

namespace Sangdou\Component\component;

use Sangdou\Component\core\AbstractAPI;

class TicketService extends AbstractAPI
{
    public const API_START_PUSH_TICKET = 'https://api.weixin.qq.com/cgi-bin/component/api_start_push_ticket';

    const API_CREATE_PREAUTHCODE = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?access_token=%s';

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

    public function apiCreatePreauthcode($component_appid)
    {
        $params = [
            'component_appid' => $component_appid,
        ];

        return $this->doRequest(self::API_CREATE_PREAUTHCODE, $params);
    }
}