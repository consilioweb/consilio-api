<?php

/**
 * Consilio functions and definitions.
 * @package consilio
 */

/**
 * Theme settings
 */
require_once(get_template_directory() . '/includes/theme-options.php');
require_once(get_template_directory() . '/includes/theme-api.php');

/**
 * Utils
 */
require_once(get_template_directory() . '/utils/metabox.php');

/**
 * Includes custom type post
 */
require_once(get_template_directory() . '/types/testimonial.php');
require_once(get_template_directory() . '/types/client.php');
require_once(get_template_directory() . '/types/case.php');
require_once(get_template_directory() . '/types/slides.php');
require_once(get_template_directory() . '/types/team.php');
require_once(get_template_directory() . '/types/strategies.php');

// Remove all default WP template redirects/lookups
remove_action('template_redirect', 'redirect_canonical');

// Redirect all requests to index.php so the Vue app is loaded and 404s aren't thrown
function remove_redirects()
{
  add_rewrite_rule('^/(.+)/?', 'index.php', 'top');
}

/**
 * Remove logo wordpress
 */
function consilio_admin_bar_remove()
{
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'consilio_admin_bar_remove', 0);

/**
 * Toolbar customization
 *
 * @param [type] $wp_admin_bar
 * @return void
 */
function toolbar_link_to_mypage($wp_admin_bar)
{
  $wp_admin_bar->add_node(array(
    'parent' => 'root',
    'id' => 'support_consilio',
    'menu_icon' => 'dashicons-desktop',
    'title' => '<span style="margin-top: 2px;" class="ab-icon dashicons dashicons-editor-help"></span> <span class="ab-label">Suporte</span>',
    'href' => 'https://consilio.com.br/contato',
    'meta' => array('target' => '_blank')
  ));
}
add_action('admin_bar_menu', 'toolbar_link_to_mypage', 999);


/**
 * Menu configuration
 */
add_theme_support('menus');
if (function_exists('register_nav_menus')) {
  register_nav_menus(
    array(
      'header-menu' => 'Menu superior',
      'footer-menu' => 'Menu inferior'
    )
  );
}

/**
 * Others configurations
 */
add_post_type_support('page', 'excerpt');
add_theme_support('post-thumbnails');

/*
 * Custom logo login and URL
 */
add_filter('login_headerurl', create_function(false, "return get_bloginfo('url');"));
add_filter('login_headertitle', create_function(false, "return get_bloginfo('name');"));

/*
 * Custom logo image for login page
 */
function my_custom_login_logo()
{
  echo '
        <style>
        .login h1 a {
          background-image:url("' . get_option('consilio_options')['login_logo'] . '");
          background-size: ' . get_option('consilio_options')['width_login_logo'] . ' ' . get_option('consilio_options')['height_login_logo'] . ';
          color: blue;
          fill: currentColor;
          width: 100%;
        }
        ' . get_option('consilio_options')['login_css'] . '
        </style>
    ';
}
add_action('login_head', 'my_custom_login_logo');

/**
 * Custom menu order
 *
 * @param [type] $menu_ord
 * @return void
 */
function custom_menu_order($menu_ord)
{
  if (!$menu_ord) return true;
  return array(
    'index.php',
    'edit.php?post_type=slider',
    'edit.php?post_type=case',
    'edit.php?post_type=client',
    'edit.php?post_type=testimonial',
    'edit.php?post_type=team',
    'edit.php?post_type=strategy',
    'edit.php?post_type=page',
    'edit.php',
    'separator1',
    'edit-comments.php',
    'themes.php',
    'plugins.php',
    'upload.php',
    'link-manager.php',
    'separator2',
    'users.php',
    'tools.php',
    'options-general.php',
    'separator-last',
  );
}
add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');

/**
 * Enable upload svg in WordPress
 *
 * @param array $mime_types
 * @return void
 */
function cc_mime_types($mime_types = array())
{
  $mime_types['svg'] = 'image/svg+xml';
  $mime_types['json'] = 'application/json';
  unset($mime_types['xls']);
  unset($mime_types['xlsx']);
  return $mime_types;
}
add_filter('upload_mimes', 'cc_mime_types', 1, 1);

/**
 * Custom footer WordPress
 *
 * @return void
 */
function custom_admin_footer()
{
  echo '<a href="https://consilio.com.br/">Agência Consilio</a> © 2020';
}
add_filter('admin_footer_text', 'custom_admin_footer');

/**
 * Add style admin WordPress
 */
add_action('admin_enqueue_scripts', 'load_admin_style');
function load_admin_style()
{
  wp_enqueue_style('admin_css', get_stylesheet_directory_uri() . '/admin-style.css', false, '1.0.0');
}