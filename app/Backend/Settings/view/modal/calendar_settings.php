<?php

defined('ABSPATH') or die();

use BookneticApp\Providers\Helpers\Helper;

/**
 * @var mixed $parameters
 */
?>

<script>
    var eventContentShortCodes = <?php echo json_encode($parameters['shortcodeList']) ?>;

    var eventContentShortCodesObject = {};
    eventContentShortCodes.forEach((value) => {
        eventContentShortCodesObject[value.code] = value.name;
    });
</script>

<link rel="stylesheet" href="<?php echo Helper::assets('plugins/summernote/summernote-lite.min.css') ?>"
      type="text/css">
<link rel="stylesheet" href="<?php echo Helper::assets('css/summernote.css') ?>" type="text/css">

<script src="<?php echo Helper::assets('plugins/summernote/summernote-lite.min.js') ?>"></script>
<script src="<?php echo Helper::assets('js/summernote.js') ?>"></script>
<script type="application/javascript"
        src="<?php echo Helper::assets('js/calendar_settings.js', 'Settings') ?>"></script>

<div id="booknetic_settings_area">
    <div class="settings-light-portlet">
        <div class="ms-content">
            <form class="position-relative calendar-addon-settings">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="event-color"><?php echo bkntc__('Event Color') ?>:</label>
                        <select class="form-control" id="event-color">
                            <option value="serviceColor"
								<?php echo $parameters["appointmentCardColor"] === 'serviceColor' ? "selected" : "" ?>
                            >
								<?php echo bkntc__('Service Color') ?>
                            </option>
                            <option value="statusColor"
								<?php echo $parameters["appointmentCardColor"] === 'statusColor' ? "selected" : "" ?>
                            ><?php echo bkntc__('Status Color') ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="event-content"><?php echo bkntc__('Event Content') ?>:</label>
                        <textarea class="form-control" id="event-content">
                            <?php echo htmlspecialchars($parameters["appointmentCardContent"]) ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group col-md-12 d-flex">
                    <input id="defaultCalendar" type="checkbox" class="form-control" <?php echo $parameters["shouldUseDefaultCardStyles"] ? "checked" : "" ?>>
                    <label for="defaultCalendar">Use default styles</label>
                </div>
            </form>
        </div>
    </div>
</div>