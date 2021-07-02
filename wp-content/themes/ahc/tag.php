<?php
include_once "functions-types.php";

get_common();
get_header();

global $wp_query;

$tag_name = single_tag_title("", false);

$title =  "タグ：" . $tag_name;
$error_message = 'タグ：<strong>' . $tag_name . '</strong>に登録されているページはありません。';

get_text_page_header( $title );
?>
	<div class="wrapper">

		<!-- サブカラム -->
		<div id="sub-column">	　
		</div>
		<!-- サブカラム -->
		
		<!-- メインカラム -->
		<div id="main-column">
			<!-- main-body -->
			<div class="main-body">
<?php loop_all_post_types($error_message); ?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>