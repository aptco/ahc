<?php
function write_course_archive()
{
	$url = get_permalink();
?>
			<!--  セミナー  -->
			<div class="section block-outline">
				<div class="main-img">
					<a href="<?php echo $url; ?>"><?php echo get_acf_img_main(); ?></a>
				</div>
				<div class="block">
					<div class="title">
						<a href="<?php echo $url; ?>"><?php echo get_the_title(); ?><?php echo get_subtitle(); ?></a>
					</div>
					<div class="sub">
						<ul></ul>
					</div>
					<div class="list">
						<ul>
							<li><?php echo get_price_text('受講料'); ?></li>
						</ul>
					</div>
				</div>
				<div class="block" style="clear: both;">
					<div class="content"><?php echo wp_trim_words(get_contents_for_list(), 150); ?></div>
				</div>
			</div>
			<!--  //セミナー  -->
<?php
}
	
	


