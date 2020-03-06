<?php

add_action('init', 'register_strategy');

function register_strategy()
{
  $labels = array(
    'name' => _x('Estratégias', 'Nome geral do tipo'),
    'singular_name' => _x('Estratégia', 'Nome singular do tipo'),
    'add_new' => _x('Adicionar nova', 'Adicionar novo slider'),
    'add_new_item' => __('Adicionar estratégia'),
    'edit_item' => __('Editar estratégia'),
    'all_items' => 'Estratégias',
    'new_item' => __('Nova estratégia'),
    'view_item' => __('Ver estratégia'),
    'search_items' => __('Buscar estratégia'),
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
    'menu_icon' => 'dashicons-rest-api',
    'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions'),
    'rewrite' => array('slug' => 'strategy', 'with_front' => FALSE)
  );

  register_post_type('strategy', $args);
}