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

    public const WXA_COMMIT = 'https://api.weixin.qq.com/wxa/commit?access_token=%s';

    public const GET_QRCODE = 'https://api.weixin.qq.com/wxa/get_qrcode?access_token=%s';

    public const WXA_RELEASE = 'https://api.weixin.qq.com/wxa/release?access_token=%s';

    public const SUBMIT_AUDIT = 'https://api.weixin.qq.com/wxa/submit_audit?access_token=%s';

    public const UNDOCODE_AUDIT = 'https://api.weixin.qq.com/wxa/undocodeaudit?access_token=%s';

    public const REVERT_CODE_RELEASE = 'https://api.weixin.qq.com/wxa/revertcoderelease?access_token=%s';

    public const GET_LATEST_AUDITSTATUS = 'https://api.weixin.qq.com/wxa/get_latest_auditstatus?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/thirdparty-management/template-management/getTemplatedRaftList.html
     * @return mixed|void
     */
    public function getTemplateDraftList()
    {
        return Request::getInstance()->send(sprintf(self::GET_TEMPLATE_DRAFT_LIST, $this->service->getComponentTokenHandle()->component_access_token), [], Request::METHOD_GET);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/thirdparty-management/template-management/addToTemplate.html
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

        return Request::getInstance()->send(sprintf(self::ADD_TO_TEMPLATE, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/thirdparty-management/template-management/getTemplateList.html
     * @param int $template_type
     * @return mixed|void
     */
    public function getTemplateList(int $template_type = 0)
    {
        return Request::getInstance()->send(sprintf(self::GET_TEMPLATE_LIST, $this->service->getComponentTokenHandle()->component_access_token, $template_type), [], Request::METHOD_GET);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/thirdparty-management/template-management/deleteTemplate.html
     * @param int $template_id
     * @return mixed|void
     */
    public function deleteTemplate(int $template_id)
    {
        $params = [
            'template_id' => $template_id,
        ];

        return Request::getInstance()->send(sprintf(self::DELETE_TEMPLATE, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/code-management/commit.html
     * @param $template_id
     * @param $ext_json
     * @param $user_version
     * @param $user_desc
     * @return mixed|void
     */
    public function wxaCommit($template_id, $ext_json, $user_version, $user_desc)
    {
        $params = [
            'template_id' => $template_id,
            'ext_json' => $ext_json,
            'user_version' => $user_version,
            'user_desc' => $user_desc,
        ];

        return Request::getInstance()->send(sprintf(self::WXA_COMMIT, $this->service->getAccessTokenHandle()->authorizer_access_token), $params, Request::METHOD_POST, 15);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/code-management/getTrialQRCode.html
     * @param string $path
     * @param bool $getUrl
     * @return mixed|void
     */
    public function getQrcode(string $path = '', $getUrl = true)
    {
        $params = [];
        if (!empty($path)) {
            $params = [
                'path' => $path
            ];
        }

        if ($getUrl) {
            return sprintf(self::GET_QRCODE, $this->service->getAccessTokenHandle()->authorizer_access_token);
        }

        return Request::getInstance()->send(sprintf(self::GET_QRCODE, $this->service->getAccessTokenHandle()->authorizer_access_token), $params, Request::METHOD_GET);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/code-management/release.html
     * @return mixed|void
     */
    public function wxaRelease()
    {
        return Request::getInstance()->send(sprintf(self::WXA_RELEASE, $this->service->getAccessTokenHandle()->authorizer_access_token), new \stdClass());
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/code-management/submitAudit.html
     * @param $itemList
     * @return mixed|void
     */
    public function submitAudit($itemList)
    {
        $params = [
            'item_list' => $itemList['item_list'] ?? [],
            'feedback_info' => $itemList['feedback_info'] ?? '',
            'feedback_stuff' => $itemList['feedback_stuff'] ?? '',
            'preview_info' => $itemList['preview_info'] ?? [],
            'version_desc' => $itemList['version_desc'] ?? '',
            'ugc_declare' => $itemList['ugc_declare'] ?? [],
        ];

        return Request::getInstance()->send(sprintf(self::SUBMIT_AUDIT, $this->service->getAccessTokenHandle()->authorizer_access_token), $params, Request::METHOD_POST, 15);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/code-management/revertCodeRelease.html
     * @return mixed|void
     */
    public function revertCodeRelease($appVersion = '', $action = 'get_history_version')
    {
        $params = [
            'action' => $action,
            'app_version' => $appVersion,
        ];

        return Request::getInstance()->send(sprintf(self::REVERT_CODE_RELEASE, $this->service->getAccessTokenHandle()->authorizer_access_token), array_filter($params), Request::METHOD_GET);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/code-management/undoAudit.html
     * @param int $template_type
     * @return mixed|void
     */
    public function unDoCodeAudit()
    {
        return Request::getInstance()->send(sprintf(self::UNDOCODE_AUDIT, $this->service->getComponentTokenHandle()->component_access_token), [], Request::METHOD_GET);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/code-management/getLatestAuditStatus.html
     * @return mixed|void
     */
    public function getLatestAuditstatus()
    {
        return Request::getInstance()->send(sprintf(self::GET_LATEST_AUDITSTATUS, $this->service->getAccessTokenHandle()->authorizer_access_token), [], Request::METHOD_GET);
    }
}