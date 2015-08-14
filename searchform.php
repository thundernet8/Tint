<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.0
 * @date      2014.12.16
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<form method="get" class="searchform themeform" action="<?php echo home_url('/'); ?>">
	<div>
		<input type="text" class="search" name="s" onblur="if(this.value=='')this.value='<?php _e('Search..','tinection'); ?>';" onfocus="if(this.value=='<?php _e('Search..','tinection'); ?>')this.value='';" value="<?php _e('Search..','tinection'); ?>" maxlength="20" required="required" />
	</div>
</form>