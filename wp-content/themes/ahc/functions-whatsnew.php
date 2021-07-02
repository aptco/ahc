<?php
/*--------------------
　お知らせ
---------------------*/

function update_news_entries()
{
	global $post_ids, $news_entries;

	$post_id = $post_ids["whats-new"];
	$field_name = 'news-entry';

	$ary = array();

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$date = get_sub_field('date');
		$date_display = get_sub_field('date-display');

		$data = array(
			"date" => $date,
			"date_string" => get_acf_date_string($date, $date_display),
			"text" => get_sub_field('text'),
			"link" => get_link_object_from_subfields()
		);

		$ary[] = $data;

	endwhile;

	usort($ary, function($a, $b)
	{
		return strcmp($b['date'], $a['date']);
	}
	);

	$news_entries = $ary;
}

function write_list_of_news($num = 0)
{
	global $news_entries;

	$ary = $news_entries;

	foreach ($ary as $i => $data)
	{
		echo write_entry_of_news($data, 3);

		if ($num > 0 && $i >= $num - 1) break;
	}
}

function write_list_of_news_for_home($num = 0)
{
	global $news_entries;

	$ary = $news_entries;

	foreach ($ary as $i => $data)
	{
		echo write_entry_of_news($data, 3);

		if ($num > 0 && $i >= $num - 1) break;
	}
}

function write_entry_of_news($data, $tabnum)
{
	$str = "";
	$tabs = get_tabs($tabnum);

	$text = $data["text"];
	$link = $data["link"];

	$str .= $tabs . '<li>'."\n";
	$str .= $tabs . '	<span class="date">'. $data["date_string"]  . '</span>' . "\n";
	$str .= $tabs . '	' . get_alink_html($text, $link["url"], $link["target"]) . "\n";
	$str .= $tabs . '</li>'."\n";

	return $str;
}