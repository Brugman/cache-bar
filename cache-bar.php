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

    private $asp = null;

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

        add_action( 'admin_bar_menu', [ $this, 'add_ccc_toolbar' ], 500 );

        add_action( 'wp_before_admin_bar_render', [ $this, 'remove_third_party_toolbars' ], 100 );

        add_action( 'admin_post_ccc_clear_transients', [ $this, 'handle_clear_transients' ] );
        add_action( 'admin_notices', [ $this, 'transients_cleared_notice' ] );
    }

    public function register_backend_styles()
    {
        wp_register_style(
            'ccc',
            plugin_dir_url( CCC_FILE ).'assets/ccc.min.css',
            [],
            CCC_VERSION,
            'all'
        );

        wp_enqueue_style( 'ccc' );
    }

    public function add_ccc_toolbar( $wp_admin_bar )
    {
        if ( is_null( $this->asp ) )
            $this->asp = $this->active_supported_plugins();

        if ( !current_user_can( apply_filters( 'ccc_add_toolbar', 'manage_options' ) ) )
            return;

        $parent = apply_filters( 'ccc_toolbar_position_right', false ) ? 'top-secondary' : false;

        $wp_admin_bar->add_node([
            'id'     => 'ccc-toolbar',
            'title'  => 'Cache',
            'parent' => $parent,
        ]);

        $wp_admin_bar->add_node([
            'id'     => 'ccc-toolbar-transients',
            'title'  => 'Clear transients',
            'parent' => 'ccc-toolbar',
            'href'   => wp_nonce_url( admin_url('admin-post.php?action=ccc_clear_transients'), 'ccc_clear_transients' ),
        ]);

        foreach ( $this->asp as $plugin )
        {
            foreach ( $plugin['links'] as $index => $link )
            {
                $title = $link['label'];
                $href  = $link['url'];

                if ( isset( $link['settings'] ) )
                {
                    $title = '';
                    $title .= '<a href="'.$link['url'].'" class="ei-left">'.$link['label'].'</a>';
                    $title .= '<a href="'.$link['settings'].'" class="ei-right"><span class="ab-icon"></span></a>';

                    $href = false;
                }

                $wp_admin_bar->add_node([
                    'id'     => 'ccc-toolbar-'.$plugin['id'].'-'.$index,
                    'title'  => $title,
                    'parent' => 'ccc-toolbar',
                    'href'   => $href,
                ]);
            }
        }
    }

    public function remove_third_party_toolbars()
    {
        if ( is_null( $this->asp ) )
            $this->asp = $this->active_supported_plugins();

        if ( empty( $this->asp ) )
            return;

        if ( current_user_can( apply_filters( 'ccc_keep_third_party_toolbars', 'loremipsumdolorsitamet' ) ) )
            return;

        global $wp_admin_bar;

        foreach ( $this->asp as $plugin )
            foreach ( $plugin['rn'] ?? [] as $node )
                $wp_admin_bar->remove_node( $node );
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

    private function delete_all_transients()
    {
        $transient_names = $this->get_transient_names();

        foreach ( $transient_names as $transient_name )
            delete_transient( $transient_name );

        return count( $transient_names );
    }

    private function get_transient_names()
    {
        global $wpdb;

        $transient_names = $wpdb->get_col("
            SELECT option_name
            FROM {$wpdb->options}
            WHERE option_name LIKE '_transient_%'
        ");

        return array_map( fn ( $name ) => substr( $name, 11 ), $transient_names );
    }

    public function handle_clear_transients()
    {
        if ( !current_user_can( apply_filters( 'ccc_add_toolbar', 'manage_options' ) ) )
            wp_die('Insufficient permissions');

        check_admin_referer('ccc_clear_transients');

        $count = $this->delete_all_transients();

        wp_safe_redirect( add_query_arg( [
            'ccc-deleted-transients' => true,
            'count'                  => $count,
        ], admin_url() ) );
        exit;
    }

    public function transients_cleared_notice()
    {
        if ( !isset( $_GET['ccc-deleted-transients'] ) )
            return;

        ?>
<div class="notice notice-success is-dismissible">
    <p>Cleared all <?=absint( $_GET['count'] );?> transients.</p>
</div>
        <?php
    }
}

add_action( 'plugins_loaded', [ Plugin::class, 'instance' ] );

