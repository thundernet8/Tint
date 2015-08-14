<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.4
 * @date      2015.1.21
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<script type="text/javascript">
	$('.site_loading').animate({'width':'55%'},50);  //第二个节点
</script>
<?php if(tin_is_mobile()) { ?>
<div id="sidebar" class="clr"></div>
<?php } else { ?>
<?php $sidebar = tin_sidebar_primary(); ?>
<div id="sidebar" class="clr">
<?php dynamic_sidebar($sidebar); ?>
<div class="floatwidget-container">
</div>
</div>
<?php } ?>
<script type="text/javascript">
	$('.site_loading').animate({'width':'78%'},50);  //第三个节点
</script>