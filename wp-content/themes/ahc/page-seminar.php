<?php
include_once "functions-seminar.php";

$post_type = "seminar";
$taxonomy_name = get_taxonomy_name_from_post_type($post_type);

get_nav_list_pages($post_type, $taxonomy_name);
global $side_nav_datas;
$side_nav_datas[] = get_nav_cat_data_for_seminar_calendar();

$shop_btn_label = get_buy_btn_labels($post_type);
$shop_btn = get_shop_buttons($post_type, "order big", $shop_btn_label);

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

				<!-- セミナー詳細 -->
				<div class="section seminar-detail">
					<table class="detail-table">
						<tr>
							<th scope="row">日程</th>
							<td><p><?php echo get_acf_date_string(get_field("date"), get_field("date-display")); ?></p></td>
						</tr>
						<tr>
							<th scope="row">時間</th>
							<td><?php the_field( 'time' ); ?></td>
						</tr>
						<tr>
							<th scope="row">定員</th>
							<td><?php the_field( 'capacity' ); ?>名</td>
						</tr>
						<tr class="schedule">
							<th scope="row">参加費</th>
							<td><?php echo get_price_tag(); ?></td>
						</tr>
						<tr class="schedule">
							<th scope="row">講師</th>
							<td><?php the_field( 'lecturers' ); ?></td>
						</tr>
						<tr class="schedule">
							<th scope="row">場所</th>
							<td><?php the_field( 'location' ); ?></td>
						</tr>
<?php echo get_seminar_other_infos(); ?>
					</table>
				</div>
				<!-- //セミナー詳細 --> 

				<!-- セミナー内容 -->
				<div class="section seminar-content">
					<h3>セミナー詳細</h3>
					<div class="description clearfix">
						<?php echo the_field( 'description' ); ?>
					</div>
				</div>
				<!-- //セミナー内容 --> 

<?php echo get_lecturer_advices(); ?>

				<!-- 申し込み -->
				<div class="section application">
					<?php echo $shop_btn ?>
					<?php write_buy_btn_top_message($post_type) ?>
				</div>
				<!-- //申し込み --> 

<?php write_voices("参加者の声"); ?>
<?php write_contents_footer(); ?>

			</div>
			<!-- //main-body -->

		</div>
		<!-- //メインカラム -->
		
	</div>
	<!-- //wrapper -->

<?php get_footer(); ?>