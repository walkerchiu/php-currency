<?php

/**
 * @license MIT
 * @package WalkerChiu\Currency
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Switch association of package to On or Off
    |--------------------------------------------------------------------------
    |
    | When you set someone On:
    |     1. Its Foreign Key Constraints will be created together with data table.
    |     2. You may need to change the corresponding class settings in the config/wk-core.php.
    |
    | When you set someone Off:
    |     1. Association check will not be performed on FormRequest and Observer.
    |     2. Cleaner and Initializer will not handle tasks related to it.
    |
    | Note:
    |     The association still exists, which means you can still access related objects.
    |
    */
    'onoff' => [
        'core-lang_core' => 0,

        'group'    => 0,
        'account'  => 0,
        'rule'     => 0,
        'rule-hit' => 0,
        'site'     => 0
    ],

    /*
    |--------------------------------------------------------------------------
    | Lang Log
    |--------------------------------------------------------------------------
    |
    | 0: Don't keep data.
    | 1: Keep data.
    |
    */
    /* If it is enabled, all packages will use it,
       otherwise it will only be used when the specified package is not enabled.*/
    'lang_log' => 0,

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | Set default value for all package.
    |
    */
    'currency_id' => 1,

    /*
    |--------------------------------------------------------------------------
    | Command
    |--------------------------------------------------------------------------
    |
    | Location of Commands.
    |
    */
    'command' => [
        'cleaner'     => 'WalkerChiu\Currency\Console\Commands\CurrencyCleaner',
        'initializer' => 'WalkerChiu\Currency\Console\Commands\CurrencyInitializer'
    ],

    /*
    |--------------------------------------------------------------------------
    | Initializer
    |--------------------------------------------------------------------------
    */
    'initializer' => [
        [
            'abbreviation'  => 'USD',
            'mark'          => '$',
            'exchange_rate' => 1,
            'is_base'       => 1,
            'is_enabled'    => 1,
            'name'          => '??????'
        ],
        [
            'abbreviation'  => 'TWD',
            'mark'          => 'NT',
            'exchange_rate' => 29.9782,
            'is_base'       => 0,
            'is_enabled'    => 1,
            'name'          => '?????????'
        ],
        [
            'abbreviation'  => 'HKD',
            'mark'          => '$',
            'exchange_rate' => 7.7540,
            'is_base'       => 0,
            'is_enabled'    => 1,
            'name'          => '??????'
        ],
        [
            'abbreviation'  => 'MOP',
            'mark'          => 'P',
            'exchange_rate' => 7.9122,
            'is_base'       => 0,
            'is_enabled'    => 1,
            'name'          => '?????????'
        ],
        [
            'abbreviation'  => 'CNY',
            'mark'          => '??',
            'exchange_rate' => 7.1108,
            'is_base'       => 0,
            'is_enabled'    => 1,
            'name'          => '?????????'
        ],
        [
            'abbreviation'  => 'JPY',
            'mark'          => '??',
            'exchange_rate' => 110.79,
            'is_base'       => 0,
            'is_enabled'    => 0,
            'name'          => '??????'
        ],
        [
            'abbreviation'  => 'KRW',
            'mark'          => '???',
            'exchange_rate' => 1224.89,
            'is_base'       => 0,
            'is_enabled'    => 0,
            'name'          => '??????'
        ],
        [
            'abbreviation'  => 'GBP',
            'mark'          => '??',
            'exchange_rate' => 0.84388,
            'is_base'       => 0,
            'is_enabled'    => 1,
            'name'          => '??????'
        ],
        [
            'abbreviation'  => 'AUD',
            'mark'          => '$',
            'exchange_rate' => 1.6856,
            'is_base'       => 0,
            'is_enabled'    => 0,
            'name'          => '??????'
        ],
        [
            'abbreviation'  => 'EUR',
            'mark'          => '???',
            'exchange_rate' => 0.91643,
            'is_base'       => 0,
            'is_enabled'    => 0,
            'name'          => '??????'
        ],
        [
            'abbreviation'  => 'MYR',
            'mark'          => 'RM',
            'exchange_rate' => 4.3478,
            'is_base'       => 0,
            'is_enabled'    => 0,
            'name'          => '?????????'
        ],
        [
            'abbreviation'  => 'SGD',
            'mark'          => '$',
            'exchange_rate' => 1.4478,
            'is_base'       => 0,
            'is_enabled'    => 0,
            'name'          => '????????????'
        ]
    ]
];
