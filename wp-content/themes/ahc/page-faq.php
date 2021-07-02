<?php
/*
Template Name: よくある質問
Description: 「よくある質問」のテンプレート
*/
include_once "functions-faq.php";

update_faq_entries();

get_common();
get_header();
get_text_page_header( "よくある質問" );
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
<?php write_list_of_faq(); ?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->

	</div>
	<!-- //wrapper -->

<?php get_footer(); ?>