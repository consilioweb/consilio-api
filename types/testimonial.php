<?php

add_action('init', 'register_testimonial');

function register_testimonial()
{

  $labels = array(
    'name' => _x('Depoimentos', 'Nome geral do tipo'),
    'singular_name' => _x('Depoimento', 'Nome singular do tipo'),
    'add_new' => _x('Adicionar novo', 'Adicionar novo slider'),
    'add_new_item' => __('Adicionar depoimento'),
    'edit_item' => __('Editar depoimento'),
    'all_items' => 'Depoimentos',
    'new_item' => __('Novo depoimento'),
    'view_item' => __('Ver depoimento'),
    'search_items' => __('Buscar depoimento'),
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
    'menu_icon' => 'dashicons-format-quote',
    'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
    'rewrite' => array('slug' => 'testimonial', 'with_front' => FALSE)
  );

  register_post_type('testimonial', $args);
}

add_action("admin_init", "customer_meta", 1);

function customer_meta()
{
  add_meta_box("customer_view", __('Opções do depoimento', 'text-domain'), "customer_view", "testimonial", "side", "low");
}

function customer_view($post)
{
  wp_nonce_field(basename(__FILE__), 'customer_metabox_nonce');
  $customer_testimonial = get_post_meta($post->ID, 'customer_testimonial', true);
  $complement_customer_testimonial = get_post_meta($post->ID, 'complement_customer_testimonial', true);

  ?>
  <div>
    <label>Cliente:</label>
    <input class="components-text-control__input" type="text" name="customer_testimonial" value="<?= $customer_testimonial ?>">
  </div>
  <div>
    <label>Complemento:</label>
    <input class="components-text-control__input" type="text" name="complement_customer_testimonial" value="<?= $complement_customer_testimonial ?>">
  </div>
<?php
}

function customer_save_post_meta($post_id, $post)
{

  if (
    !isset($_POST['customer_metabox_nonce'])
    || !wp_verify_nonce($_POST['customer_metabox_nonce'], basename(__FILE__))
  )
    return $post_id;

  $post_type = get_post_type_object($post->post_type);
  if (!current_user_can($post_type->cap->edit_post, $post_id))
    return $post_id;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return $post_id;

  if ($post->post_type == 'testimonial') {
    update_post_meta($post_id, 'customer_testimonial', sanitize_text_field($_POST['customer_testimonial']));
    update_post_meta($post_id, 'complement_customer_testimonial', sanitize_text_field($_POST['complement_customer_testimonial']));
  }
  return $post_id;
}
add_action('save_post', 'customer_save_post_meta', 10, 2);

function filter_customer_json($data, $post, $context)
{
  $customer_testimonial = get_post_meta($post->ID, 'customer_testimonial', true);
  if ($customer_testimonial) {
    $data->data['customer_testimonial'] = $customer_testimonial;
  }
  $complement_customer_testimonial = get_post_meta($post->ID, 'complement_customer_testimonial', true);
  if ($complement_customer_testimonial) {
    $data->data['complement_customer_testimonial'] = $complement_customer_testimonial;
  }

  return $data;
}
add_filter('rest_prepare_testimonial', 'filter_customer_json', 10, 3);

add_filter('manage_testimonial_posts_columns', 'set_custom_edit_testimonial_columns');
add_action('manage_testimonial_posts_custom_column', 'custom_testimonial_column', 10, 2);

function set_custom_edit_testimonial_columns($columns)
{
  $columns['customer_testimonial'] = __('Cliente', 'client');

  return $columns;
}

function custom_testimonial_column($column, $post_id)
{
  switch ($column) {

    case 'customer_testimonial':
      $terms = get_post_meta($post_id, 'customer_testimonial', true);
      if (is_string($terms))
        echo $terms;
      else
        _e('Não existe cliente vinculado ao depoimento. ');
      break;
  }
}
