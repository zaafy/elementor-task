<?php
$meta_fields = [
    [
        'name' => 'price',
        'type' => 'number',
    ],
    [
        'name' => 'is_on_sale',
        'type' => 'boolean',
    ],
    [
        'name' => 'sale_price',
        'type' => 'number',
    ],
    [
        'name' => 'youtube_video',
        'type' => 'string',
    ],
    [
        'name' => 'gallery',
        'type' => 'string',
    ],
    [
        'name' => 'gallery_urls',
        'type' => 'string',
    ],
];

define('EMT_META_FIELDS', $meta_fields);

add_action( 'init', function() {
    foreach (EMT_META_FIELDS as $field) {
        register_post_meta( 'post', $field['name'], [
            'show_in_rest' => true,
            'single' => true,
            'type' => $field['type'],
        ]);
    }
});

function emt_register_meta() {
    foreach (EMT_META_FIELDS as $field) {
        register_meta('post', '_'.$field['name'], array(
            'show_in_rest' => true,
            'type' => $field['type'],
            'single' => true,
            'auth_callback' => function() {
                return current_user_can('edit_posts');
            }
        ));
    }
}

add_action('init', 'emt_register_meta');

