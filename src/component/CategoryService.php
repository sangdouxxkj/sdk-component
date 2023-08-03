<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class CategoryService extends AbstractAPI
{
    public const GET_CATEGORY = 'https://api.weixin.qq.com/cgi-bin/wxopen/getcategory?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/category-management/getSettingCategories.html
     * @return mixed|void
     */
    public function getCategory()
    {
        return Request::getInstance()->send(sprintf(self::GET_CATEGORY, $this->service->getAccessTokenHandle()->authorizer_access_token), [], Request::METHOD_GET);
    }
}