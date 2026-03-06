<?php

/**
 * Plugin Name: Cache Bar
 * Description: Streamline your cache clearing.
 * Version: 0.1.0
 * Plugin URI: https://mediumrare.dev
 * Author: Medium Rare
 * Author URI: https://mediumrare.dev
 * Text Domain: cache-bar
 */

defined( 'ABSPATH' ) || exit;

class CCC
{
    private function third_party_wp_opcache_link()
    {
        return wp_nonce_url( add_query_arg([
            'flush_opcache_action' => 'flushopcacheall'
        ], remove_query_arg( 'settings-updated' ) ), 'flush_opcache_all' );
    }

    private function third_party_clp_varnish_cache_link()
    {
        return add_query_arg([
            'page'   => 'clp-varnish-cache',
            'action' => 'purge-entire-cache',
        ], admin_url( 'options-general.php' ) );
    }

    private function third_party_cache_enabler_link()
    {
        return wp_nonce_url( add_query_arg([
            '_cache'  => 'cache-enabler',
            '_action' => 'clear',
        ]), 'cache_enabler_clear_cache_nonce' );
    }

    private function config()
    {
        return [
            'flush-opcache/flush-opcache.php' => [
                'id'    => 'wp_opcache',
                'name'  => 'WP OPcache',
                'label' => 'Clear PHP OPcache',
                'url'   => $this->third_party_wp_opcache_link(),
                'remove_nodes' => [
                    'flush_opcache_button',
                ],
            ],
            'clp-varnish-cache/clp-varnish-cache.php' => [
                'id'    => 'clp_varnish_cache',
                'name'  => 'CLP Varnish Cache',
                'label' => 'Clear Varnish Cache',
                'url'   => $this->third_party_clp_varnish_cache_link(),
            ],
            'cache-enabler/cache-enabler.php' => [
                'id'    => 'cache_enabler',
                'name'  => 'Cache Enabler',
                'label' => 'Clear Cache Enabler Page Cache',
                'url'   => $this->third_party_cache_enabler_link(),
                'remove_nodes' => [
                    'cache_enabler_clear_cache',
                    'cache_enabler_clear_page_cache',
                ],
            ],
        ];
    }

    private function active_supported_plugins()
    {
        $supported_plugins = array_keys( $this->config() );

        $active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

        return array_intersect( $supported_plugins, $active_plugins );
    }

    public function register_toolbar( $wp_admin_bar )
    {
        $config = $this->config();

        if ( empty( $config ) )
            return;

        $plugins = $this->active_supported_plugins();

        if ( empty( $plugins ) )
            return;

        $wp_admin_bar->add_group([
            'id' => 'ccc-group',
        ]);

        $wp_admin_bar->add_node([
            'id'     => 'ccc-node',
            'title'  => 'Cache',
            'parent' => 'ccc-group',
        ]);

        foreach ( $plugins as $plugin )
        {
            foreach ( $config[ $plugin ]['remove_nodes'] ?? [] as $node )
                $wp_admin_bar->remove_node( $node );

            $wp_admin_bar->add_node([
                'id'     => 'ccc-node-'.$config[ $plugin ]['id'],
                'title'  => $config[ $plugin ]['label'],
                'parent' => 'ccc-node',
                'href'   => $config[ $plugin ]['url'],
            ]);
        }
    }

    public function register_hooks()
    {
        add_action( 'admin_bar_menu', [ $this, 'register_toolbar' ], 300, 1 );
    }
}

$ccc = new CCC();
$ccc->register_hooks();

