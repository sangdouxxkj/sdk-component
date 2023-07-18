<?php

namespace Sangdou\Component\core;

abstract class AbstractAPI
{

    protected static $componentAppid;

    protected static $componentSecret;

    protected static $componentVerifyTicket;

    protected static $authorizerAppid;

    protected static $authorizerRefreshToken;

    /** @var $accessTokenHandle */
    protected $accessTokenHandle;

    /**
     * @return mixed
     */
    public function getComponentAppid()
    {
        return self::$componentAppid;
    }

    /**
     * @return mixed
     */
    public function getComponentSecret()
    {
        return self::$componentSecret;
    }

    /**
     * @return mixed
     */
    public function getComponentVerifyTicket()
    {
        return self::$componentVerifyTicket;
    }

    /**
     * @return mixed
     */
    public function getAuthorizerAppid()
    {
        return self::$authorizerAppid;
    }

    /**
     * @return mixed
     */
    public function getAuthorizerRefreshToken()
    {
        return self::$authorizerRefreshToken;
    }
}