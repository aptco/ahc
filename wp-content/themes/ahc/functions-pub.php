<?php

function write_pub_archive()
{
	global $post;
	$url = get_permalink();
?>
			<!--  <?php echo get_the_title(); ?>  -->
			<div class="section block-outline">
				<div class="main-img">
					<a href="<?php echo $url; ?>"><?php echo get_acf_img_main(); ?></a>
				</div>
				<div class="block">
					<?php echo get_pub_labels(); ?>
					<div class="title">
						<a href="<?php echo $url; ?>"><?php echo get_the_title(); ?></a>
					</div>
					<div class="sub">
						<ul>
							<?php if ($post->post_type == "magazine") echo getPubDates(); ?>
							<li><?php echo get_price_text('価格'); ?></li>
						</ul>
					</div>
					<div class="content"><?php echo wp_trim_words(get_contents_for_list(), 150); ?></div>
				</div>
			</div>
			<!--  //<?php echo get_the_title(); ?>  -->
<?php
}

function get_nav_list_pub_single($post_type, $taxonomy_name)
{
	get_nav_list_pages($post_type, $taxonomy_name);
}

function get_pub_labels($post_id = null)
{
	$pub_labels = get_pub_label_html("li", $post_id);
	if ($pub_labels == "") return "";

	$str = "";
	$tabs = get_tabs(5);

	$str .= $tabs . '<div class="pub-labels">' . "\n";
	$str .= $tabs . '	<ul>' . "\n";
	$str .= $tabs . $pub_labels . "\n";
	$str .= $tabs . '	</ul>' . "\n";
	$str .= $tabs . '</div>' . "\n";

	return $str;
}

function getPubDates()
{
	$pub_dates = get_field( 'pub-date' );
	$str = "";

	if (!$pub_dates || count($pub_dates) == 0) return $str;

	foreach($pub_dates as $entry)
	{
		if (array_key_exists('pub-date-label', $entry)) $label = $entry['pub-date-label'];		
		else $label = $entry['label'];

		if ($entry['date'] != "") $str .= '<li>' . $label . '：' . $entry['date'] . '</li>' . "\n";
	}
	return $str;
}

function getPriceText()
{
	return '<li>' . get_price_text('価格') . '</li>' . "\n";
}

function getAuthors($post_type)
{
	switch($post_type)
	{
		case "magazine":
			return getPublishers();
		break;

		case "book":
			return getBookAuthors();
		break;

		case "goods":
			return getCreditsInfo();
		break;
	}
}

function getBookAuthors()
{
	return get_li_from_repeater('author', 'author-label', 'value', 8);
}

function getPublishers()
{
	$publishers = get_field( 'publisher' );

	if (count($publishers) == 0 || (count($publishers) == 1 && $publishers[0]['value'] == ""))
	{
		$publishers = get_field( 'be-publisher', 'option' );
	}

	return get_li_from_repeater_entries($publishers, 'pub-label', 'value', 8);
}

function getCreditsInfo()
{
	$credits = get_field( 'credits-info' );

	$ary = preg_split("/\r?\n/", $credits);

	$str = "";
	$tabs = get_tabs(8);

	if (count($ary) > 0)
	{
		foreach($ary as $entry)
		{
			preg_match("/([^　]+)　([^　 \n\t\r]+)/u", $entry, $m);
			if (count($m) > 2)
			{
				$str .= $tabs . '<li>' . $m[1] . '：' . $m[2] . '</li>' . "\n";
			}
			else
			{
				$str .= $tabs . '<li>' . $entry . '</li>' . "\n";
			}
		}
	}
	return $str;
}

function getBookSize()
{
	$book_size = get_field( 'book-size' );
	$page_num = get_field( 'page-num' );

	$ary = array();
	if ($book_size) $ary[]= $book_size;
	if ($page_num) $ary[]= $page_num . "ページ";
	
	if (count($ary) == 0) return "";
	return '<li>' . implode("／", $ary). '</li>' . "\n";
}

function getISBN()
{
	$isbn = get_field( 'isbn' );
	if (!$isbn) return "";
	return '<li>' . "ISBN：" . $isbn . '</li>' . "\n";
}