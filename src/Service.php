<?php

namespace Sangdou\Component;

use Sangdou\Component\component\TicketService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Constants;
use Sangdou\Component\core\Singleton;
use Sangdou\Component\core\TokenHandleTrait;

class Service extends AbstractAPI
{
    use Singleton;
    use TokenHandleTrait;

    /** @var $accessTokenType */
    protected $accessTokenType;

    public function __construct(array $config)
    {
        array_key_exists('component_appid', $config) && $this->componentAppid = $config['component_appid'];
        array_key_exists('component_appsecret', $config) && $this->componentSecret = $config['component_appsecret'];
        array_key_exists('component_verify_ticket', $config) && $this->componentVerifyTicket = $config['component_verify_ticket'];
        array_key_exists('authorizer_appid', $config) && $this->authorizerAppid = $config['authorizer_appid'];
        array_key_exists('authorizer_refresh_token', $config) && $this->authorizerRefreshToken = $config['authorizer_refresh_token'];
    }

    public function useComponentToken(): Service
    {
        $this->accessTokenType = Constants::ACCESS_TOKEN_COMPONENT;
        return $this;
    }

    public function useAccessToken(): Service
    {
        $this->accessTokenType = Constants::ACCESS_TOKEN_ACCESS;
        return $this;
    }

    private function currentAccessToken()
    {
        if (empty($this->componentAppid) && empty($this->authorizerAppid)) {
            throw new \RuntimeException('请求异常1');
        }

        switch ($this->accessTokenType) {
            case Constants::ACCESS_TOKEN_ACCESS:
                return $this->accessTokenHandle->getAccessToken();
            case Constants::ACCESS_TOKEN_COMPONENT:
                return $this->accessTokenHandle->getComponentTokenHandle();
            default:
                throw new \RuntimeException('请求异常2');
        }
    }

    /**
     * @description ticket服务
     * @return TicketService
     */
    public function ticket(): TicketService
    {
        return new TicketService($this->currentAccessToken());
    }
}