<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://depcore.pl
 * @since      1.0.0
 *
 * @package    Depcore_Greenfox
 * @subpackage Depcore_Greenfox/public/partials
 */
?>
<?php  foreach ($metabox_group as $name => $group) : ?>

    <button class="accordion"><?= __($name,'depcore-greenfox'); ?></button>
    <div class="panel">
        <ul class='depcore-product-information'>
            <?php foreach ($group as $metabox) : ?>
                <?php $field = get_post_meta(get_the_ID(), $prefix.$metabox, true); ?>
                <?php if ($field != '') : ?>
                <li>
                    <strong><?php echo Depcore_Greenfox_Admin::create_cmb_name($metabox) ?>:</strong> <?= $field ?>
                </li>
                <?php endif; ?>
            <?php endforeach ?>
        </ul>
    </div>
<?php endforeach ?>
