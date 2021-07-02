<?php
include_once "functions-glossary.php";

$paged = (get_query_var('paged'))?get_query_var('paged'):1;
$post_per_page = 100;

$args = array(
	'post_type' => 'term',
	'offset' => $paged,
	//'order' => 'DESC',
	'posts_per_page' => -1
);

$query = new WP_Query($args);
sort_glossary_posts($query->posts);
wp_reset_query();

get_common();
get_header();

get_text_page_header( "アディクション用語集" );
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
<?php write_list_of_glossary(); ?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->

	</div>
	<!-- //wrapper -->

<?php get_footer(); ?>