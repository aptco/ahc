<?php
/*
Template Name: 出版物：トップ
Description: 「出版物：トップ」のテンプレート
*/
include_once "functions-pub.php";

$slug = "publication";
$post_types = array("magazine", "book");
$taxonomy_name = "category-item";
$category_slug = get_category_slug_from_slug($slug);
$error_message = get_category_error_message($category_slug);

get_nav_list_categories($taxonomy_name, $category_slug, false, false);

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
<?php 
global $post;

//最新のBe!
$args = array(
	'post_status' 	=> 'publish',
	'post_type'		=> "magazine",
	'meta_key'		=> 'is-new',
	'meta_value'	=> 1,
	'tax_query' => array(
		array(
			'taxonomy' => $taxonomy_name,
			'field' => 'name',
			'terms' => "季刊［ビィ］Be!",
			'include_children' => true
		)
	),
	'orderby'		=> array(
		'title' => 'ASC'
	)	
);

$posts = get_posts($args);

if(count($posts) > 0):
?>
			<div class="category-title">最新のBe!</div>
<?php
foreach($posts as $post)
{
	write_pub_archive();
}
endif;

//最新刊
$args = array(
	'post_status' 	=> 'publish',
	'post_type'		=> $post_types,
	'orderby'		=> 'meta_value',
	'meta_key'		=> 'shop-url',
	'order'			=> 'ASC',
	'meta_query'	=> array(
		array(
			'key'		=> 'is-new',
			'value'		=> 1
		)
	),
	'tax_query' => array(
		array(
			'taxonomy' => $taxonomy_name,
			'field' => 'name',
			'terms' => "季刊［ビィ］Be!",
			'include_children' => true,
			'operator'=>'NOT IN'
		)
	)
);

$posts = get_posts($args);

if(count($posts) > 0):
?>
			<div class="category-title">最新刊</div>
<?php
foreach($posts as $post)
{
	write_pub_archive();
}
endif;

//おすすめ
$args = array(
	'post_status' 	=> 'publish',
	'post_type'		=> $post_types,
	'orderby'		=> 'meta_value',
	'meta_key'		=> 'shop-url',
	'order'			=> 'ASC',
	'meta_query'	=> array(
		array(
			'key'		=> 'is-recommend',
			'value'		=> 1
		)
	)
);

$posts = get_posts($args);

if(count($posts) > 0):
?>
			<div class="category-title">おすすめ</div>
<?php
foreach($posts as $post)
{
	write_pub_archive();
}
endif;
?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>