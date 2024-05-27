<article class='filtr-item' data-category="<?= $this->get_customm_post_type_categories_as_classes()  ?>">
    <figure><a href="<?= get_permalink() ?>"><?php the_post_thumbnail('stal_image_size_square') ?></a></figure>
    <section class="product-information">
        <nav class='depcore-products-categories-links'><?=  $this->get_customm_post_type_categories_as_links() ?></nav>
        <h4 class='depcore-product-name'><a href="<?= get_permalink() ?>"> <?=  get_the_title() ?></a></h4>
    </section>
</article>
