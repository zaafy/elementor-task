<div class="emt-container">
    <section class="emt-products-list">
    <?php
    $args = array(
        'post_type' => 'emt_products',
        'posts_per_page' => '-1',
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            include('product-listing-element.php');
        }
    }
    wp_reset_postdata();
    ?>
    </section>
</div>