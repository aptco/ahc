<?php
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
?>

	<div class="wrapper">

		<!-- サブカラム -->
		<div id="sub-column">
<?php write_side_column(); ?>
		</div>
		<!-- //サブカラム -->


		<!-- メインカラム -->
		<div id="main-column">
			<!-- main-body -->
			<div class="main-body">
<?php
$slug = get_query_var( 'term' );
if ($slug == "true-colors")
{
	write_true_colors_alt_page();
}
else
{
	write_archives_from_query(null, "write_seminar_archive", $error_message);
}
?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>