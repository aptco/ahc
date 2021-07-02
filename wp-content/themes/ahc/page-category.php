<?php
global $post;

$post_type = $post->post_type;
$is_menu_category = true;

switch($post_type)
{
	case "article":
		$slug = "";
		$taxonomy_name = "category";
		$is_menu_category = false;
	break;
	default:
		$slug = get_slug_from_category($post->ID);
		$post_type = get_post_type_from_slug($slug);
		$taxonomy_name = get_taxonomy_name_from_post_type($post_type);
		$category_slug = get_category_slug_from_slug($slug);
	break;
}

if ($is_menu_category)
{
	$args = array(
		'post_status' 	=> 'publish',
		'post_type'		=> $post_type,
		'hierarchical'  => true,
		'hide_empty'    => true,
		'order'			=> 'ASC',
		'orderby'   	 => 'menu_order'
	);

	$my_query = new WP_Query($args);

	get_nav_list_categories($taxonomy_name, $category_slug);
}
else
{
	get_nav_list_pages($post_type, $taxonomy_name);
}

get_common();
get_header();
get_page_header($slug);
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
<?php write_content(); ?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>