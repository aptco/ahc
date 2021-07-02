<?php

function write_seminar_archive()
{
	$url = get_permalink();
?>
			<!--  セミナー  -->
			<div class="section block-outline">
				<div class="main-img">
					<a href="<?php echo $url; ?>"><?php echo get_acf_img_main(); ?></a>
				</div>
				<div class="block">
					<div class="title">
						<a href="<?php echo $url; ?>"><?php echo get_the_title(); ?><?php echo get_subtitle(); ?></a>
					</div>
					<div class="sub">
						<ul></ul>
					</div>
					<div class="list">
						<ul>
							<li>日程：<?php echo get_acf_date_string(get_field("date"), get_field("date-display")); ?></li>
							<li>時間：<?php the_field( 'time' ); ?></li>
							<li>定員：<?php the_field( 'capacity' ); ?>名</li>
							<li>参加費：<?php echo get_price_tag(); ?></li>
							<li>講師：<?php echo wp_trim_words(get_field( 'lecturers' )); ?></li>
						</ul>
					</div>
				</div>
				<div class="block" style="clear: both;">
					<div class="content"><?php echo wp_trim_words(get_contents_for_list(), 150); ?></div>
				</div>
			</div>
			<!--  //セミナー  -->
<?php
}

function get_seminar_other_infos()
{
	$entries = get_field( 'others' );

	$str = "";
	$tabs = get_tabs(6);

	if (!$entries || count($entries) == 0) return $str;

	foreach($entries as $entry)
	{
		$str .= $tabs . '<tr class="other">' . "\n";
		$str .= $tabs . '	<th scope="row">' . $entry['label'] . '</th>' . "\n";
		$str .= $tabs . '	<td>' . $entry['text'] . '</td>' . "\n";
		$str .= $tabs . '</tr>' . "\n";
	}
	return $str;
}

function get_lecturer_advices()
{
	$entries = get_field( 'advices' );

	$str = "";
	$tabs = get_tabs(3);

	if (!$entries || count($entries) == 0) return $str;

	foreach($entries as $entry)
	{
		$post = $entry[ 'lecturer' ];

		$lecturer_name = $post->post_title;
		$lecturer_img = get_acf_img_main($lecturer_name, $post->ID);

		$str .= $tabs . '<!-- ひとこと -->' . "\n";
		$str .= $tabs . '<div class="section topic">' . "\n";

		$str .= $tabs . '	<div class="title">講師からのひとこと</div>' . "\n";
		$str .= $tabs . '	<div class="author">' . "\n";
		$str .= $tabs . '		' . $lecturer_img . "\n";
		$str .= $tabs . '		<p>' . $lecturer_name . '</p>' . "\n";
		$str .= $tabs . '	</div>' . "\n";

		$str .= $tabs . '	<div class="honbun">' . "\n";

		$text = $entry['text'];
		$text = convert_em_in_content($text);

		$str .= $tabs . '	' . $text ."\n";
		$str .= $tabs . '	</div>' . "\n";

		$str .= $tabs . '</div>' . "\n";
		$str .= $tabs . '<!-- //ひとこと -->' . "\n";
	}
	return $str;
}

function write_true_colors_alt_page()
{
	global $truecolors_transfer_id;

	$post_id = $truecolors_transfer_id;
	$post = get_post($post_id);
	$content = $post->post_content;
?>
				<div class="section honbun">
<?php echo $content; ?>
				</div>
<?php
}
	
	


