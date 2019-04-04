<?php

return
[
    /*
    |--------------------------------------------------------------------------
    | Controlling Smartdetect Activity
    |--------------------------------------------------------------------------
    |
    | Simply turn on/off Smartdetect activity using this option, you may turn
    | it off for security reason or any purpose.
    |
    | Notice:
    | Turning off Smartdetect, will result turning off all occurring factors.
    |
    */
    'turned_off' => env('SMARTDETECT_TURNED_OFF', false),
    
    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | Turning on this option helps you developing your application easier
    | using Smartdetect.
    |
    */
    'debug_mode' => env('SMARTDETECT_DEBUG_MODE', false),
    
    /*
    |--------------------------------------------------------------------------
    | Involving Config Factors
    |--------------------------------------------------------------------------
    |
    | If you turn on this option, Smartdetect will involve factors which you
    | write in config (this) file.
    |
    */
    'involve_config' => env('SMARTDETECT_INVOLVE_CONFIG', true),
    
    /*
    |--------------------------------------------------------------------------
    | Involving "Domain" Factors
    |--------------------------------------------------------------------------
    |
    | You might want to avoid using domain factors, this will disable occurring
    | domain factors.
    |
    */
    'involve_domain' => env('SMARTDETECT_INVOLVE_DOMAIN', true),
    
    /*
    |--------------------------------------------------------------------------
    | Involving "IP" Factors
    |--------------------------------------------------------------------------
    |
    | You might want to avoid using IP factors, this will disable occurring IP
    | factors.
    |
    */
    'involve_ip' => env('SMARTDETECT_INVOLVE_IP', true),
    
    /*
    |--------------------------------------------------------------------------
    | Involving "Request" Factors
    |--------------------------------------------------------------------------
    |
    | You might want to avoid using Request factors, this will disable occurring
    | Request factors.
    |
    */
    'involve_request' => env('SMARTDETECT_INVOLVE_REQUEST', true),
    
    /*
    |--------------------------------------------------------------------------
    | Involving "User" Factors
    |--------------------------------------------------------------------------
    |
    | You might want to avoid using User factors, this will disable occurring
    | User factors.
    |
    */
    'involve_user' => env('SMARTDETECT_INVOLVE_USER', true),
    
    /*
    |--------------------------------------------------------------------------
    | Manually Setup Predefined Factors
    |
    | Please note that it's important to observe the pattern of 'factors'
    | array structure.
    |
    | 'factors' =>
    | [
    |     'domain' =>
    |     [
    |         'entire' => [],
    |         'extension' => [],
    |         'name' => [],
    |     ],
    |     'ip' => [],
    |     'request' => [],
    |     'user' =>
    |     [
    |         'email' => [],
    |         'id' => [],
    |     ],
    | ],
    |--------------------------------------------------------------------------
    |
    */
    'factors' =>
    [
        'domain' =>
        [
            'entire' =>
            [
                'localhost',
                'local',
                'development',
                'production',
                'staging',
            ],
            'extension' => [],
            'name' => [],
        ],
        'ip' =>
        [
            '127.0.0.1',
            '::1',
        ],
        'request' =>
        [
            'test',
            'debug' => 'test',
        ],
        'user' =>
        [
            'email' =>
            [
                'root',
                'administrator',
                'admin',
                'developer',
            ],
            'id' =>
            [
                1,
            ],
        ],
    ],
];
