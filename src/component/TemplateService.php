<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class TemplateService extends AbstractAPI
{
    public const GET_TEMPLATE_DRAFT_LIST = 'https://api.weixin.qq.com/wxa/gettemplatedraftlist?access_token=%s';

    public const ADD_TO_TEMPLATE = 'https://api.weixin.qq.com/wxa/addtotemplate?access_token=%s';

    public const GET_TEMPLATE_LIST = 'https://api.weixin.qq.com/wxa/gettemplatelist?access_token=%s&template_type=%d';

    public const DELETE_TEMPLATE = 'https://api.weixin.qq.com/wxa/deletetemplate?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/thirdparty-management/template-management/getTemplatedRaftList.html
     * @return mixed|void
     */
    public function getTemplateDraftList()
    {
        return Request::getInstance()->send(sprintf(self::GET_TEMPLATE_DRAFT_LIST, $this->service->getComponentTokenHandle()->component_access_token), [], Request::METHOD_GET);
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/thirdparty-management/template-management/addToTemplate.html
     * @param $draft_id
     * @param int $template_type
     * @return mixed|void
     */
    public function addToTemplate($draft_id, int $template_type = 0)
    {
        $params = [
            'draft_id' => $draft_id,
            'template_type' => $template_type,
        ];

        return Request::getInstance()->send(self::ADD_TO_TEMPLATE, $params);
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/thirdparty-management/template-management/getTemplateList.html
     * @param int $template_type
     * @return mixed|void
     */
    public function getTemplateList(int $template_type = 0)
    {
        return Request::getInstance()->send(sprintf(self::GET_TEMPLATE_LIST, $this->service->getComponentTokenHandle()->component_access_token, $template_type), [], Request::METHOD_GET);
    }

    /**
     * @see https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/thirdparty-management/template-management/deleteTemplate.html
     * @param int $template_id
     * @return mixed|void
     */
    public function deleteTemplate(int $template_id)
    {
        $params = [
            'template_id' => $template_id,
        ];

        return Request::getInstance()->send(self::DELETE_TEMPLATE, $params);
    }
}