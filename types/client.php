<?php

add_action('init', 'register_client');

function register_client()
{
  $labels = array(
    'name' => _x('Clientes', 'Nome geral do tipo'),
    'singular_name' => _x('Cliente', 'Nome singular do tipo'),
    'add_new' => _x('Adicionar novo', 'Adicionar novo slider'),
    'add_new_item' => __('Adicionar cliente'),
    'edit_item' => __('Editar cliente'),
    'all_items' => 'Clientes',
    'new_item' => __('Novo cliente'),
    'view_item' => __('Ver cliente'),
    'search_items' => __('Buscar cliente'),
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
    'menu_icon' => 'dashicons-businessman',
    'supports' => array('title', 'author', 'thumbnail', 'revisions'),
    'rewrite' => array('slug' => 'client', 'with_front' => FALSE)
  );

  register_post_type('client', $args);
}
