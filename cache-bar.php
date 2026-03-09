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

namespace CCC;

defined( 'ABSPATH' ) || exit;

class Plugin
{
    public static function init()
    {
        self::register_hooks();
    }

    private static function register_hooks()
    {
        add_action( 'admin_bar_menu', [ self::class, 'register_toolbar' ], 300, 1 );
    }

    public static function register_toolbar( $wp_admin_bar )
    {
        $active_supported_plugins = self::active_supported_plugins();

        if ( empty( $active_supported_plugins ) )
            return;

        $wp_admin_bar->add_group([
            'id' => 'ccc-group',
        ]);

        $wp_admin_bar->add_node([
            'id'     => 'ccc-node',
            'title'  => 'Cache',
            'parent' => 'ccc-group',
        ]);

        foreach ( $active_supported_plugins as $plugin )
        {
            foreach ( $plugin['rn'] ?? [] as $node )
                $wp_admin_bar->remove_node( $node );

            $wp_admin_bar->add_node([
                'id'     => 'ccc-node-'.$plugin['id'],
                'title'  => $plugin['label'],
                'parent' => 'ccc-node',
                'href'   => $plugin['url'],
            ]);
        }
    }

    private static function active_supported_plugins()
    {
        $all_supported_plugins = self::all_supported_plugins();

        $active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
        $active_plugins = array_flip( $active_plugins );

        return array_filter( $all_supported_plugins, function ( $supported_plugin ) use ( $active_plugins ) {
            return isset( $active_plugins[ $supported_plugin['slug'] ] );
        });
    }

    private static function all_supported_plugins()
    {
        $all_supported_plugins = [];

        foreach ( glob( __DIR__.'/supported-plugins/*.php' ) as $file )
            $all_supported_plugins[] = include $file;

        return $all_supported_plugins;
    }
}

add_action( 'plugins_loaded', [ Plugin::class, 'init' ] );

