<?php

/**
 * Plugin Name: Glossário Simples
 * Description: Adiciona um Glossário Simples ao Wordpress que somente olha o conteúdo desejado, sem internas, sem filtros ou seja Simples.
 * Version: 1.1
 * Author: Willder Azevedo
 */
if (!defined('ABSPATH')) {
    exit;
}

function wa_glossary_custom_post_type()
{
    $postLabels = [
        'name' => 'Glossário',
        'singular_name' => 'Termo',
        'menu_name' => 'Glossário',
        'name_admin_bar' => 'Termo do Glossário',
        'add_new' => 'Adicionar Novo',
        'add_new_item' => 'Adicionar Novo Termo',
        'new_item' => 'Novo Termo',
        'edit_item' => 'Editar Termo',
        'view_item' => 'Ver Termo',
        'all_items' => 'Todos os Termos',
        'search_items' => 'Buscar Termos',
        'not_found' => 'Nenhum termo encontrado',
        'not_found_in_trash' => 'Nenhum termo encontrado na lixeira'
    ];

    $taxonomyLabels = [
        'name' => 'Categorias do Glossário',
        'singular_name' => 'Categoria do Glossário',
        'search_items' => 'Buscar Categorias',
        'all_items' => 'Todas as Categorias',
        'parent_item' => 'Categoria Pai',
        'parent_item_colon' => 'Categoria Pai:',
        'edit_item' => 'Editar Categoria',
        'update_item' => 'Atualizar Categoria',
        'add_new_item' => 'Adicionar Nova Categoria',
        'new_item_name' => 'Nome da Nova Categoria',
        'menu_name' => 'Categorias do Glossário',
    ];

    $postArgs = [
        'labels' => $postLabels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'glossario'],
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-book',
        'supports' => ['title', 'editor'],
    ];

    $taxonomyArgs = [
        'labels' => $taxonomyLabels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'glossario-categoria'],
    ];

    register_post_type('wa_glossary', $postArgs);

    register_taxonomy(
        'wa_glossary_category',
        ['wa_glossary'],
        $taxonomyArgs
    );
}

add_action('init', 'wa_glossary_custom_post_type');

function wa_glossary_register_settings()
{
    register_setting(
        'wa_glossary_settings_group',
        'wa_glossary_wrapper_class',
        [
            'sanitize_callback' => 'sanitize_html_class',
            'default' => 'glossary-wrapper'
        ]
    );

    register_setting(
        'wa_glossary_settings_group',
        'wa_glossary_auto_inject',
        [
            'sanitize_callback' => function ($value) {
                return $value ? 1 : 0;
            },
            'default' => 1
        ]
    );

    add_settings_section(
        'wa_glossary_main_section',
        'Configurações do Glossário',
        null,
        'wa-glossary-settings'
    );

    add_settings_field(
        'wa_glossary_wrapper_class',
        'Classe Wrapper',
        'wa_glossary_wrapper_class_callback',
        'wa-glossary-settings',
        'wa_glossary_main_section'
    );

    add_settings_field(
        'wa_glossary_auto_inject',
        'Auto Injeção',
        'wa_glossary_auto_inject_callback',
        'wa-glossary-settings',
        'wa_glossary_main_section'
    );
}

add_action('admin_init', 'wa_glossary_register_settings');

function wa_glossary_wrapper_class_callback()
{
    $value = get_option(
        'wa_glossary_wrapper_class',
        'glossary-wrapper'
    );

    echo '
        <input
            type="text"
            name="wa_glossary_wrapper_class"
            value="' . esc_attr($value) . '"
            class="regular-text"
        />
    ';

    echo '
        <p class="description">
            Classe CSS usada pelo Glossário Simples.
        </p>
    ';
}

function wa_glossary_auto_inject_callback()
{
    $value = get_option(
        'wa_glossary_auto_inject',
        1
    );

    echo '
        <label>
            <input
                type="checkbox"
                name="wa_glossary_auto_inject"
                value="1"
                ' . checked(1, $value, false) . '
            />
            Adicionar automaticamente o wrapper no conteúdo
        </label>
    ';
}

function wa_glossary_add_settings_page()
{
    add_options_page(
        'Glossário Simples',
        'Glossário Simples',
        'manage_options',
        'wa-glossary-settings',
        'wa_glossary_render_settings_page'
    );
}

add_action('admin_menu', 'wa_glossary_add_settings_page');

function wa_glossary_render_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    ?>
    <div class="wrap">
        <h1>Glossário Simples</h1>

        <form method="post" action="options.php">
            <?php
            settings_fields('wa_glossary_settings_group');
            do_settings_sections('wa-glossary-settings');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

function wa_glossary_auto_inject_wrapper($content)
{
    if (is_admin()) {
        return $content;
    }

    if (!is_singular()) {
        return $content;
    }

    $autoInject = get_option(
        'wa_glossary_auto_inject',
        1
    );

    if (!$autoInject) {
        return $content;
    }

    $wrapperClass = get_option(
        'wa_glossary_wrapper_class',
        'glossary-wrapper'
    );

    if (strpos($content, $wrapperClass) !== false) {
        return $content;
    }

    return '
        <div class="' . esc_attr($wrapperClass) . '">
            ' . $content . '
        </div>
    ';
}

add_filter(
    'the_content',
    'wa_glossary_auto_inject_wrapper'
);

function wa_glossary_enqueue_scripts()
{
    $terms = get_posts([
        'post_type' => 'wa_glossary',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false
    ]);

    $termsObject = [];

    foreach ($terms as $term) {
        $categories = wp_get_post_terms(
            $term->ID,
            'wa_glossary_category'
        );

        $categoryNames = [];

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $categoryNames[] = $category->name;
            }
        }

        $termsObject[] = [
            'title' => $term->post_title,
            'content' => wpautop(
                wp_kses_post($term->post_content)
            ),
            'category' => implode(
                ' | ',
                $categoryNames
            )
        ];
    }

    $wrapperClass = get_option(
        'wa_glossary_wrapper_class',
        'glossary-wrapper'
    );

    wp_enqueue_style(
        'wa-bootstrap-css',
        plugin_dir_url(__FILE__) . 'libs/bootstrap/5.3.8/style.css',
        [],
        '5.3.8'
    );

    wp_enqueue_script(
        'wa-bootstrap-js',
        plugin_dir_url(__FILE__) . 'libs/bootstrap/5.3.8/main.js',
        ['jquery'],
        '5.3.8',
        true
    );

    wp_enqueue_script(
        'wa-he',
        plugin_dir_url(__FILE__) . 'libs/he/1.2.0/main.js',
        [],
        '1.2.0',
        true
    );

    wp_enqueue_style(
        'wa-glossary-style',
        plugin_dir_url(__FILE__) . 'assets/style.css',
        [],
        '1.0.0'
    );

    wp_enqueue_script(
        'wa-glossary-script',
        plugin_dir_url(__FILE__) . 'assets/core.js',
        [],
        '1.1.0',
        true
    );

    wp_localize_script(
        'wa-glossary-script',
        'glossaryData',
        [
            'terms' => $termsObject,
            'class' => $wrapperClass
        ]
    );
}

add_action(
    'wp_enqueue_scripts',
    'wa_glossary_enqueue_scripts',
    20
);
