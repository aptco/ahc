<?php
include_once "functions-course.php";
include_once "functions-seminar.php";

global $body_id;
$body_id = "course-single";

$post_type = "course";
$taxonomy_name = get_taxonomy_name_from_post_type($post_type);

$shop_btn_label = get_buy_btn_labels($post_type);
$shop_btn = get_shop_buttons($post_type, "order big", $shop_btn_label);

get_nav_list_pages($post_type, $taxonomy_name);

get_common();
get_header();
get_page_header($post_type);
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

				<!-- メイン情報 -->
				<div class="section seminar-outline clearfix">
					<h2><?php echo get_the_title(); ?><?php echo get_subtitle(); ?></h2>
					<div class="box-2-1">
						<?php echo get_acf_img_main(); ?>
						<div class="application-right">
			<?php echo $shop_btn ?>
			<?php write_buy_btn_top_message($post_type) ?>
						</div>
					</div>
					<div class="box-2-2">
						<div class="honbun">
							<?php echo the_field( 'short-description' ); ?>
						</div>
					</div>
				</div>
				<!-- //メイン情報 --> 

				<!-- 通信講座 詳細 -->
				<div class="section seminar-detail">
					<table class="detail-table">
						<tr class="schedule">
							<th scope="row">受講料</th>
							<td><?php echo get_price_text(''); ?></td>
						</tr>
						<tr class="schedule">
							<th scope="row">受講期間</th>
							<td><?php the_field( 'duration' ); ?></td>
						</tr>
<?php echo get_seminar_other_infos(); ?>
					</table>
				</div>
				<!-- //通信講座 詳細 --> 

				<!-- 通信講座 内容 -->
				<div class="section seminar-content">
					<h3>講座詳細</h3>
					<div class="description clearfix">
						<?php echo the_field( 'description' ); ?>
					</div>
				</div>
				<!-- //通信講座 内容 --> 

<?php echo get_lecturer_advices(); ?>

				<!-- 申し込み -->
				<div class="section application">
					<?php echo $shop_btn ?>
					<?php write_buy_btn_top_message($post_type) ?>
				</div>
				<!-- //申し込み --> 

				<!-- 申し込み 注意 -->
				<div class="section attention">
					<?php echo get_field("bottom-message") ?>
				</div>
				<!-- //申し込み 注意 --> 

<?php write_voices("受講者の声"); ?>
<?php write_contents_footer(); ?>

			</div>
			<!-- //main-body -->

		</div>
		<!-- //メインカラム -->
		
	</div>
	<!-- //wrapper -->

<?php get_footer(); ?>