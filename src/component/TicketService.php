<?php

namespace Sangdou\Component\component;

use Sangdou\Component\core\AbstractAPI;

class TicketService extends AbstractAPI
{
    private $accessToken;

    public const API_START_PUSH_TICKET = 'https://api.weixin.qq.com/cgi-bin/component/api_start_push_ticket';

    public const API_CREATE_PREAUTHCODE = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?access_token=%s';

    public function __construct($accessToken)
    {
        parent::__construct();
        $this->accessToken = $accessToken;
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

        return $this->doRequest(self::API_START_PUSH_TICKET, $params);
    }

    public function apiCreatePreauthcode($component_appid)
    {
        $params = [
            'component_appid' => $this->componentAppid,
        ];

        return $this->doRequest(sprintf(self::API_CREATE_PREAUTHCODE, $this->accessToken), $params);
    }
}