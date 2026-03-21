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

define( 'CCC_FILE', __FILE__ );
define( 'CCC_BASENAME', plugin_basename( CCC_FILE ) );

define( 'CCC_VERSION', '0.1.0' );

final class Plugin
{
    private static $instance = null;

    public static function instance()
    {
        if ( self::$instance === null )
            self::$instance = new self();

        return self::$instance;
    }

    private function __construct()
    {
        $this->register_hooks();
    }

    private function register_hooks()
    {
        add_action( 'admin_enqueue_scripts', [ $this, 'register_backend_styles' ] );

        add_action( 'admin_bar_menu', [ $this, 'modify_toolbar' ], 1000, 1 );
    }

    public function register_backend_styles()
    {
        wp_register_style(
            'ccc-css-main',
            plugin_dir_url( CCC_FILE ).'assets/ccc-main.min.css',
            [],
            CCC_VERSION,
            'all'
        );

        wp_enqueue_style( 'ccc-css-main' );

        wp_register_style(
            'ccc-css-right',
            plugin_dir_url( CCC_FILE ).'assets/ccc-right.min.css',
            [],
            CCC_VERSION,
            'all'
        );

        if ( apply_filters( 'ccc_toolbar_position_right', false ) )
            wp_enqueue_style( 'ccc-css-right' );
    }

    public function modify_toolbar( $wp_admin_bar )
    {
        $asp = $this->active_supported_plugins();

        if ( empty( $asp ) )
            return;

        $this->remove_third_party_toolbars( $wp_admin_bar, $asp );
        $this->add_ccc_toolbar( $wp_admin_bar, $asp );
    }

    private function remove_third_party_toolbars( $wp_admin_bar, $asp )
    {
        if ( current_user_can( apply_filters( 'ccc_keep_third_party_toolbars', 'loremipsumdolorsitamet' ) ) )
            return;

        foreach ( $asp as $plugin )
            foreach ( $plugin['rn'] ?? [] as $node )
                $wp_admin_bar->remove_node( $node );
    }

    private function add_ccc_toolbar( $wp_admin_bar, $asp )
    {
        if ( !current_user_can( apply_filters( 'ccc_add_toolbar', 'manage_options' ) ) )
            return;

        $wp_admin_bar->add_group([
            'id' => 'ccc-group',
        ]);

        $wp_admin_bar->add_node([
            'id'     => 'ccc-node',
            'title'  => 'Cache',
            'parent' => 'ccc-group',
        ]);

        foreach ( $asp as $plugin )
        {
            if ( isset( $plugin['links']['clear'], $plugin['links']['settings'] ) )
            {
                $title = $this->build_double_node_title(
                    $plugin['links']['clear']['label'],
                    $plugin['links']['clear']['url'],
                    $plugin['links']['settings']['label'],
                    $plugin['links']['settings']['url'],
                );

                $href = false;
            }
            elseif ( isset( $plugin['links']['clear'] ) )
            {
                $title = $plugin['links']['clear']['label'];
                $href  = $plugin['links']['clear']['url'];
            }
            else
            {
                continue;
            }

            $wp_admin_bar->add_node([
                'id'     => 'ccc-node-'.$plugin['id'],
                'title'  => $title,
                'parent' => 'ccc-node',
                'href'   => $href,
            ]);
        }
    }

    private function build_double_node_title( $text_one, $link_one, $text_two, $link_two )
    {
        $title = '';

        if ( $link_one === false )
            $title .= '<span class="ei-left">'.$text_one.'</span>';
        else
            $title .= '<a href="'.$link_one.'" class="ei-left">'.$text_one.'</a>';

        if ( $link_two === false )
            $title .= '<span class="ei-right">'.$text_two.'</span>';
        else
            $title .= '<a href="'.$link_two.'" class="ei-right">'.$text_two.'</a>';

        return $title;
    }

    private function active_supported_plugins()
    {
        $all_supported_plugins = $this->all_supported_plugins();

        $active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
        $active_plugins = array_flip( $active_plugins );

        return array_filter( $all_supported_plugins, function ( $supported_plugin ) use ( $active_plugins ) {
            return isset( $active_plugins[ $supported_plugin['slug'] ] );
        });
    }

    private function all_supported_plugins()
    {
        $all_supported_plugins = [];

        foreach ( glob( __DIR__.'/supported-plugins/*.php' ) as $file )
            $all_supported_plugins[] = include $file;

        return apply_filters( 'cache_bar_plugins', $all_supported_plugins );
    }
}

add_action( 'plugins_loaded', [ Plugin::class, 'instance' ] );

