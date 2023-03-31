<?php
$query_var_id = get_query_var('emt_product_id');
$id = $query_var_id ? $query_var_id : get_the_ID();
$meta = get_post_meta($id);
$background_color = get_query_var('emt_product_bgc') ?? false;
?>
<a
  class="emt-product"
  href="<?php echo get_the_permalink($id); ?>"
  <?php echo $background_color ? 'style="background-color: '. $background_color .';"' : ''; ?>
>
    <figure class="emt-product__image-wrapper">
    <?php if ($meta['_is_on_sale'][0]) : ?>
        <span class="emt-product__sale-badge">
            <?php _e('Sale', 'emt_task_domain'); ?>
        </span>
    <?php endif; ?>
        <?php echo get_the_post_thumbnail($id, 'thumbnail', ['class' => 'emt-product__image']); ?>
    </figure>
    <h4 class="emt-product__title">
        <?php echo get_the_title($id); ?>
    </h4>
<?php if ($query_var_id) :?>
        <p class="emt-product__price <?php echo $meta['_is_on_sale'][0] ? 'emt-product__price--on-sale' : ''; ?>">
            <?php echo $meta['_price'][0]; ?>
        </p>
    <?php if ($meta['_is_on_sale'][0]) : ?>
        <p class="emt-product__sale-price">
            <?php echo $meta['_sale_price'][0]; ?>
        </p>
    <?php endif; ?>
<?php endif; ?>
</a>