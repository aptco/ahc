<?php
include_once "functions-lecturer.php";

$post_type = "lecturer";

get_nav_list_pages($post_type);

get_common();
get_header();
get_page_header();
?>

	<div class="wrapper">

		<!-- サブカラム -->
		<div id="sub-column">
<?php write_side_column(); ?>
		</div>
		<!-- サブカラム -->
		
		<!-- メインカラム -->
		<div id="main-column">
			<!-- main-body -->
			<div class="main-body">	

				<!-- 講師 -->
				<div class="section profile">
					<div class="main-img">
						<?php echo get_acf_img_main(); ?>
					</div>
					<div class="block">
						<ul class="name-list">
							<li class="name"><?php echo get_the_title(); ?></li>
							<li class="furigana"><?php echo get_field('furigana'); ?></li>
						</ul>
						<div class="job">
							<?php echo get_field('job'); ?>
						</div>
					</div>
				</div>
				<div class="section honbun">
					<?php echo get_field('profile'); ?>
				</div>
				<!-- //講師 -->
				
<?php echo get_contents_w_img(); ?>
<?php write_contents_footer(); ?>

			</div>
			<!-- //main-body -->

		</div>
		<!-- //メインカラム -->
		
	</div>
	<!-- //wrapper -->

<?php get_footer(); ?>