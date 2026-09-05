<?php

defined( 'ABSPATH' ) || exit;

$clear_url = wp_nonce_url(
    add_query_arg([
        'action' => 'admin_bar_purge_cache',
    ], admin_url( 'admin-ajax.php' ) ),
    'sg-cachepress-purge'
);

return [
    'slug'  => 'sg-cachepress/sg-cachepress.php',
    'id'    => 'speed_optimizer',
    'name'  => 'Speed Optimizer',
    'rn'    => [
        'SG_CachePress_Supercacher_Purge',
    ],
    'links' => [
        [
            'label'    => 'Clear Page Cache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'sgo_caching', false ),
        ],
    ],
];

