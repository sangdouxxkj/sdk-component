<?php

namespace Sangdou\Component\component;

use Sangdou\Component\ComponentService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Request;

class WxopenService extends AbstractAPI
{
    public const QRCODE_JUMP_GET = "https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpget?access_token=%s";

    public const QRCODE_JUMP_ADD = "https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpadd?access_token=%s";

    public const QRCODE_JUMP_PUBLISH = "https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumppublish?access_token=%s";

    public const QRCODE_JUMP_DELETE = "https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpdelete?access_token=%s";

    public const QRCODE_JUMP_DOWNLOAD = "https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpdownload?access_token=%s";

    public function __construct(array $options, ComponentService $service)
    {
        parent::__construct($options);
        $this->service = $service;
    }

    /**
     * 获取已设置的二维码规则
     * @param int $page_num 页码，get_type=2 必传，从 1 开始。获取“扫服务号二维码打开小程序”已设置的二维码规则才需要传这个参数。
     * @param int $page_size 每页数量，get_type=2 必传，最大为 200。获取“扫服务号二维码打开小程序”已设置的二维码规则才需要传这个参数。
     * @param int $get_type 默认值为0。 0：查询最近新增 10000 条（数量大建议用1或者2）；1：prefix查询；2：分页查询，按新增顺序返回。获取“扫服务号二维码打开小程序”已设置的二维码规则才需要传这个参数。
     * @param string $appid 小程序的appid。获取“扫服务号二维码打开小程序”已设置的二维码规则才需要传这个参数。
     * @param array|null $prefix_list prefix查询，get_type=1 必传，最多传 200 个前缀。获取“扫服务号二维码打开小程序”已设置的二维码规则才需要传这个参数。
     * @return mixed|null
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/jumpqrcode-config/getJumpQRCode.html
     */
    public function qrcodejumpget(int $page_num = 1, int $page_size = 10, int $get_type = 0, string $appid = '', array $prefix_list = null)
    {
        $params = [
            'page_num' => $page_num,
            'page_size' => $page_size,
            'get_type' => $get_type,
        ];

        if ($get_type == 1) {
            $params['prefix_list'] = $prefix_list;
        }

        if (! empty($appid)) {
            $params['appid'] = $appid;
        }

        return Request::getInstance()->send(sprintf(self::QRCODE_JUMP_GET, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }

    /**
     * 增加或修改二维码规则
     * @param string $prefix 二维码规则。
     * @param string $path 小程序功能页面。
     * @param int $open_version 测试范围。1表示开发版（配置只对开发者生效）；2表示体验版（配置对管理员、体验者生效)；3表示正式版（配置对开发者、管理员和体验者生效）。增加或修改“扫普通二维码打开小程序”的二维码规则才需要传这个参数。
     * @param array $debug_url 测试链接，至多 5 个用于测试的二维码完整链接，此链接必须符合已填写的二维码规则。增加或修改“扫普通二维码打开小程序”的二维码规则才需要传这个参数。
     * @param int $is_edit 编辑标志位，0 表示新增二维码规则，1 表示修改已有二维码规则。
     * @param string $appid 扫了服务号二维码之后要跳转的小程序的appid。增加或修改“扫服务号二维码打开小程序”的二维码规则才需要传这个参数。
     * @param int $permit_sub_rule 是否独占符合二维码前缀匹配规则的所有子规 1 为不占用，2 为占用。增加或修改“扫普通二维码打开小程序”的二维码规则才需要传这个参数。
     * @return mixed|null
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/jumpqrcode-config/addJumpQRCode.html
     */
    public function qrcodejumpadd(string $prefix, string $path, int $open_version, array $debug_url = [], int $is_edit = 0, string $appid = '', int $permit_sub_rule = 1)
    {
        $params = [
            'prefix' => $prefix,
            'path' => $path,
            'open_version' => $open_version,
            'permit_sub_rule' => $permit_sub_rule,
            'is_edit' => $is_edit,
        ];

        if (! empty($debug_url)) {
            $params['debug_url'] = $debug_url;
        }

        if (! empty($appid)) {
            $params['appid'] = $appid;
        }

        return Request::getInstance()->send(sprintf(self::QRCODE_JUMP_ADD, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }

    /**
     * 发布已设置的二维码规则
     * @param string $prefix 二维码规则。如果是服务号，则是服务号的带参的二维码url。
     * @return mixed|null
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/jumpqrcode-config/publishJumpQRCode.html
     */
    public function publishJumpQRCode(string $prefix)
    {
        $params = [
            'prefix' => $prefix,
        ];

        return Request::getInstance()->send(sprintf(self::QRCODE_JUMP_PUBLISH, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }

    /**
     * 删除已设置的二维码规则
     * @param string $prefix 二维码规则
     * @param string $appid 小程序appid。删除“扫服务号二维码打开小程序”的二维码规则才需要传这个参数。
     * @return mixed|null
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/jumpqrcode-config/deleteJumpQRCode.html
     */
    public function deleteJumpQRCode(string $prefix, string $appid = '')
    {
        $params = [
            'prefix' => $prefix,
        ];

        if (! empty($appid)) {
            $params['appid'] = $appid;
        }

        return Request::getInstance()->send(sprintf(self::QRCODE_JUMP_DELETE, $this->service->getComponentTokenHandle()->component_access_token), $params);
    }

    /**
     * 获取校验文件名称及内容
     * @return mixed|null
     * @link https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/jumpqrcode-config/downloadQRCodeText.html
     */
    public function downloadQRCodeText()
    {
        return Request::getInstance()->send(sprintf(self::QRCODE_JUMP_DOWNLOAD, $this->service->getComponentTokenHandle()->component_access_token));
    }
}
