<?php
/**
 * Main Template of Tinection WordPress Theme
 *
 * @package   Tinection
 * @version   1.0.9
 * @date      2014.12.09
 * @author    Zhiyan <chinash2010@gmail.com>
 * @site      Zhiyanblog <www.zhiyanblog.com>
 * @copyright Copyright (c) 2014-2015, Zhiyan
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      http://www.zhiyanblog.com/tinection.html
**/

?>
<?php $style = ot_get_option('blocks_style','normal_blocks'); ?>
<div class="container blocks">
	<section class="catlist clr">
		<div id="<?php echo $style; ?>" class="catlist-container-rand clr">
		<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; $uncat = ot_get_option('cmsundisplaycats');
			  query_posts(array('post__not_in'=>get_option('sticky_posts'),'category__not_in'=>$uncat,'paged' => $paged)); ?>
		<?php $i=4; while (have_posts()) : the_post(); $r = fmod($i,4)+1; $i++;?>
		<span class="col span_1_of_4 col-<?php echo $r;?> <?php if($style=='fluid_blocks') echo 'masonry-box'; ?>">
			<article class="home-blog-entry clr home-blog-entry-rand">
			<?php  if(!get_post_format()) { $format = 'standard'; } else { $format = get_post_format(); }?>
			<?php get_template_part('includes/thumbnail',esc_attr( $format )); ?>
			<div class="home-blog-entry-text contentcms-entry-text clr">
			<?php $category = get_the_category(); $catname1 = $category[0]->cat_name; $catnum1 = $category[0]->cat_ID; $catr = fmod($catnum1+rand(0,10),7)+1;?>
			<?php switch ($catr) {
				case '7':
					$bgcolor = 'pink';
					break;
				case '6':
					$bgcolor = 'orange';
					break;
				case '5':
					$bgcolor = 'yellow';
					break;
				case '4':
					$bgcolor = 'green';
					break;
				case '3':
					$bgcolor = 'blue';
					break;
				case '2':
					$bgcolor = 'blue';
					break;
				default:
					$bgcolor = 'purple';
				break;
			}?>
			<div class="ribbon ribbon-<?php echo $bgcolor; ?>"><?php echo $catname1; ?>&nbsp;&nbsp;&nbsp;</div>
				<h3 style="margin-top:10px">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h3>
				<p>
					<?php $contents = get_the_excerpt(); $excerpt = wp_trim_words($contents,120,''); echo $excerpt.new_excerpt_more('...');?>
				</p>
				<div class="line"></div>
				<!-- Post meta -->
				<?php tin_post_meta(); ?>
				<!-- /.Post meta -->
			</div>
			</article>
		</span>
		<?php endwhile;?>
		</div>	
	</section>
	<?php if($style == 'normal_blocks'){ ?>
	<!-- pagination -->
	<div class="clear">
	</div>
	<div class="pagination">
		<?php pagenavi(); ?>
	</div>
	<!-- /.pagination -->
	<?php }else{ajaxmore();} ?>
</div>
<script type="text/javascript">
$('.site_loading').animate({'width':'75%'},50);
</script>