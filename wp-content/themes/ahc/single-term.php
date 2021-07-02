<?php
global $post;

get_common();
get_header();
get_page_header();
?>

	<div class="wrapper">
			<!-- main-body -->
			<div class="main-body">
<?php write_content(); ?>
<?php write_contents_footer(); ?>
			</div>
			<!-- //main-body -->
	</div>

<?php get_footer(); ?>