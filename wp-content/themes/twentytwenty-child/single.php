<?php
get_header();

$meta = get_post_meta(get_the_ID());
?>
<div class="emt-container">
    <article class="emt-single-product">
        <h1 class="emt-single-product__title">
            <?php echo get_the_title(); ?>
        </h1>
        <figure class="emt-single-product__image-wrapper">
            <?php the_post_thumbnail('full', ['class' => 'emt-single-product__image']); ?>
        </figure>
        <div class="emt-single-product__content">
            <?php the_content(); ?>
        <?php if ($meta['_youtube_video'][0]) : ?>
            <div class="emt-single-product__video">
                <iframe
                    width="560"
                    height="315"
                    src="https://www.youtube.com/embed/<?php echo $meta['_youtube_video'][0]; ?>?controls=0"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                >
            </iframe>
            </div>
        <?php endif; ?>
        </div>
        <div class="emt-single-product__gallery">
            <?php
            $gallery = $meta['_gallery'][0];
            $gallery = explode(',', $gallery);

            foreach($gallery as $img) :
            ?>
            <figure class="emt-single-product__gallery-image-wrapper">
            <?php
                echo wp_get_attachment_image($img, 'large', false, ['class' => 'emt-single-product__gallery-image']);
            ?>
            </figure>
            <?php
            endforeach;
            ?>
        </div>
        <div class="emt-single-product__pricing">
            <h2 class="emt-single-product__pricing-headline">
                <?php _e('Pricing'); ?>
            </h2>
            <p class="emt-single-product__price <?php echo $meta['_is_on_sale'][0] ? 'emt-single-product__price--on-sale' : ''; ?>">
                <?php echo $meta['_price'][0]; ?>
            </p>
        <?php if ($meta['_is_on_sale'][0]) : ?>
            <p class="emt-single-product__sale-price">
                <?php echo $meta['_sale_price'][0]; ?>
            </p>
        <?php endif; ?>
        </div>

        <?php include('template-parts/related-products.php'); ?>
    </article>
</div>
