<?php

defined( 'ABSPATH' ) || exit;

$clear_url = add_query_arg([
    '_wpnonce' => wp_create_nonce( 'elementor_site_clear_cache' ),
], admin_url( 'admin-post.php?action=elementor_site_clear_cache' ) );

return [
    'slug'  => 'elementor/elementor.php',
    'id'    => 'elementor',
    'name'  => 'Elementor',
    'rn'    => [],
    'links' => [
        [
            'label'    => 'Clear Elementor Cache',
            'url'      => $clear_url,
            'settings' => menu_page_url( 'elementor-settings', false ).'#tab-performance',
        ],
    ],
];

