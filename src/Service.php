<?php

namespace Sangdou\Component;

use Sangdou\Component\component\TicketService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Constants;
use Sangdou\Component\core\TokenHandleTrait;

class Service extends AbstractAPI
{
    use TokenHandleTrait;

    /** @var Service */
    protected static $instance;

    /** @var $accessTokenType */
    protected $accessTokenType;

    public static function getInstance(): Service
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setComponentAppId($componentAppid): Service
    {
        $this->componentAppid = $componentAppid;
        return $this;
    }

    public function setComponentSecret($componentSecret): Service
    {
        $this->componentSecret = $componentSecret;
        return $this;
    }

    public function setComponentVerifyTicket($componentVerifyTicket): Service
    {
        $this->componentVerifyTicket = $componentVerifyTicket;
        return $this;
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

    public function currentAccessToken()
    {
        if (empty($this->componentAppid) && empty($this->appid)) {
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