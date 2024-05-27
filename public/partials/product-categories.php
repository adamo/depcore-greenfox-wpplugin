<div id="filters" class="depcore-buttons button-group">
    <button class="button depcore-filter-button is-checked"
        data-filter="all"><?= __('Show all', 'depcore-greenfox') ?></button>
    <?php foreach ($product_categories as $category) : ?>
    <button class="button depcore-filter-button" data-filter="<?= $category->slug ?>"><?= $category->name ?></button>
    <?php endforeach; ?>
</div>