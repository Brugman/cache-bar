<?php

defined( 'ABSPATH' ) || exit;

$clear_url = add_query_arg([
    'page'   => 'clp-varnish-cache',
    'action' => 'purge-entire-cache',
], admin_url( 'options-general.php' ) );

return [
    'slug'  => 'clp-varnish-cache/clp-varnish-cache.php',
    'id'    => 'clp_varnish_cache',
    'name'  => 'CLP Varnish Cache',
    'links' => [
        'clear' => [
            'label' => 'Clear Varnish Cache',
            'url'   => $clear_url,
        ],
        // 'settings' => [
        //     'label' => 'X',
        //     'url'   => false,
        // ],
    ],
    'rn'    => [],
];

