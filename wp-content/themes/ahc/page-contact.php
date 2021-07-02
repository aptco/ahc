<?php
/*
Template Name: お問い合わせ
Description: 「お問い合わせ」のテンプレート
*/

get_common();
get_header();
get_text_page_header( get_the_title() );
?>

	<div class="wrapper form">
		
		<!-- main-body -->
		<div class="main-body">
<?php the_content(); ?>
		</div>
		<!-- //main-body -->

	</div>
	<!-- //wrapper -->

<?php get_footer(); ?>