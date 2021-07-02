<?php
/*
Template Name: 講師紹介
Description: 「講師紹介」のテンプレート
*/
include_once "functions-lecturer.php";

$post_type = 'lecturer';
$taxonomy_name = get_taxonomy_name_from_post_type($post_type);
$error_message = get_category_error_message_by_post_type($post_type);

get_nav_list_pages($post_type);

get_common();
get_header();
get_page_header($post_type);

$args = array(
	'post_status' 	=> 'publish',
	'post_type'		=> $post_type,
	'hierarchical'  => true,
	'hide_empty'    => true,
	'order'			=> 'ASC',
	'orderby'   	 => 'menu_order',
	'paged' => $paged,
	'posts_per_page' => 15
);

$my_query = new WP_Query($args);
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
<?php 
write_archives_from_query($my_query, "write_lecturer_archive", $error_message);
?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>