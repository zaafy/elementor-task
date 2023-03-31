<?php
$id = get_the_ID();
$post_terms = get_the_terms($id, 'category');
$tax_query = array();

if( !empty($post_terms) ){
    if( count( $post_terms ) > 1 ) {
        $tax_query['relation'] = 'OR' ;
    }

    foreach( $post_terms as $custom_term ) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $custom_term->slug,
        );
    }

    $args = array(
        'post_type' => 'emt_products',
        'posts_per_page' => 6,
        'tax_query' => $tax_query,
        'post__not_in' => [$id]
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
?>
<div class="emt-related-products">
    <h3 class="emt-related-products__heading">
        <?php _e('Related Products', 'emt_task_domain'); ?>
    </h3>
    <div class="emt-related-products__listing">
    <?php
        while ($query->have_posts()) {
            $query->the_post();
            include('product-listing-element.php');
        }
    ?>
    </div>
</div>
<?php
    }

    wp_reset_query();
}
?>