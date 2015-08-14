<?php
/*
	Tinection Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2014 知言博客 - http://www.zhiyanblog.com
	
		@package Tinection
		@version 1.0.0
*/
class tinfloatwidget extends WP_Widget {
/*  Widget
/* ------------------------------------ */
	function __construct(){
		parent::__construct(false,'Tin-浮动小工具',array( 'description' => 'Tinection-可浮动小工具，随鼠标滚动超出可视区域后将浮动重新显示，选择位置请放置此工具至指定边栏，要浮动的内容请放置到Float边栏' ,'classname' => 'floatwidget'));
	}

	function widget($args,$instance){
		extract($args);
	?>
		<?php echo $before_widget; ?>
			<?php dynamic_sidebar('Float'); ?>
		<?php echo $after_widget; ?>

	<?php }
	}
add_action('widgets_init',create_function('', 'return register_widget("tinfloatwidget");'));?>