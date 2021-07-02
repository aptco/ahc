<?php
include_once "functions-pub.php";

$post_type = "magazine";

$taxonomy_name = get_taxonomy_name_from_post_type($post_type);
$error_message = get_category_error_message_by_post_type($post_type);

$slug = get_query_var( 'term' ); 
$term = get_term_by('slug', $slug, $taxonomy_name);

$ancestors = get_ancestors($term->term_id, $taxonomy_name);
$ancestor = get_term_by('id', $ancestors[count($ancestors) - 1], $taxonomy_name);

$root_catname = $ancestor->name;
if ($root_catname == "予防教育グッズ") $post_type = "goods";

get_nav_list_categories($taxonomy_name);

get_common();
get_header();
get_page_header($post_type);
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
<?php write_archives_from_query(null, "write_pub_archive", $error_message); ?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>