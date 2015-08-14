<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.1.3
 * @date      2015.1.4
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<div class="container two-col-container cms-bar">
<div id="main-wrap-left">
<?php get_template_part('includes/stickys'); ?>
<?php 
	$args=array(  
		'orderby' => 'id',  
		'order' => 'ASC',
		'exclude' => ot_get_option('cmsundisplaycats')
	);
?>
<?php 
	$customcats = ot_get_option('cmsdisplaycats'); 
	if(!empty($customcats)){
		$catids = explode(',',$customcats);
		foreach($catids as $catid){
			$categories[] = get_category($catid);
		}
	}else{$categories = get_categories($args);}
	$i=0;$m=0;
	foreach ($categories as $cat) {
		$catid = $cat->cat_ID;
		$catname = $cat->cat_name;
		query_posts(array('cat'=>$catid,'post__not_in'=>get_option('sticky_posts'),'posts_per_page'=>-1));
		$catlink = get_category_link($catid);
		$i++;
		$tp = tin_get_cms_cat_template($catid,1);
?>
<?php if($i<=6&&$tp!='catlist_bar_0'){ ?>
<?php if($m!=0)echo '</section>'; ?>
	<section class="catlist-<?php echo $catid;?> catlist clr">
		<div class="catlist-container clr">
			<h2 class="home-heading clr">
				<span class="heading-text">
					<?php echo $catname;?>
				</span>
				<a href="<?php echo $catlink;?>"><?php _e('+ 更多','tinection'); ?></a>
			</h2>
		<?php get_template_part('includes/'.$tp,esc_attr( $catid ));?>	
		</div>
	</section>
	<?php if($i==1){ ?>
		<?php if(!tin_is_mobile()){ ?>
			<div id="loopad" class="container banner">
			<?php echo ot_get_option('cmswithsidebar_loop_ad'); ?>
			</div>
		<?php }else{ ?>
			<div id="loopad" class="mobile-ad">
			<?php echo ot_get_option('singlead1_mobile'); ?>
			</div>
		<?php }?>
	<?php }?>
<?php $m=0;}else{ $m++;?>
<?php if($m==1) { ?>
	<section class="catlist clr">
<?php } ?>
	<section class="catlist-<?php echo $catid;?> catlist_1_of_2">
		<div class="catlist-container clr">
			<h2 class="home-heading clr">
				<span class="heading-text">
					<?php echo $catname;?>
				</span>
				<a href="<?php echo $catlink;?>"><?php _e('→ 更多','tinection'); ?></a>
			</h2>
		<?php get_template_part('includes/catlist_bar_0',esc_attr( $catid ));?>	
		</div>
	</section>
<?php }?>
<?php }?>
<?php if($m!=0)echo '</section>'; ?>
<!-- pagination -->
<div class="clear">
</div>
<div class="pagination">
<?php pagenavi(); ?>
</div>
<!-- /.pagination -->
</div>
<?php wp_reset_query(); ?>
<?php get_sidebar();?>
</div>
<div class="clear">
</div>