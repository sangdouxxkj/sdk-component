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

    public function __construct($options)
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
    public function getComponentAppid()
    {
        return $this->componentAppid;
    }

    /**
     * @param mixed $componentAppid
     */
    public function setComponentAppid($componentAppid): void
    {
        $this->componentAppid = $componentAppid;
    }

    /**
     * @return mixed
     */
    public function getComponentsecret()
    {
        return $this->componentSecret;
    }

    /**
     * @return mixed
     */
    public function getComponentVerifyTicket()
    {
        return $this->componentVerifyTicket;
    }

    /**
     * @return mixed
     */
    public function getAuthorizerAppid()
    {
        return $this->authorizerAppid;
    }

    /**
     * @return mixed
     */
    public function getAuthorizerRefreshToken()
    {
        return $this->authorizerRefreshToken;
    }

    /**
     * @param mixed $componentSecret
     */
    private function setComponentappsecret($componentSecret): void
    {
        $this->componentSecret = $componentSecret;
    }

    /**
     * @param mixed $componentVerifyTicket
     */
    private function setComponentVerifyTicket($componentVerifyTicket): void
    {
        $this->componentVerifyTicket = $componentVerifyTicket;
    }

    /**
     * @param mixed $authorizerAppid
     */
    private function setAuthorizerAppid($authorizerAppid): void
    {
        $this->authorizerAppid = $authorizerAppid;
    }

    /**
     * @param mixed $authorizerRefreshToken
     */
    private function setAuthorizerRefreshToken($authorizerRefreshToken): void
    {
        $this->authorizerRefreshToken = $authorizerRefreshToken;
    }
}