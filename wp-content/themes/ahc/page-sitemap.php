<?php
/*
Template Name: サイトマップ
Description: 「サイトマップ」のテンプレート
*/
include_once "functions-sitemap.php";

get_common();
get_header();
get_text_page_header(get_the_title());
?>

	<div class="wrapper">

		<!-- main-body -->
		<div class="main-body">
<?php write_sitemap(); ?>
		</div>
		<!-- //main-body -->
		
	</div>

<?php get_footer(); ?>