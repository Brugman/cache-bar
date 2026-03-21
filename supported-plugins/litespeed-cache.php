<?php

defined( 'ABSPATH' ) || exit;

$url = wp_nonce_url( add_query_arg([
    'LSCWP_CTRL'     => 'purge',
    'litespeed_type' => 'purge_all',
]), 'purge', 'LSCWP_NONCE' );

return [
    'slug'  => 'litespeed-cache/litespeed-cache.php',
    'id'    => 'litespeed_cache',
    'name'  => 'LiteSpeed Cache',
    'label' => 'Clear LiteSpeed Page Cache',
    'url'   => $url,
    'rn'    => [
        'litespeed-menu',
    ],
];

