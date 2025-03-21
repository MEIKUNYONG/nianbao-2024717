<?php
// +----------------------------------------------------------------------
// | 胜家云 [ SingKa Cloud ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.singka.net All rights reserved.
// +----------------------------------------------------------------------
// | 宁波晟嘉网络科技有限公司
// +----------------------------------------------------------------------
// | Author: ShyComet <shycomet@qq.com>
// +----------------------------------------------------------------------
return [
    'aliyun'       => [
        'version'       => '2017-05-25',
        'host'          => 'dysmsapi.aliyuncs.com',
        'scheme'        => 'http',
        'region_id'     => 'cn-hangzhou',
        'access_key'    => '',
        'access_secret' => '',
        'sign_name'     => '',
        'actions'       => [
            'register'        => [
                'actions_name'      => '注册验证',
                'template_id'  => 'SMS_53115055',
            ],
            'login'           => [
                'actions_name'      => '登录验证',
                'template_id'  => 'SMS_53115057',
            ],
            'change_password' => [
                'actions_name'      => '修改密码',
                'template_id'  => 'SMS_53115053',
            ],
            'change_userinfo' => [
                'actions_name'      => '变更信息',
                'template_id'  => 'SMS_53115052',
            ],
        ],
    ],
    'ucloud'       => [
        'public_key'   =>  '',
        'private_key'  =>  '',
        'project_id'   =>  '',
        'base_url'     =>  'https://api.ucloud.cn',
        'sign_name'       => '',
        'actions'       => [
            'register'        => [
                'actions_name'      => '注册验证',
                'template_id'  => 'UTA1910164E29F4',
            ],
            'login'           => [
                'actions_name'      => '登录验证',
                'template_id'  => 'UTA1910164E29F4',
            ],
            'change_password' => [
                'actions_name'      => '修改密码',
                'template_id'  => 'UTA1910164E29F4',
            ],
            'change_userinfo' => [
                'actions_name'      => '变更信息',
                'template_id'  => 'UTA1910164E29F4',
            ],
        ],
    ],
    'qcloud'       => [
        'appid'   =>  '1400833385',
        'appkey'  =>  '4f0dd4b6496335b83cbcb5ed832a616b',
        'sign_name'       => '保定旺店信息科技有限公司',
        'actions'       => [
            'report'        => [
                'actions_name'      => '年报提醒',
                'template_id'  => '1844095',
            ],
            
        ],
    ],
    'qiniu'       => [
        'AccessKey'   =>  '',
        'SecretKey'  =>  '',
        'actions'       => [
            'register'        => [
                'actions_name'      => '注册验证',
                'template_id'  => '1246849772845797376',
            ],
            'login'           => [
                'actions_name'      => '登录验证',
                'template_id'  => '1246849654881001472',
            ],
            'change_password' => [
                'actions_name'      => '修改密码',
                'template_id'  => '1246849964902977536',
            ],
            'change_userinfo' => [
                'actions_name'      => '变更信息',
                'template_id'  => '1246849860733243392',
            ],
        ],
    ],
    'upyun'       => [
        'id'   =>  '',
        'token'  =>  '',
        'apiurl'  =>  '',
        'actions'       => [
            'register'        => [
                'actions_name'      => '注册验证',
                'template_id'  => '2591',
            ],
            'login'           => [
                'actions_name'      => '登录验证',
                'template_id'  => '2592',
            ],
            'change_password' => [
                'actions_name'      => '修改密码',
                'template_id'  => '2590',
            ],
            'change_userinfo' => [
                'actions_name'      => '变更信息',
                'template_id'  => '2589',
            ],
        ],
    ]
];