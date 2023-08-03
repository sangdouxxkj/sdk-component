<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class PrivacySettingService extends AbstractAPI
{
    const SET_PRIVACY_SETTING = 'https://api.weixin.qq.com/cgi-bin/component/setprivacysetting?access_token=%s';
    const GET_PRIVACY_SETTING = 'https://api.weixin.qq.com/cgi-bin/component/getprivacysetting?access_token=%s';
    const UPLOAD_PRIVACY_SETTING = 'https://api.weixin.qq.com/cgi-bin/component/uploadprivacyextfile?access_token=%s';
    const APPLY_PRIVACY_INTERFACE = 'https://api.weixin.qq.com/wxa/security/apply_privacy_interface?access_token=%s';
    const GET_PRIVACY_INTERFACE ='https://api.weixin.qq.com/wxa/security/get_privacy_interface?access_token=%s';

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/privacy-management/setPrivacySetting.html
     * @param $args
     * @return mixed|void
     */
    public function setPrivacySetting($args)
    {
        $params = [
            'owner_setting' => $args['owner_setting'] ?? [],
            'setting_list' => $args['setting_list'] ?? [],
            'privacy_ver' => $args['privacy_ver'] ?? 2,
        ];

        return Request::getInstance()->send(sprintf(self::SET_PRIVACY_SETTING, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/privacy-management/getPrivacySetting.html
     * @param $privacy_ver
     * @return mixed|void
     */
    public function getPrivacySetting($privacy_ver = 2)
    {
        $params = [
            'privacy_ver' => $privacy_ver,
        ];
        return Request::getInstance()->send(sprintf(self::GET_PRIVACY_SETTING, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/privacy-management/uploadPrivacySetting.html
     * @param $file
     * @return mixed|void
     */
    public function uploadPrivacyExtFile($file)
    {
        $params = [
            'file' => $file,
        ];
        return Request::getInstance()->send(sprintf(self::UPLOAD_PRIVACY_SETTING, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/privacy-api-management/applyPrivacyInterface.html
     * @param $api_name
     * @param $content
     * @param $url_list
     * @param $pic_list
     * @param $video_list
     * @return mixed|void
     */
    public function applyPrivacyInterface($api_name, $content, $url_list =[], $pic_list = [], $video_list= [])
    {
        $params = [
            'api_name' => $api_name,
            'content' => $content,
            'url_list' => $url_list,
            'pic_list' => $pic_list,
            'video_list' => $video_list,
        ];
        return Request::getInstance()->send(sprintf(self::APPLY_PRIVACY_INTERFACE, $this->service->getAccessTokenHandle()->authorizer_access_token), $params);
    }

    /**
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/privacy-api-management/getPrivacyInterface.html
     * @return mixed|void
     */
    public function getPrivacyInterface()
    {
        return Request::getInstance()->send(sprintf(self::APPLY_PRIVACY_INTERFACE, $this->service->getAccessTokenHandle()->authorizer_access_token), [], Request::METHOD_GET);
    }
}