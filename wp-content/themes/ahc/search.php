<?php
include_once "functions-types.php";

get_nav_list_search_results();

get_common();
get_header();

global $wp_query, $hns_search_result_type_counts;

$total_results = $wp_query->found_posts;
$search_query = get_search_query();

$search_title =  "検索結果：" . $search_query . '<span>（' . $total_results . '件）</span>';
$error_message = '<strong>' . $search_query . '</strong> に一致する情報は見つかりませんでした。';

get_text_page_header( $search_title );
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
<?php loop_all_post_types($error_message); ?>
			</div>
			<!-- //main-body -->
		</div>
		<!-- //メインカラム -->
	</div>

<?php get_footer(); ?>