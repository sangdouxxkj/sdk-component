<?php

namespace Sangdou\Component\core;

interface AccessToken
{
    public function getComponentTokenHandle();

    public function getAccessToken();
}