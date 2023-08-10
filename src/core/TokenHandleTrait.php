<?php

namespace Sangdou\Component\core;

trait TokenHandleTrait
{
    public $tokenHandle;

    public function getComponentTokenHandle()
    {
        if (empty($this->tokenHandle)) {
            throw new \RuntimeException(ErrCode::CODE_COMPONENT_TOKEN_ERR);
        }
        if (empty($this->getComponentAccessToken())) {
            $componentToken = $this->tokenHandle->getComponentToken();
        } else {
            $componentToken = new \stdClass();
            $componentToken->component_access_token = $this->getComponentAccessToken();
        }
        if (empty($componentToken)) {
            throw new \RuntimeException(ErrCode::CODE_COMPONENT_TOKEN_NOT_FOUND);
        }
        return $componentToken;
    }

    public function getAccessTokenHandle()
    {
        if (empty($this->tokenHandle)) {
            throw new \RuntimeException(ErrCode::CODE_ACCESS_TOKEN_ERR);
        }
        if (empty($this->getAuthorizerAccessToken())) {
            $accessToken = $this->tokenHandle->getAccessToken();
        } else {
            $accessToken = new \stdClass();
            $accessToken->authorizer_access_token = $this->getAuthorizerAccessToken();
        }
        if (empty($accessToken)) {
            throw new \RuntimeException(ErrCode::CODE_ACCESS_TOKEN_NOT_FOUND);
        }
        return $accessToken;
    }
}