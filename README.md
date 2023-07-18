# sdk-component

微信小程序服务商sdk对接

## Usage

基本使用（以服务端为例）:

```php
<?php

// 获取预授权码

$options = [
    'component_appid' => 'xxxxxx',
    'component_appsecret' => 'xxxxxx',
    'component_verify_ticket' => 'ticket@@@szjFIJxETzEY24e6IGGVe9y41Cn1WhyedZUKdLL6oPt2_Ng_gmtcUb1ueST_AT7ov9MpCVKRyhGlw-pihojDmA',
];

$obj = ComponentService::getInstance($options)->useComponentToken()->ticket()->apiCreatePreauthcode();

```