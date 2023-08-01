<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class OpenAccountService extends AbstractAPI
{
    const BIND_OPEN_ACCOUNT = 'https://api.weixin.qq.com/cgi-bin/open/bind?access_token=%s';

    const UNBIND_OPEN_ACCOUNT = 'https://api.weixin.qq.com/cgi-bin/open/unbind?access_token=%s';

    const GET_OPEN_ACCOUNT = 'https://api.weixin.qq.com/cgi-bin/open/get?access_token=%s';

    const CREATE_OPEN_ACCOUNT = 'https://api.weixin.qq.com/cgi-bin/open/create?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/openplatform-management/bindOpenAccount.html
     * @param $open_appid
     * @return mixed|void
     */
    public function bindOpenAccount($open_appid)
    {
        $params = [
            'open_appid' => $open_appid,
        ];

        return Request::getInstance()->send(sprintf(self::BIND_OPEN_ACCOUNT, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/openplatform-management/unbindOpenAccount.html
     * @param $open_appid
     * @return mixed|void
     */
    public function unBindOpenAccount($open_appid)
    {
        $params = [
            'open_appid' => $open_appid,
        ];

        return Request::getInstance()->send(sprintf(self::UNBIND_OPEN_ACCOUNT, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/openplatform-management/getOpenAccount.html
     * @param $open_appid
     * @return mixed|void
     */
    public function getOpenAccount($open_appid)
    {
        return Request::getInstance()->send(sprintf(self::GET_OPEN_ACCOUNT, $this->service->getAccessTokenHandle()->authorizer_access_token));
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/openplatform-management/createOpenAccount.html
     * @return mixed|void
     */
    public function createOpenAccount()
    {
        return Request::getInstance()->send(sprintf(self::CREATE_OPEN_ACCOUNT, $this->service->getAccessTokenHandle()->authorizer_access_token));
    }
}