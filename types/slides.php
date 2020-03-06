<?php

add_action('init', 'slider_register');

function slider_register()
{

  $labels = array(
    'name' => _x('Sliders', 'Nome geral do tipo'),
    'singular_name' => _x('Slider', 'Nome singular do tipo'),
    'add_new' => _x('Adicionar novo', 'Adicionar novo slider'),
    'add_new_item' => __('Adicionar slider'),
    'edit_item' => __('Editar slider'),
    'all_items' => 'Sliders',
    'new_item' => __('Novo slider'),
    'view_item' => __('Ver slider'),
    'search_items' => __('Buscar slider'),
    'not_found' =>  __('Nothing found'),
    'not_found_in_trash' => __('Nada encontrado no lixo'),
    'parent_item_colon' => ''
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'show_in_rest' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'menu_icon' => 'dashicons-images-alt',
    'supports' => array('title', 'thumbnail', 'page-attributes', 'editor'),
    'rewrite' => array('slug' => 'slider', 'with_front' => FALSE)
  );

  register_post_type('slider', $args);
}

/*
add_action("admin_init", "admin_init");

function admin_init()
{
  add_meta_box("url-meta", "Opções do slider", "url_meta", "slider", "side", "low");
}

function url_meta()
{
  global $post;
  $custom = get_post_custom($post->ID);
  $url = $custom["url"][0];
  $url_open = $custom["url_open"][0];
  ?>
<div>
  <label>Link:</label>
  <input name="url" value="<?php echo $url; ?>" /><br />
  <div style="display: inline-flex; margin-top: 10px;">
    <input style="margin-top: 1px;" type="checkbox" name="url_open" <?php if ($url_open == "on") : echo " checked";
                                                                        endif ?>>
    Abrir URL em uma nova janela?<br />
  </div>
</div>
<?php
}

add_action('save_post', 'save_details');
function save_details()
{
  global $post;

  if ($post->post_type == "slider") {
    if (!isset($_POST["url"])) :
      return $post;
    endif;
    if ($_POST["url_open"] == "on") {
      $url_open_checked = "on";
    } else {
      $url_open_checked = "off";
    }
    update_post_meta($post->ID, "url", $_POST["url"]);
    update_post_meta($post->ID, "url_open", $url_open_checked);
  }
}

function wp_rpt_activation_hook()
{
  if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails', array('slider')); // Add it for posts
  }
  add_image_size('slide', 554, 414, true);
}
add_action('after_setup_theme', 'wp_rpt_activation_hook');

// Array of custom image sizes to add
$my_image_sizes = array(
  array('name' => 'slide', 'width' => 554, 'height' => 414, 'crop' => true),
);

// For each new image size, run add_image_size() and update_option() to add the necesary info.
// update_option() is good because it only updates the database if the value has changed. It also adds the option if it doesn't exist
foreach ($my_image_sizes as $my_image_size) {
  add_image_size($my_image_size['name'], $my_image_size['width'], $my_image_size['height'], $my_image_size['crop']);
  update_option($my_image_size['name'] . "_size_w", $my_image_size['width']);
  update_option($my_image_size['name'] . "_size_h", $my_image_size['height']);
  update_option($my_image_size['name'] . "_crop", $my_image_size['crop']);
}

// Hook into the 'intermediate_image_sizes' filter used by image-edit.php.
// This adds the custom sizes into the array of sizes it uses when editing/saving images.
add_filter('intermediate_image_sizes', 'my_add_image_sizes');
function my_add_image_sizes($sizes)
{
  global $my_image_sizes;
  foreach ($my_image_sizes as $my_image_size) {
    $sizes[] = $my_image_size['name'];
  }
  return $sizes;
}
*/