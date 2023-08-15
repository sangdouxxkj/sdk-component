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

    const TEMPLATE_NOT_FOUND = 85064;

    const TEMPLATE_LIST_IS_FULL = 85065;

    const USER_NOT_EXIST = 85001;
    const USER_BIND_LIMIT = 85002;
    const USER_BIND_MANY = 85003;
    const USER_ALREADY_BIND = 85004;

    public static function errMsg($errCode)
    {
        if ($errCode == self::CODE_SUCCESS) {
            return '';
        }
        switch ($errCode) {
            case self::TEMPLATE_NOT_FOUND:
                return '找不到模板';
            case self::TEMPLATE_LIST_IS_FULL:
                return '模板库已满';
            case self::USER_NOT_EXIST:
                return '微信号不存在或微信号设置为不可搜索';
            case self::USER_BIND_LIMIT:
                return '小程序绑定的体验者数量达到上限';
            case self::USER_BIND_MANY:
                return '微信号绑定的小程序体验者达到上限';
            case self::USER_ALREADY_BIND:
                return '微信号已经绑定';
            default:
                return '系统繁忙，此时请开发者稍候再试';
        }
    }
}