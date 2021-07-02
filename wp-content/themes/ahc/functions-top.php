<?php
//トップページ

function get_top_box_html($index, $isEnd, $boxclass, $html, $cols = 3)
{
	$tabs = get_tabs(2);

	$bi = ($index % $cols) + 1;

	$str = "";
	if ($bi == 1) $str .= $tabs . '<div class="clearfix">' . "\n";

	$str .= $tabs . '	<div class="box-' . $cols . '-' . $bi . (($boxclass)?(" " . $boxclass):"") . '">' . "\n";
	$str .= $html;
	$str .= $tabs . '	</div>' . "\n";

	if ($bi == $cols || ($bi != $cols && $isEnd)) $str .= $tabs . '</div>' . "\n";

	return $str;
}

/*--------------------
　イベントエリア
---------------------*/

function  write_list_for_events()
{
	global $post_ids;

	$post_id = $post_ids["top-events"];
	$field_name = 'event-entry';

	$str = "";
	$tabs = get_tabs(3);

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$title = get_sub_field('title');
		$img = get_sub_field('img');
		$date = get_sub_field('date');
		$text = get_sub_field('text');
		$link = get_link_object_from_subfields();

		$str .= $tabs.'<li>'."\n";

		$str2 = "\n";
		$str2 .= $tabs.'		<div class="event-img"><img src="' . $img . '" alt="' . $title . '"></div>'."\n";
		$str2 .= $tabs.'		<span class="date">' . format_date($date) . '</span>'."\n";
		$str2 .= $tabs.'		<div class="text">' . $text . '</div>'."\n";

		$str .= $tabs.'	'. get_alink_html($str2, $link["url"], $link["target"]) ."\n";
		$str .= $tabs.'</li>'."\n";

	endwhile;

	echo $str;
}

/*--------------------
　悩み別リンク
---------------------*/

function write_top_article_links()
{
	global $post_ids;

	$post_id = $post_ids["top-links"];
	$field_name = 'article-links';

	$str = "";
	$tabs = get_tabs(4);

	$ri = 0;
	$rmax = count( get_field($field_name, $post_id) );

	while ( have_rows($field_name, $post_id) ) : the_row();

		$title = get_sub_field('title');
		$link = get_link_object_from_subfields();
		$text = get_sub_field('text');

		$str2 = "";
		$str2 .= $tabs . '<div class="issue">' . "\n";
		$str2 .= $tabs . '	<div class="title">' . $title . '</div>' . "\n";
		$str2 .= $tabs . '	<div class="text">' . $text . '</div>' . "\n";
		$str2 .= $tabs . '	<div class="btn">' . get_alink_html("詳しく見る", $link["url"], $link["target"]) . '</div>' . "\n";
		$str2 .= $tabs . '</div>' . "\n";

		$str .= get_top_box_html($ri, ($ri == $rmax - 1), "", $str2);
		$ri++;

	endwhile;

	echo $str;		
}

/*--------------------
　コンテンツリンク
---------------------*/

function write_top_content_links()
{
	global $post_ids;

	$post_id = $post_ids["top-links"];
	$field_name = 'content-links';

	$str = "";
	$tabs = get_tabs(4);

	$ri = 0;
	$rmax = count( get_field($field_name, $post_id) );

	while ( have_rows($field_name, $post_id) ) : the_row();

		$title = get_sub_field('title');
		$img = get_sub_field('img');
		$link = get_link_object_from_subfields();
		$alt = $title;
		$text = get_sub_field('text');
		$no_img = "";

		if (!$img)
		{
			$img =  get_temp_img("event");
			$no_img = " no-img";
		}

		$str2 = "";
		$str2 .= $tabs . get_alink_tag($link["url"], $link["target"]) . "\n";
		$str2 .= $tabs . '	<div class="title">' . $title . '</div>' . "\n";
		$str2 .= $tabs . '	<div class="img' . $no_img . '"><img src="' . $img . '" alt="' . $alt . '"></div>' . "\n";
		$str2 .= $tabs . '	<div class="text">' . $text . '</div>' . "\n";
		$str2 .= $tabs . '</a>' . "\n";

		$str .= get_top_box_html($ri, ($ri == $rmax - 1), "contents-link", $str2);
		$ri++;

	endwhile;

	echo $str;		
}

/*--------------------
　小バナー
---------------------*/

function write_list_of_large_banners()
{
	global $post_ids;

	$post_id = $post_ids["top-links"];
	$field_name = 'large-banners';

	$str = "";
	$tabs = get_tabs(3);

	$ri = 0;

	$str .= $tabs . '<ul class="l-banners">'."\n";

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$title = get_sub_field('title');

		$img_pc = get_sub_field('img-pc');
		$img_sp = get_sub_field('img-sp');
		if (!$img_sp) $img_sp = $img_pc;

		$link = get_link_object_from_subfields();
		$alt = $title;

		$str .= $tabs . '	<li>'."\n";
		$str .= $tabs . '		' . get_alink_tag($link["url"], $link["target"]) . "\n";
		$str .= $tabs . '			<img src="' . $img_pc . '" alt="' . $alt . '" class="pc">'."\n";
		$str .= $tabs . '			<img src="' . $img_sp . '" alt="' . $alt . '" class="sp">'."\n";
		$str .= $tabs . '		</a>'."\n";
		$str .= $tabs . '	</li>'."\n";

		$ri++;

	endwhile;

	$str .= $tabs.'</ul>'."\n";

	echo $str;
}

/*--------------------
　小バナー
---------------------*/

function write_list_of_small_banners()
{
	global $post_ids;

	$post_id = $post_ids["top-links"];
	$field_name = 'small-banners';

	$str = "";
	$tabs = get_tabs(3);

	$ri = 0;
	$rmax = count( get_field($field_name, $post_id) );

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$title = get_sub_field('title');
		$img = get_sub_field('img');
		$link = get_link_object_from_subfields();

		if (!$img) $img =  get_temp_img("event");

		$str3 = get_img_tag($img) . '<span class="text">' . $title . '</span>';

		$str2 = '';
		$str2 .= $tabs .'	<div class="s-banner">' . "\n";
		$str2 .= $tabs .'		' . get_alink_html($str3, $link["url"], $link["target"]) . "\n";
		$str2 .= $tabs .'	</div>' . "\n";

		$str .= get_top_box_html($ri, ($ri == $rmax - 1), "", $str2, 2);
		$ri++;

	endwhile;

	echo $str;
}