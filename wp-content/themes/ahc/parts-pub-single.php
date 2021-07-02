<?php
global $post_id;
$has_shopURL = (get_field('shop-url', $post_id) != "");

$shop_btn_label = get_buy_btn_labels("publication");
$shop_btn = get_shop_buttons($post_type, "shopping", $shop_btn_label);
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

				<!--  商品情報  -->
				<div class="section block-outline">	
					<div class="main-img">
						<?php echo get_acf_img_main(); ?>
					</div>
					<div class="block">
						<?php echo get_pub_labels(); ?>
						<h2><?php echo get_the_title(); ?></h2>
						<div class="sub">
							<ul>
								<?php echo getPubDates(); ?>
							</ul>
						</div>
						<div class="list">
							<ul>
								<?php echo getPriceText(); ?>
								<?php echo getAuthors($post_type); ?>
<?php if ($post_type != "goods") : ?>							
								<?php echo getBookSize(); ?>
								<?php echo getISBN(); ?>
<?php endif; ?>					
							</ul>
						</div>
<?php if ($has_shopURL) : ?>	
						<div class="detail-btn">
							<?php echo $shop_btn ?>
						</div>
<?php endif; ?>
					</div>				
				</div>
				<!--  //商品情報  -->	

<?php echo get_contents_w_img(); ?>

<?php if ($has_shopURL) : ?>	
			<!-- 購入 -->
				<div class="application">
					<?php echo $shop_btn ?>
				</div>
			<!-- //購入 --> 
<?php endif; ?>

<?php
	if ($post_type == "magazine") write_single_pagenation("前の号へ", "次の号へ");
?>

<?php write_voices("読者の声"); ?>
<?php write_contents_footer(); ?>

			</div>
			<!-- //main-body -->

		</div>
		<!-- //メインカラム -->

	</div>
	<!-- //wrapper -->