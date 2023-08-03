<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class AuthorizerService extends AbstractAPI
{
    public const API_GET_AUTHORIZER_INFO = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?access_token=%s';
    public const SET_AUTHORIZER_OPTION = 'https://api.weixin.qq.com/cgi-bin/component/set_authorizer_option?access_token=%s';
    public const GET_AUTHORIZER_OPTION = 'https://api.weixin.qq.com/cgi-bin/component/get_authorizer_option?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/authorization-management/getAuthorizerInfo.html
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

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/authorization-management/setAuthorizerOptionInfo.html
     * @param $option_name
     * @param $option_value
     * @return mixed|void
     */
    public function setAuthorizerOption($option_name, $option_value)
    {
        $params = [
            'option_name' => $option_name,
            'option_value' => $option_value,
        ];

        return Request::getInstance()->send(sprintf(self::SET_AUTHORIZER_OPTION, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/authorization-management/getAuthorizerOptionInfo.html
     * @param $option_name
     * @return mixed|void
     */
    public function getAuthorizerOption($option_name)
    {
        $params = [
            'option_name' => $option_name,
        ];

        return Request::getInstance()->send(sprintf(self::GET_AUTHORIZER_OPTION, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }
}