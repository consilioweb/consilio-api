<?php

/**
 * Add params route api menu
 *
 * @return void
 */
function get_menu_principal()
{
  $response = wp_get_nav_menu_items(4); // data => array of returned data
  return new WP_REST_Response($response, 200);
}
add_action('rest_api_init', function () {
  register_rest_route('wp/v2', 'menu-principal', array(
    'methods' => 'GET',
    'callback' => 'get_menu_principal',
  ));
});

/**
 * Add route theme settings
 */
function add_get_info()
{
  $consilio_options = get_option("consilio_options");
  $result = array(
    "blogName" => get_bloginfo("name"),
    "blogDescription" => get_bloginfo("description"),
    "contentUrl" => "/wp-content",
    //Basic
    "domain" => $consilio_options["domain"],
    "maintenance" => $consilio_options["maintenance"],
    "copyright" => $consilio_options["footer_copyright"],
    "footer_box" => $consilio_options["footer_box"],
    //--info
    "phone" => $consilio_options["phone"],
    "whatsapp" => $consilio_options["whatsapp"],
    "email" => $consilio_options["email"],
    "address" => $consilio_options["address"],
    //--socials
    "facebook" => $consilio_options["facebook"],
    "instagram" => $consilio_options["instagram"],
    "linkedin" => $consilio_options["linkedin"],
    "youtube" => $consilio_options["youtube"],
    "twitter" => $consilio_options["twitter"],
    //SEO
    "keywords" => $consilio_options["keywords"],
    "description" => $consilio_options["description"],
    //Images
    "favicon" => $consilio_options["favicon"],
    "login_logo" => $consilio_options["login_logo"],
    "width_login_logo" => $consilio_options["width_login_logo"],
    "height_login_logo" => $consilio_options["height_login_logo"],
    "logo" => $consilio_options["logo"],
    "thumbnail" => $consilio_options["thumbnail"],
    //Custom
    "login_css" => $consilio_options["login_css"],
    "global_css" => $consilio_options["global_css"],
    //Codes
    "google_analytics" => $consilio_options["google_analytics"],
    "google_tag_manager" => $consilio_options["google_tag_manager"],
    "others_scripts" => $consilio_options["others_scripts"],
    //Counts
    "getAllCountArticle" => wp_count_posts()->publish,
    "getAllCountCat" => wp_count_terms("category"),
    "getAllCountPage" => wp_count_posts("page")->publish,
    "getAllCountTag" => wp_count_terms("post_tag"),
    //Others
    "templeteUrl" => "/wp-content/themes/" . get_option("template"),
    "themeDir" => get_option("template"),
    "thumbnail" => $consilio_options["thumbnail"],
    "wpVersion" => get_bloginfo('version'),
    "wp" => get_option('siteurl')
  );
  return $result;
}
add_action("rest_api_init", function () {
  register_rest_route("wp/v2", "/info", array("methods" => "GET", "callback" => "add_get_info"));
});

/**
 * Custom variable featured image
 *
 * @param [type] $object
 * @param [type] $field_name
 * @param [type] $request
 * @return void
 */
function get_rest_featured_image($object, $field_name, $request)
{
  if ($object['featured_media']) {
    $img = wp_get_attachment_image_src($object['featured_media'], 'full');
    return $img[0];
  }
  return false;
}

/**
 * Add quick variable featured image REST API
 */
add_action('rest_api_init', 'register_rest_images');
function register_rest_images()
{
  register_rest_field(
    array('post', 'page', 'slider', 'case', 'client', 'testimonial', 'team', 'strategy'),
    'quick_img',
    array(
      'get_callback'    => 'get_rest_featured_image',
      'update_callback' => null,
      'schema'          => null,
    )
  );
}

add_filter('rest_prepare_post', function ($response, $post, $request) {

  global $post;
  $posts = get_posts();

  $next = get_adjacent_post(false, '', false);
  $previous = get_adjacent_post(false, '', true);
  $response->data['count'] = count($posts);
  $response->data['count_total'] = (int) $wp_query->found_posts;
  $response->data['pages'] = $wp_query->max_num_pages;
  $response->data['next'] = (is_a($next, 'WP_Post')) ? array("id" => $next->ID, "slug" => $next->post_name) : null;
  $response->data['previous'] = (is_a($previous, 'WP_Post')) ? array("id" => $previous->ID, "slug" => $previous->post_name) : null;

  return $response;
}, 10, 3);


/**
 * Include custom fields in REST API
 *
 * @param [type] $page
 * @return void
 */
function custom_rest_prepare_post($data, $post, $request)
{
  $_data = $data->data;
  $fields = get_fields($post->ID);

  if ($fields) {
    foreach ($fields as $key => $value) {
      $_data["custom_fields"][$key] = get_field($key, $post->ID);
    }

    $data->data = $_data;
  } else {
  }

  return $data;
}
add_filter("rest_prepare_page", "custom_rest_prepare_post", 10, 3);
add_filter("rest_prepare_team", "custom_rest_prepare_post", 9, 3);
add_filter("rest_prepare_slider", "custom_rest_prepare_post", 9, 3);

