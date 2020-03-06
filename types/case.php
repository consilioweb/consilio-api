<?php

add_action('init', 'register_cases');

function register_cases()
{

  $labels = array(
    'name' => _x('Cases', 'Nome geral do tipo'),
    'singular_name' => _x('Case', 'Nome singular do tipo'),
    'add_new' => _x('Adicionar novo', 'Adicionar novo slider'),
    'add_new_item' => __('Adicionar case'),
    'edit_item' => __('Editar case'),
    'all_items' => 'Cases',
    'new_item' => __('Novo case'),
    'view_item' => __('Ver case'),
    'search_items' => __('Buscar case'),
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
    'menu_icon' => 'dashicons-desktop',
    'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
    'rewrite' => array('slug' => 'case', 'with_front' => FALSE)
  );

  register_post_type('case', $args);
}

add_action("admin_init", "client_meta", 1);

function client_meta()
{
  add_meta_box("client_view", __('Opções do case', 'text-domain'), "client_view", "case", "side", "low");
}

function client_view($post)
{
  wp_nonce_field(basename(__FILE__), 'client_metabox_nonce');

  $current_client_case = get_post_meta($post->ID, 'client_case', true);
  $current_url_case = get_post_meta($post->ID, 'url_case', true);
  $current_button_case = get_post_meta($post->ID, 'button_case', true);
  $clients = new WP_Query(array('post_type' => 'client', 'post_status' => array('publish'), 'posts_per_page' => -1));
  echo "<div class='components-base-control__field'><label class='components-base-control__label'>Selecione o cliente referente ao case:</label>";
  echo "<select name='client_case'>";

  while ($clients->have_posts()) {
    $clients->the_post();
    $title = the_title('', '', false);
    $title = esc_attr($title);
?>
<option value="<?= $title ?>" <?php if ($title == $current_client_case) echo 'selected'; ?>><?= the_title() ?></option>
<?php
  }
  echo "</select>";
  echo "</div>";
  echo "<div class='components-base-control__field'><label class='components-base-control__label'>Link para o case:</label>";
  echo "<input type='text' style='margin-top: 10px;' value='" . $current_url_case . "' class='components-text-control__input' name='url_case'>";
  echo "</div>";
  echo "<div class='components-base-control__field'><label class='components-base-control__label'>Texto do botão:</label>";
  echo "<input type='text' style='margin-top: 10px;' value='" . $current_button_case . "' class='components-text-control__input' name='button_case'>";
  echo "</div>";
}

function client_save_post_meta($post_id, $post)
{

  if (
    !isset($_POST['client_metabox_nonce'])
    || !wp_verify_nonce($_POST['client_metabox_nonce'], basename(__FILE__))
  )
    return $post_id;

  $post_type = get_post_type_object($post->post_type);
  if (!current_user_can($post_type->cap->edit_post, $post_id))
    return $post_id;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return $post_id;

  if ($post->post_type == 'case') {
    update_post_meta($post_id, 'client_case', sanitize_text_field($_POST['client_case']));
    update_post_meta($post_id, 'url_case', sanitize_text_field($_POST['url_case']));
    update_post_meta($post_id, 'button_case', sanitize_text_field($_POST['button_case']));
  }
  return $post_id;
}
add_action('save_post', 'client_save_post_meta', 10, 2);


add_filter('manage_case_posts_columns', 'set_custom_edit_case_columns');
add_action('manage_case_posts_custom_column', 'custom_case_column', 10, 2);

function set_custom_edit_case_columns($columns)
{
  $columns['client_case'] = __('Cliente', 'client');

  return $columns;
}

function custom_case_column($column, $post_id)
{
  switch ($column) {

    case 'client_case':
      $terms = get_post_meta($post_id, 'client_case', true);
      if (is_string($terms))
        echo $terms;
      else
        _e('Não existe cliente vinculado ao case. ');
      break;
  }
}

function filter_client_case_json($data, $post, $context)
{
  $client_case = get_post_meta($post->ID, 'client_case', true);
  $url_case = get_post_meta($post->ID, 'url_case', true);
  $button_case = get_post_meta($post->ID, 'button_case', true);

  if ($client_case) {
    $data->data['client'] = $client_case;
  }
  if ($url_case) {
    $data->data['url'] = $url_case;
  }
  if ($button_case) {
    $data->data['button'] = $button_case;
  }

  return $data;
}
add_filter('rest_prepare_case', 'filter_client_case_json', 10, 3);