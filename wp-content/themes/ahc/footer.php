<?php 
/**
 * @package ahc-ahc
 */
global $gnav_datas;
get_global_nav();
?>
	<!-- 共通フッタ -->
	<footer id="footer">
		<div class="contact">
			<div class="wrapper">
				<p>出張研修・講演・講座などについてのお問い合わせはこちらからどうぞ</p>
				<div class="contact-btn">
					<a href="<?php echo get_permalink_from_key("contact"); ?>">お問い合わせ</a>
				</div>
			</div>
		</div>
		<!-- フッターナビ -->
		<div class="footer-links">
			<div class="navi wrapper">
				<ul>
<?php echo $gnav_datas[3];?>
				</ul>
			</div>
			<div class="external wrapper">
				<ul>
<?php write_list_of_external_links();?>
				</ul>
			</div>
		</div>
		<!--// フッターナビ -->
<?php if(is_home()): ?>
		<!-- サイトをシェア -->
		<div class="sns-home">
			<div class="wrapper">
<?php write_sns_links(home_url('/')); ?>
			</div>
		</div>
		<!--// サイトをシェア -->
<?php endif; ?>
		<div class="corporate-info">
			<div class="notice">
				<ul>
<?php write_list_of_notice_links();?>
				</ul>
			</div>
			<div class="copyright">
				<span class="name"> アスク・ヒューマン・ケア </span><br>
				<span class="address"><?php the_field("company-address", "options") ?></span><br>
				<span class="copy"> ©2021 ASK </span>
			</div>
		</div>
	</footer>
<?php 
	global $template;
	$template_name = basename($template, '.php');
	//echo $template_name . "<br/>";
	//var_dump(wp_get_referer());
?>
<!-- // 共通フッタ -->
<?php wp_footer(); ?>
<script type="text/javascript" src="<?php assets_dir();?>js/libs/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php assets_dir();?>js/libs/tweenlite.min.js"></script>
<script type="text/javascript" src="<?php assets_dir();?>js/libs/required.js"></script>
<script type="text/javascript" src="<?php assets_dir();?>js/common.js"></script>
<?php if(is_home()): ?>
<script type="text/javascript" src="<?php assets_dir();?>js/libs/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php assets_dir();?>js/home.js"></script>
<?php endif; ?>

</body>
</html>