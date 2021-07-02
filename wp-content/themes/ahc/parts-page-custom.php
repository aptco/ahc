<?php
global $post;

$post_type = $post->post_type;

switch($post_type)
{
	case "page":
	case "article":
		$slug = get_slug_from_category($post->ID);
		$taxonomy_name = "category";
		$category_slug = "";
	break;
	default:
		$slug = get_slug_from_category($post->ID);
		$post_type = get_post_type_from_slug($slug);
		$taxonomy_name = get_taxonomy_name_from_post_type($post_type);
		$category_slug = get_category_slug_from_slug($slug);
	break;
}

get_nav_list_custom($post_type, $taxonomy_name, $category_slug);

get_common();
get_header();
get_page_header($slug);
?>

	<div class="wrapper">

<?php if (!get_field("lmenu-none")): ?>
		<!-- サブカラム -->
		<div id="sub-column">
<?php write_side_column(); ?>
		</div>
		<!-- サブカラム -->
<?php endif; ?>

<?php if (!get_field("lmenu-none")): ?>
		<!-- メインカラム -->
		<div id="main-column">
<?php endif; ?>

			<!-- main-body -->
			<div class="main-body">
<?php write_content(); ?>
<?php write_contents_footer(); ?>
			</div>
			<!-- //main-body -->

<?php if (!get_field("lmenu-none")): ?>
		</div>
		<!-- //メインカラム -->
<?php endif; ?>
	</div>

<?php get_footer(); ?>