/**
 * WP REST API
 */
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}
if (!class_exists('WP_REST_API_templates')) :
  /**
   * WP REST API templates class.
   *
   * @package WP_REST_API_templates
   * @since 1.0.1
   */
  class WP_REST_API_templates
  {
    /**
     * Get WP API namespace.
     *
     * @since 1.0.1
     * @return string
     */
    public static function get_api_namespace()
    {
      return 'wp/v2';
    }
    /**
     * Register menu routes for WP API v2.
     *
     * @since  1.0.1
     */
    public function register_routes()
    {
      register_rest_route(
        self::get_api_namespace(),
        '/templates',
        array(
          array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => array($this, 'get_templates')
          )
        )
      );
    }
    /**
     * Get the templates or page object
     *
     * @since  1.0.1
     * @return Object containing all templates or page objects that comply to the template type parameter
     */
    public static function get_templates($request_data)
    {
      $parameters = $request_data->get_params();
      if (!isset($parameters['type']) || empty($parameters['type'])) {
        $response = wp_get_theme()->get_page_templates();
      } else {
        $args = array(
          'post_type' => 'page',
          'post_status' => 'publish',
          'meta_query' => array(
            array(
              'key' => '_wp_page_template',
              'value' => $parameters['type']
            )
          )
        );
        $query = new WP_Query($args);
        $response = $query->posts;
      }
      // No static frontpage is set
      if (count($response) < 1) {
        return new WP_Error(
          'wpse-error',
          esc_html__('No templates found', 'wpse'),
          ['status' => 404]
        );
      }
      // Return the response
      return $response;
    }
  }
endif;

if (!function_exists('wp_rest_api_templates_init')) :
  /**
   * Init JSON REST API Static Routes.
   *
   * @since 1.0.0
   */
  function wp_rest_api_templates_init()
  {
    $class = new WP_REST_API_templates();
    add_filter('rest_api_init', array($class, 'register_routes'));
  }
  add_action('init', 'wp_rest_api_templates_init');
endif;

add_action('rest_api_init', 'wp_rest_insert_tag_links');

function wp_rest_insert_tag_links()
{

  register_rest_field(
    'post',
    'post_categories',
    array(
      'get_callback'    => 'wp_rest_get_categories_links',
      'update_callback' => null,
      'schema'          => null,
    )
  );
  register_rest_field(
    'post',
    'post_tags',
    array(
      'get_callback'    => 'wp_rest_get_tags_links',
      'update_callback' => null,
      'schema'          => null,
    )
  );
}
/**
 * Prepare taxonomy category and tags
 *
 * @param [type] $post
 * @return void
 */
function wp_rest_get_categories_links($post)
{
  $post_categories = array();
  $categories = wp_get_post_terms($post['id'], 'category', array('fields' => 'all'));

  foreach ($categories as $term) {
    $term_link = get_term_link($term);
    if (is_wp_error($term_link)) {
      continue;
    }
    $post_categories[] = $term->name;
    $post_categories_ext[] = array('term_id' => $term->term_id, 'name' => $term->name, 'link' => $term_link);
  }
  return $post_categories;
}
function wp_rest_get_tags_links($post)
{
  $post_tags = array();
  $tags = wp_get_post_terms($post['id'], 'post_tag', array('fields' => 'all'));
  foreach ($tags as $term) {
    $term_link = get_term_link($term);
    if (is_wp_error($term_link)) {
      continue;
    }
    $post_tags[] = $term->name;
    //$post_tags_ext[] = array('term_id' => $term->term_id, 'name' => $term->name, 'link' => $term_link);
  }
  return $post_tags;
}

/**
 * FILTER
 */
add_action('rest_api_init', 'rest_api_filter_add_filters');
/**
 * Add the necessary filter to each post type
 **/
function rest_api_filter_add_filters()
{
  foreach (get_post_types(array('show_in_rest' => true), 'objects') as $post_type) {
    add_filter('rest_' . $post_type->name . '_query', 'rest_api_filter_add_filter_param', 10, 2);
  }
}
/**
 * Add the filter parameter
 *
 * @param  array           $args    The query arguments.
 * @param  WP_REST_Request $request Full details about the request.
 * @return array $args.
 **/
function rest_api_filter_add_filter_param($args, $request)
{
  // Bail out if no filter parameter is set.
  if (empty($request['filter']) || !is_array($request['filter'])) {
    return $args;
  }
  $filter = $request['filter'];
  if (isset($filter['posts_per_page']) && ((int) $filter['posts_per_page'] >= 1 && (int) $filter['posts_per_page'] <= 100)) {
    $args['posts_per_page'] = $filter['posts_per_page'];
  }
  global $wp;
  $vars = apply_filters('rest_query_vars', $wp->public_query_vars);
  // Allow valid meta query vars.
  $vars = array_unique(array_merge($vars, array('meta_query', 'meta_key', 'meta_value', 'meta_compare')));
  foreach ($vars as $var) {
    if (isset($filter[$var])) {
      $args[$var] = $filter[$var];
    }
  }
  return $args;
}
/**
 * Add router api
 */
add_action("rest_api_init", function () {
  register_rest_route('wp/v2', 'routes', array(
    'methods' => 'GET',
    'callback' => 'rest_theme_routes',
  ));
});

function rest_theme_routes()
{
  $routes = array();
  $query = new WP_Query(array(
    'post_type' => 'any',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
  ));

  $categories = get_categories();
  $tags = get_tags();
  $authors = get_users();

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $routes[] = array(
        'id'   => get_the_ID(),
        'name'  => get_the_title(),
        'type' => get_post_type(),
        'slug' => basename(get_permalink()),
      );
    }
  }
  if ($categories) {
    foreach ($categories as $category) {
      $routes[] = array(
        'id'    => $category->term_id,
        'name'  => $category->name,
        'type'  => "category",
        'slug'  => $category->slug
      );
    }
  }
  if ($tags) {
    foreach ($tags as $tag) {
      $routes[] = array(
        'id'    => $tag->term_id,
        'name'  => $tag->name,
        'type'  => "tag",
        'slug'  => $tag->slug
      );
    }
  }
  if ($authors) {
    foreach ($authors as $author) {
      $routes[] = array(
        'id'    => $author->id,
        'name'  => $author->display_name,
        'type'  => "author",
        'slug'  => $author->user_nicename
      );
    }
  }
  wp_reset_postdata();
  return $routes;
}