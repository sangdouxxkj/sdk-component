<?php

namespace Sangdou\Component\core;

abstract class AbstractAPI
{
    /**
     * Http instance.
     *
     */
    protected $http;

    /**
     * The request token.
     *
     */
    protected $accessToken;

    const GET = 'get';
    const POST = 'post';
    const JSON = 'json';

    /**
     * Constructor.
     */
    public function __construct($accessToken)
    {
        $this->setAccessToken($accessToken);
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }
}