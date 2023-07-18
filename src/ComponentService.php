<?php

namespace Sangdou\Component;

use Sangdou\Component\component\TicketService;
use Sangdou\Component\component\TokenService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Constants;
use Sangdou\Component\core\Singleton;
use Sangdou\Component\core\TokenHandleTrait;

class ComponentService extends AbstractAPI
{
    use Singleton;
    use TokenHandleTrait;

    /** @var $accessTokenType */
    protected $accessTokenType;

    public function __construct(array $config)
    {
        array_key_exists('component_appid', $config) && $this->setComponentAppid($config['component_appid']);
        array_key_exists('authorizer_appid', $config) && $this->setAuthorizerAppid($config['authorizer_appid']);
        array_key_exists('component_appsecret', $config) && $this->setComponentSecret($config['component_appsecret']);
        array_key_exists('component_verify_ticket', $config) && $this->setComponentVerifyTicket($config['component_verify_ticket']);
        array_key_exists('authorizer_refresh_token', $config) && $this->setAuthorizerRefreshToken($config['authorizer_refresh_token']);
    }

    /**
     * @param mixed $componentAppid
     */
    private function setComponentAppid($componentAppid): void
    {
        self::$componentAppid = $componentAppid;
    }

    /**
     * @param mixed $componentSecret
     */
    private function setComponentSecret($componentSecret): void
    {
        self::$componentSecret = $componentSecret;
    }

    /**
     * @param mixed $componentVerifyTicket
     */
    private function setComponentVerifyTicket($componentVerifyTicket): void
    {
        self::$componentVerifyTicket = $componentVerifyTicket;
    }

    /**
     * @param mixed $authorizerAppid
     */
    private function setAuthorizerAppid($authorizerAppid): void
    {
        self::$authorizerAppid = $authorizerAppid;
    }

    /**
     * @param mixed $authorizerRefreshToken
     */
    private function setAuthorizerRefreshToken($authorizerRefreshToken): void
    {
        self::$authorizerRefreshToken = $authorizerRefreshToken;
    }

    public function useComponentToken(): ComponentService
    {
        $this->accessTokenType = Constants::ACCESS_TOKEN_COMPONENT;
        $this->accessTokenHandle = TokenService::getInstance();
        return $this;
    }

    public function useAccessToken(): ComponentService
    {
        $this->accessTokenType = Constants::ACCESS_TOKEN_ACCESS;
        $this->accessTokenHandle = TokenService::getInstance();
        return $this;
    }

    private function currentAccessToken()
    {
        if (empty($this->getComponentAppid()) && empty($this->getAuthorizerAppid())) {
            throw new \RuntimeException('请求异常1');
        }

        switch ($this->accessTokenType) {
            case Constants::ACCESS_TOKEN_ACCESS:
                return TokenService::getInstance()->getComponentToken();
            case Constants::ACCESS_TOKEN_COMPONENT:
                return $this->accessTokenHandle->getComponentToken();
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