<?php
include_once "functions-course.php";

$post_type = "course";
$taxonomy_name = get_taxonomy_name_from_post_type($post_type);
$error_message = get_category_error_message_by_post_type($post_type);

get_nav_list_categories($taxonomy_name);
//get_nav_list_pages($post_type, $taxonomy_name);

get_common();
get_header();
get_page_header($post_type);

//左カラムに通信セミナーの「読み物」を追加
global $side_nav_datas;
$side_nav_datas[] = get_nav_category_pages_data("article", "category", "course", false);

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
<?php write_archives_from_query(null, "write_course_archive", $error_message); ?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>