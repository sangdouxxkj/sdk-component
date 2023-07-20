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

    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->options = $options;
    }

    public function useComponentToken(): ComponentService
    {
        $this->accessTokenType = Constants::ACCESS_TOKEN_COMPONENT;
        $this->currentAccessToken(Constants::ACCESS_TOKEN_COMPONENT);
        return $this;
    }

    public function useAccessToken(): ComponentService
    {
        $this->accessTokenType = Constants::ACCESS_TOKEN_ACCESS;
        return $this;
    }

    private function currentAccessToken()
    {
        if (empty($this->getComponentAppid()) && empty($this->getAuthorizerAppid())) {
            throw new \RuntimeException('请求异常1');
        }
        $this->tokenHandle = new TokenService($this->options);
        switch ($this->accessTokenType) {
            case Constants::ACCESS_TOKEN_ACCESS:
                $this->accessTokenHandle =  TokenService::getInstance()->getComponentToken();
                break;
            case Constants::ACCESS_TOKEN_COMPONENT:
                $this->accessTokenHandle = $this->tokenHandle->getComponentToken();
                break;
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
        return new TicketService($this->options, $this);
    }
}