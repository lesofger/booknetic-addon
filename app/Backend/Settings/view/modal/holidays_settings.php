<?php

defined('ABSPATH') or die();

use BookneticApp\Providers\Helpers\Helper;

?>
<div id="booknetic_settings_area">
	<link rel="stylesheet" href="<?php echo Helper::assets('css/holidays.css', 'Settings')?>">
	<script type="application/javascript" src="<?php echo Helper::assets('js/holidays.js', 'Settings')?>"></script>

	<div class="settings-light-portlet">
		<div class="ms-content pl-0 pr-0">

			<div class="yearly_calendar">

			</div>

		</div>
	</div>

	<script>
		var dbHolidays = <?php echo $parameters['holidays']?>;
	</script>
</div>
