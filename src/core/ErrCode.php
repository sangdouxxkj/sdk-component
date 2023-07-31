<?php

namespace Sangdou\Component\core;

class ErrCode
{
    public const CODE_COMPONENT_TOKEN_ERR = -1;

    public const CODE_COMPONENT_TOKEN_NOT_FOUND = -10;

    public const CODE_ACCESS_TOKEN_ERR = -2;

    public const CODE_ACCESS_TOKEN_NOT_FOUND = -20;

    // 构建curl实例失败
    public const EXCEPTION_CODE_BUILD = -30;

    // curl发生错误
    public const EXCEPTION_CODE_CURL = -31;

    // 返回的不是合法json字符串
    public const EXCEPTION_CODE_JSON = -32;

    // 微信接口返回错误
    const EXCEPTION_CODE_WECHAT = -99;

    // 请求成功
    const CODE_SUCCESS = 0;
}