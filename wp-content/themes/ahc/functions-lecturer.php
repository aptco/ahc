<?php

function write_lecturer_archive()
{
	global $post;
	$url = get_permalink();
?>
			<!--  <?php echo get_the_title(); ?>  -->
			<div class="section block-outline lecturer">
				<div class="main-img">
					<a href="<?php echo $url; ?>"><?php echo get_acf_img_main(); ?></a>
				</div>
				<div class="block">
					<div class="title">
						<a href="<?php echo $url; ?>"><?php echo get_the_title(); ?></a>
					</div>
					<div class="sub">
						<ul>
							<li><?php echo get_field( 'furigana' ); ?></li>
						</ul>
					</div>
					<div class="content"><?php echo get_field( 'job' ); ?></div>
				</div>
			</div>
			<!--  //<?php echo get_the_title(); ?>  -->
<?php
}