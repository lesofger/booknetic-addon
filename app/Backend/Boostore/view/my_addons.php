<?php

use BookneticApp\Providers\Helpers\Helper;
use BookneticApp\Providers\Helpers\Date;

defined('ABSPATH') or die();

/**
 * @var $parameters
 */
$tourGuideSupportedAddons = [ 'booknetic-customforms' ];
?>

<link rel="stylesheet" href="<?php echo Helper::assets('css/shared.css', 'Boostore') ?>" type='text/css'>

<div class="m_header clearfix">
    <div class="m_head_title float-left">
        <div class="m_head_title float-left">
            <a href="admin.php?page=<?php echo Helper::getBackendSlug(); ?>&module=boostore"><?php echo bkntc__('Add-ons'); ?></a>
            <i class="mx-2"><img src="<?php echo Helper::icon('arrow.svg'); ?>"></i>
            <span class="name"><?php echo bkntc__('My addons'); ?></span>
        </div>
    </div>
    <div class="m_head_actions float-right">
        <a class="btn btn-lg btn-warning" href="admin.php?page=<?php echo Helper::getBackendSlug(); ?>&module=cart"> <i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> <?php echo bkntc__('CART'); ?> <span class="badge badge-info" id="bkntc_cart_items_counter"><?php echo $parameters[ 'cart_items_count' ]; ?></span> </a>
        <a class="btn btn-lg btn-primary float-right ml-1" href="admin.php?page=<?php echo Helper::getBackendSlug(); ?>&module=boostore&action=my_purchases"><?php echo bkntc__('MY PURCHASES'); ?></a>
    </div>
</div>

<div class="fs_separator"></div>

<div class="m_content pt-0" id="fs_data_table_div">
    <div class="fs_data_table_wrapper">
        <table class="fs_data_table elegant_table">
            <thead>
            <tr>
                <th></th>
                <th><?php echo bkntc__('Add-on'); ?></th>
                <th><?php echo bkntc__('Date & time'); ?></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($parameters['items'])): ?>
                <tr>
                    <td colspan="100%" class="pl-4 text-secondary"><?php echo bkntc__('No entries!'); ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($parameters['items'] as $purchase): ?>
                    <tr>
                        <td></td>
                        <td><?php echo htmlspecialchars($purchase['name']); ?></td>
                        <td><?php echo Date::dateTime($purchase['created_at']); ?></td>
                        <td class="text-right">
                            <?php if ($purchase[ 'is_installed' ] && in_array($purchase[ 'slug' ], $tourGuideSupportedAddons) && !Helper::getOption($purchase[ 'slug' ] . '_tour_guide_passed', false)): ?>
                                <button class="btn btn-addon-setup" data-addon="<?php echo htmlspecialchars($purchase[ 'slug' ]); ?>">
                                    <?php echo bkntc__('Set up now'); ?>
                                </button>
                            <?php endif; ?>
                        </td>
                        <td class="text-left">
                            <?php if ($purchase['is_installed']): ?>
                                <button class="btn btn-outline-danger btn-uninstall" data-addon="<?php echo htmlspecialchars($purchase['slug']); ?>">
                                    <?php echo bkntc__('UNINSTALL'); ?>
                                </button>
                            <?php else: ?>
                                <button class="btn btn-success btn-install" data-addon="<?php echo htmlspecialchars($purchase['slug']); ?>">
                                    <?php echo bkntc__('INSTALL'); ?>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="<?php echo Helper::assets('js/shared.js', 'Boostore'); ?>"></script>
<script src="<?php echo Helper::assets('js/my_addons.js', 'Boostore'); ?>"></script>

<?php if ($parameters[ 'is_migration' ]): ?>
    <div id="migrationModal" class="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="progress mb-4" style="height: 8px;">
                    <div id="migrationProgress" class="progress-bar"></div>
                </div>

                <div class="mb-2">
                    <?php echo bkntc__('We are migrating your data.'); ?><br>
                    <?php echo bkntc__('Please wait until the migration process is done.'); ?><br>
                </div>

                <div class="text-danger">
                    <?php echo bkntc__('Do not leave the page.'); ?>
                </div>
            </div>

        </div>
    </div>

    <script src="<?php echo Helper::assets('js/migration.js', 'Boostore'); ?>"></script>
<?php endif; ?>
