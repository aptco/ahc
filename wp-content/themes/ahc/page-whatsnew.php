<?php
/*
Template Name: お知らせ
Description: 「お知らせ」のテンプレート
*/
include_once "functions-whatsnew.php";

update_news_entries();

get_common();
get_header();
get_text_page_header( "お知らせ" );
?>

	<div class="wrapper">
		
		<!-- main-body -->
		<div class="main-body">
			<div class="section news">
				<div class="border-list">
					<ul class="list">
<?php write_list_of_news(); ?>
					</ul>
				</div>
			</div>
		</div>
		<!-- //main-body -->

	</div>
	<!-- //wrapper -->


<?php get_footer(); ?>