<?php

add_action('init', 'register_team');

function register_team()
{
  $labels = array(
    'name' => __('Equipe', 'Nome geral do tipo'),
    'singular_name' => __('Membro', 'text-domain'),
    'add_new' => __('Adicionar novo', 'text-domain'),
    'add_new_item' => __('Adicionar membro'),
    'edit_item' => __('Editar membro'),
    'all_items' => 'Membros',
    'new_item' => __('Novo membro'),
    'view_item' => __('Ver membro'),
    'search_items' => __('Buscar membro'),
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
    'menu_icon' => 'dashicons-groups',
    'supports' => array('title', 'thumbnail', 'revisions', 'editor'),
    'rewrite' => array('slug' => 'team', 'with_front' => FALSE)
  );

  register_post_type('team', $args);
}

/**
 * Add custom column
 */

add_filter('manage_team_posts_columns', 'set_custom_edit_team_columns');
add_action('manage_team_posts_custom_column', 'custom_team_column', 10, 2);

function set_custom_edit_team_columns($columns)
{
  $columns['position_team'] = __('Cargo');

  return $columns;
}

function custom_team_column($column, $post_id)
{
  switch ($column) {

    case 'position_team':
      $terms = get_field('position_team', $post_id);
      if (is_string($terms))
        echo $terms;
      else
        __('Não existe cargo vinculado ao membro.');
      break;
  }
}
