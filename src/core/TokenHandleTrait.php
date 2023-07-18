<?php

namespace Sangdou\Component\core;

trait TokenHandleTrait
{
    private $tokenHandle;

    private function getComponentTokenHandle()
    {
        if (empty($this->tokenHandle)) {
            throw new \RuntimeException(ErrCode::CODE_COMPONENT_TOKEN_ERR);
        }

        $componentToken = $this->tokenHandle->getComponentToken();
        if (empty($componentToken)) {
            throw new \RuntimeException(ErrCode::CODE_COMPONENT_TOKEN_NOT_FOUND);
        }
        return $componentToken;
    }

    public function getAccessToken()
    {
        if (empty($this->tokenHandle)) {
            throw new \RuntimeException(ErrCode::CODE_ACCESS_TOKEN_ERR);
        }

        $accessToken = $this->tokenHandle->getAccessToken();
        if (empty($accessToken)) {
            throw new \RuntimeException(ErrCode::CODE_ACCESS_TOKEN_NOT_FOUND);
        }
        return $accessToken;
    }
}