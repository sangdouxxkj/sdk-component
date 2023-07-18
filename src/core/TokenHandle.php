<?php

namespace Sangdou\Component\core;

use Sangdou\Component\component\TokenService;

class TokenHandle extends AbstractAPI implements AccessToken
{
    public function getComponentTokenHandle()
    {
        return TokenService::getInstance()->getComponentToken();
    }

    public function getAccessToken()
    {
    }
}