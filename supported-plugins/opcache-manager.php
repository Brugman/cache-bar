<?php

defined( 'ABSPATH' ) || exit;

$clear_url = add_query_arg(
    '_wpnonce',
    wp_create_nonce( 'quick-action-opcm-tools' ),
    admin_url( 'admin.php?page=opcm-tools&quick-action=reset' )
);

return [
    'slug'  => 'opcache-manager/opcache-manager.php',
    'id'    => 'opcache_manager',
    'name'  => 'OPcache Manager',
    'links' => [
        'clear' => [
            'label' => 'Clear OPcache',
            'url'   => $clear_url,
        ],
        'settings' => [
            'label' => '<span class="ab-icon"></span>',
            'url'   => admin_url( 'admin.php?page=opcm-tools' ),
        ],
    ],
    'rn'    => [
        'perfopsone-dashboard',
    ],
];

