<?php

namespace Sangdou\Component\core;

abstract class AbstractAPI
{
    protected $options;

    protected $componentAppid;

    protected $componentSecret;

    protected $componentVerifyTicket;

    protected $authorizerAppid;

    protected $authorizerRefreshToken;

    /** @var $accessTokenHandle */
    protected $accessTokenHandle;

    protected $authorizerAccessToken;

    protected $componentAccessToken;

    protected $service;

    protected function __construct($options)
    {
        foreach ($options as $option => $value) {
            (method_exists(self::class, $this->convertToCamelCase($option)) && empty($this->{$this->convertToCamelCase($option, 'get')}())) && $this->{$this->convertToCamelCase($option)}($value);
        }
    }

    private function convertToCamelCase($inputString, $pre = 'set'): string
    {
        $words = explode('_', $inputString);
        $camelCaseWords = array_map('ucfirst', $words);
        return $pre . implode('', $camelCaseWords);
    }

    /**
     * @return mixed
     */
    protected function getComponentAppid()
    {
        return $this->componentAppid;
    }

    /**
     * @param mixed $componentAppid
     */
    protected function setComponentAppid($componentAppid): void
    {
        $this->componentAppid = $componentAppid;
    }

    /**
     * @return mixed
     */
    protected function getComponentAppsecret()
    {
        return $this->componentSecret;
    }

    /**
     * @return mixed
     */
    protected function getComponentVerifyTicket()
    {
        return $this->componentVerifyTicket;
    }

    /**
     * @return mixed
     */
    protected function getAuthorizerAppid()
    {
        return $this->authorizerAppid;
    }

    /**
     * @return mixed
     */
    protected function getAuthorizerRefreshToken()
    {
        return $this->authorizerRefreshToken;
    }

    /**
     * @param mixed $componentSecret
     */
    protected function setComponentappsecret($componentSecret): void
    {
        $this->componentSecret = $componentSecret;
    }

    /**
     * @param mixed $componentVerifyTicket
     */
    protected function setComponentVerifyTicket($componentVerifyTicket): void
    {
        $this->componentVerifyTicket = $componentVerifyTicket;
    }

    /**
     * @param mixed $authorizerAppid
     */
    protected function setAuthorizerAppid($authorizerAppid): void
    {
        $this->authorizerAppid = $authorizerAppid;
    }

    /**
     * @param mixed $authorizerRefreshToken
     */
    protected function setAuthorizerRefreshToken($authorizerRefreshToken): void
    {
        $this->authorizerRefreshToken = $authorizerRefreshToken;
    }

    /**
     * @return mixed
     */
    public function getAuthorizerAccessToken()
    {
        return $this->authorizerAccessToken;
    }

    /**
     * @param mixed $authorizerAccessToken
     */
    public function setAuthorizerAccessToken($authorizerAccessToken): void
    {
        $this->authorizerAccessToken = $authorizerAccessToken;
    }

    /**
     * @return mixed
     */
    public function getComponentAccessToken()
    {
        return $this->componentAccessToken;
    }

    /**
     * @param mixed $componentAccessToken
     */
    public function setComponentAccessToken($componentAccessToken): void
    {
        $this->componentAccessToken = $componentAccessToken;
    }
}