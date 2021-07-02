<?php
/*
Template Name: 予防教育グッズ：トップ
Description: 「予防教育グッズ：トップ」のテンプレート
*/
include_once "functions-pub.php";

$slug = "goods";
$post_types = array("goods");
$taxonomy_name = "category-item";
$category_slug = get_category_slug_from_slug($slug);
$error_message = get_category_error_message($category_slug);

get_nav_list_categories($taxonomy_name, $category_slug, false, false);

get_common();
get_header();
get_page_header($slug);

//予防グッズ
$args = array(
	'post_status' 	=> 'publish',
	'post_type'		=> $post_types,
	'hierarchical'  => true,
	'hide_empty'    => true,
	'orderby'		=> array(
		//'post_type' => 'DESC',
		'title' => 'ASC'
	),
	'paged' => $paged,
	'posts_per_page' => 10
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
//write_archives_from_query($my_query, "write_pub_archive", $error_message);
write_content();
write_contents_footer();
?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>