<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class TicketService extends AbstractAPI
{
    public const API_START_PUSH_TICKET = 'https://api.weixin.qq.com/cgi-bin/component/api_start_push_ticket';

    public const API_CREATE_PREAUTHCODE = 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?access_token=%s';

    public const API_QUERY_AUTH = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=%s';

    public const QUOTA_GET = 'https://api.weixin.qq.com/cgi-bin/openapi/quota/get?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/ticket-token/startPushTicket.html
     * @return array|false
     */
    public function apiStartPushTicket()
    {
        $params = [
            'component_appid' => $this->service->getComponentAppid(),
            'component_secret' => $this->service->getComponentAppsecret(),
        ];

        return Request::getInstance()->send(self::API_START_PUSH_TICKET, $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/ticket-token/getPreAuthCode.html
     * @return mixed|void
     */
    public function apiCreatePreauthcode()
    {
        $params = [
            'component_appid' => $this->service->getComponentAppid(),
        ];
        return Request::getInstance()->send(sprintf(self::API_CREATE_PREAUTHCODE, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/ThirdParty/token/authorization_info.html
     * @param $authorization_code
     * @return mixed|void
     */
    public function apiQueryAuth($authorization_code)
    {
        $params = [
            'component_appid' => $this->service->getComponentAppid(),
            'authorization_code' => $authorization_code,
        ];

        return Request::getInstance()->send(sprintf(self::API_QUERY_AUTH, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/openapi/getApiQuota.html
     * @param $cgi_path
     * @param $type 1 第三方平台;2 小程序; 3 公众号
     * @return mixed|void
     * @throws \Exception
     */
    public function quotaGet($cgi_path, $type = 1)
    {
        $params = [
            'cgi_path' => $cgi_path,
        ];

        switch ($type) {
            case 1:
                $accessToken = $this->service->getComponentTokenHandle()->component_access_token;
                break;
            case 2:
                $accessToken = $this->service->getAccessTokenHandle()->authorizer_access_token;
                break;
            default :
                throw new \Exception('缺失token');
        }

        return Request::getInstance()->send(sprintf(self::QUOTA_GET, $accessToken), $params);
    }
}