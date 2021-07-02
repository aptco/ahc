<?php
/*
Template Name: セミナー：トップ
Description: 「セミナー：トップ」のテンプレート
*/
include_once "functions-seminar.php";

$post_type = "seminar";
$taxonomy_name = get_taxonomy_name_from_post_type($post_type);
$error_message = get_category_error_message_by_post_type($post_type);

get_nav_list_categories($taxonomy_name);
global $side_nav_datas;
$side_nav_datas[] = get_nav_cat_data_for_seminar_calendar();

get_common();
get_header();
get_page_header($post_type);

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
	'post_status' 	=> 'publish',
	'post_type'		=> $post_type,
	'hierarchical'  => true,
	'hide_empty'    => true,
	'order'			=> 'ASC',
	'orderby'   	 => 'meta_value_num',
	'meta_key'   	 => 'date',
	'paged'			=> $paged,
	'posts_per_page'=> 10
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
write_archives_from_query($my_query, "write_seminar_archive", $error_message);
?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>