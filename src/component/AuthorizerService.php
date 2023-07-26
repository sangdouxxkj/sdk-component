<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class AuthorizerService extends AbstractAPI
{
    public const API_GET_AUTHORIZER_INFO = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/authorization-management/getAuthorizerInfo.html
     * @param string $authorizer_appid
     * @return mixed|void
     */
    public function getAuthorizerInfo(string $authorizer_appid)
    {
        $params = [
            'component_appid' => $this->service->getComponentAppid(),
            'authorizer_appid' => $authorizer_appid
        ];

        return Request::getInstance()->send(sprintf(self::API_GET_AUTHORIZER_INFO, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }
}