<?php
// register rest route for category endpoint
add_action( 'rest_api_init', function () {
	register_rest_route( 'emt_task/v1', '/category/(?P<category>[a-zA-Z0-9-]+)', array(
	  'methods' => 'GET',
	  'callback' => 'emt_products_by_category',
	) );
} );

// create the endpoint to return products by given category
function emt_products_by_category(WP_REST_Request $request) {
    $category = $request->get_param( 'category' );
    $field = 'slug';

    if (is_numeric($category)) {
        $field = 'term_id';
    }

    $products = get_posts(array(
        'post_type' => 'emt_products',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => $field,
                'terms' => $category,
            )
        )
    ));

    $output = array();

    foreach ($products as $prod) {
        $title = $prod->post_title;
        $desc = $prod->post_content;
        $image = get_the_post_thumbnail_url($prod->ID, 'full');
        $meta = get_post_meta($prod->ID);
        $price = $meta['_price'][0];
        $sale_price = $meta['_sale_price'][0];
        $is_on_sale = $meta['_is_on_sale'][0];

        if (empty($is_on_sale)) {
            $is_on_sale = '0';
        }

        $combined = array(
            'title' => $title,
            'description' => $desc,
            'image' => $image,
            'price' => $price,
            'sale_price' => $sale_price,
            'is_on_sale' => $is_on_sale,
        );

        array_push($output, $combined);
    }

    return $output;
}