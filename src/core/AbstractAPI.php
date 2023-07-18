<?php

namespace Sangdou\Component\core;

abstract class AbstractAPI
{

    protected $componentAppid;

    protected $componentSecret;

    protected $componentVerifyTicket;

    protected $authorizerAppid;

    protected $authorizerRefreshToken;

    /** @var $accessTokenHandle */
    protected $accessTokenHandle;
}