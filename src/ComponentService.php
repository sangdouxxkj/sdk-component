<?php

namespace Sangdou\Component;

use Sangdou\Component\component\AuthorizerService;
use Sangdou\Component\component\CategoryService;
use Sangdou\Component\component\OpenAccountService;
use Sangdou\Component\component\PrivacySettingService;
use Sangdou\Component\component\TemplateService;
use Sangdou\Component\component\TicketService;
use Sangdou\Component\component\TokenService;
use Sangdou\Component\component\WxaService;
use Sangdou\Component\component\WxopenService;
use Sangdou\Component\core\AbstractAPI;
use Sangdou\Component\core\Constants;
use Sangdou\Component\core\Singleton;
use Sangdou\Component\core\TokenHandleTrait;

class ComponentService extends AbstractAPI
{
    use Singleton;
    use TokenHandleTrait;

    /** @var $accessTokenType */
    protected $accessTokenType;

    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->options = $options;
    }

    public function useComponentToken(): ComponentService
    {
        $this->accessTokenType = Constants::ACCESS_TOKEN_COMPONENT;
        $this->currentAccessToken();
        return $this;
    }

    public function useAccessToken(): ComponentService
    {
        $this->accessTokenType = Constants::ACCESS_TOKEN_ACCESS;
        $this->currentAccessToken();
        return $this;
    }

    private function currentAccessToken()
    {
        if (empty($this->getComponentAppid()) && empty($this->getAuthorizerAppid())) {
            throw new \RuntimeException('请求异常1');
        }
        $this->tokenHandle = new TokenService($this->options, $this);
        switch ($this->accessTokenType) {
            case Constants::ACCESS_TOKEN_ACCESS:
                if (!empty($this->getAuthorizerAccessToken())) {
                    $this->accessTokenHandle = new \stdClass();
                    $this->accessTokenHandle->authorizer_access_token = $this->getAuthorizerAccessToken();
                    $this->accessTokenHandle->authorizer_refresh_token = $this->getAuthorizerRefreshToken();
                } else {
                    $this->accessTokenHandle = $this->tokenHandle->getAccessToken();
                }
                break;
            case Constants::ACCESS_TOKEN_COMPONENT:
                if (!empty($this->getComponentAccessToken())) {
                    $this->accessTokenHandle = new \stdClass();
                    $this->accessTokenHandle->component_access_token = $this->getComponentAccessToken();
                    $this->accessTokenHandle->expires_in = $this->getComponentAccessTokenExpiresIn();
                } else {
                    $this->accessTokenHandle = $this->tokenHandle->getComponentToken();
                    $this->setComponentAccessToken($this->accessTokenHandle->component_access_token);
                    $this->setComponentAccessTokenExpiresIn($this->accessTokenHandle->expires_in);
                }
                break;
            default:
                throw new \RuntimeException('请求异常2');
        }
    }

    /**
     * @description ticket服务
     * @return TicketService
     */
    public function ticket(): TicketService
    {
        return new TicketService($this->options, $this);
    }

    /**
     * @description 授权账号管理
     * @return AuthorizerService
     */
    public function authorizer(): AuthorizerService
    {
        return new AuthorizerService($this->options, $this);
    }

    /**
     * @description 小程序代调用接口
     * @return WxaService
     */
    public function wxa(): WxaService
    {
        return new WxaService($this->options, $this);
    }

    /**
     * @description 小程序代码
     * @return TemplateService
     */
    public function template(): TemplateService
    {
        return new TemplateService($this->options, $this);
    }

    /**
     * @description 小程序类目管理
     * @return CategoryService
     */
    public function category(): CategoryService
    {
        return new CategoryService($this->options, $this);
    }

    /**
     * @description 开放平台管理
     * @return OpenAccountService
     */
    public function openAccount(): OpenAccountService
    {
        return new OpenAccountService($this->options, $this);
    }

    /**
     * @description 令牌
     * @return TokenService
     */
    public function token(): TokenService
    {
        return new TokenService($this->options, $this);
    }


    /**
     * @description 隐私
     * @return PrivacySettingService
     */
    public function privacy(): PrivacySettingService
    {
        return new PrivacySettingService($this->options, $this);
    }

    /**
     * @description 普通二维码
     * @return WxopenService
     */
    public function wxopen(): WxopenService
    {
        return new WxopenService($this->options, $this);
    }
}