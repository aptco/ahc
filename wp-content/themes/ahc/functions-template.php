<?php

function write_article_archive()
{
	$url = get_permalink();
?>
			<!--  読み物  -->
			<div class="section block-outline">
				<div class="main-img">
					<a href="<?php echo $url; ?>"><?php echo get_acf_img_main(); ?></a>
				</div>
				<div class="block">
					<div class="title">
						<a href="<?php echo $url; ?>"><?php echo get_the_title(); ?></a>
					</div>
				</div>
				<div class="content"><?php echo wp_trim_words(get_contents_for_list(), 150); ?></div>
			</div>
			<!--  //読み物  -->
<?php
}

/*-------------------------
 Global Nav
-------------------------*/

function get_global_nav()
{
	global $page_params;
	global $gnav_datas;

	$seminar_enabled = false;

	if (count($gnav_datas) > 0) return;

	$datas = array("", "", "", "", array());

	$keys1 = array(
		"seminars",
		"publications",
		"goods",
		"courses",
		"lectures",
		"lecturers",
		"about",
		"faq",
		"access",
		"sitemap"
	);

	$keys2 = array(
		"seminars",
		"publications",
		"be",
		"courses",
		"lectures",
		"goods"
	);

	if (!$seminar_enabled)
	{
		array_shift($keys1);
		array_shift($keys2);
	}

	$tabs = get_tabs(4);

	foreach($keys1 as $i=>$key)
	{
		$ii = $i + 1;
		$entry = $page_params[$key];

		$name = $entry['name'];
		$url = $entry['url'];
		$priority = $entry['priority'];

		$classname = "";

		if ($priority == 1)
		{
			$classname = "main";
			//global
			//2020/03/16 fix 画像ずらす
			$img_i = $ii;
			if (!$seminar_enabled) $img_i ++;
			$datas[0] .= $tabs . '<li class="nav' . $ii . '"><a href="' . $url . '"><img src="' . get_assets_dir() . 'images/common/gnavi_0' . $img_i . '.png" alt="' . $name . '"></a></li>' . "\n";
		}
		else if ($priority == 2)
		{
			$classname = "primary";
			//primary
			$datas[1] .= $tabs . '	<li><a href="' . $url . '"><i class="fa fa-chevron-circle-right"></i>' . $name . '</a></li>' . "\n";
		}

		//sp
		$datas[2] .= $tabs . '<li class="' . $classname . '"><a href="' . $url . '">' . $name . '</a></li>' . "\n";

		//footer
		$datas[3] .= $tabs . '	<li><a href="' . $url . '">' . $name . '</a></li>' . "\n";	
	}

	foreach($keys2 as $i=>$key)
	{
		$entry = $page_params[$key];

		$name = $entry['name'];
		$url = $entry['url'];
		$priority = $entry['priority'];

		//home
		$datas[4][] = $url;
	}

	$gnav_datas = $datas;
}

/*-------------------------
 ACF Sub Column
-------------------------*/

//if (get_field("lmenu-none");

/*-------------------------
 Write Sub Column
-------------------------*/

function write_side_column()
{
	echo get_side_column();
}

function get_side_column_section($label, $html)
{
	$tabs = get_tabs(2);

	$str = "";
	$str .= $tabs . '	<!-- ' . $label . ' -->' . "\n";
	$str .= $tabs . '	<div class="section">' . "\n";

	$str .= $html;

	$str .= $tabs . '	</div>' . "\n";
	$str .= $tabs . '	<!-- //' . $label . ' -->' . "\n";

	return $str;
}

function get_mobile_local_navi()
{
	global $side_nav_datas;

	$html = "";
	$tabs = get_tabs(3);

	if ($side_nav_datas == null || !is_array($side_nav_datas) || count($side_nav_datas) == 0) return $html;

	foreach($side_nav_datas as $di=>$data)
	{
		$type = $data["type"];

		$str = "";

		if ($type == "nav")
		{
			$str = get_local_navi_li($data, $di);
		}

		if ($str == "") continue;

		$html .= $str;
	}

	return $html;
}

function get_side_column()
{
	global $side_nav_datas;

	$html = "";
	$tabs = get_tabs(3);

	if ($side_nav_datas == null || !is_array($side_nav_datas) || count($side_nav_datas) == 0) return $html;

	foreach($side_nav_datas as $di=>$data)
	{
		$type = $data["type"];
		
		$src_label = "";
		$str = "";

		if ($type == "nav")
		{
			$src_label = "ローカルナビ";

			$str .= $tabs . '<div class="local-navi">' . "\n";
			$str .= get_local_navi_li($data, $di);
			$str .= $tabs . '</div>' . "\n";

		}
		else if ($type == "seminar-calendar")
		{
			$src_label = "セミナーカレンダー";
			$str = get_seminar_calendar($data, $di);
		}

		if ($str == "") continue;

		$html .= get_side_column_section($src_label, $str);
	}

	return $html;
}

function get_local_navi_li($data, $index)
{
	$str = "";
	$tabs = get_tabs(3);

	if (array_key_exists('header', $data) && $data['header'])
	{
		$htag = 'h4';
		$header = $data['header'];

		$str .= $tabs . '	<div class="header">' . "\n";
		$str .= $tabs . '		<a href="' . $header['url'] . '">' . $header['name'] . '</a>'. "\n";
		$str .= $tabs . '	</div>' . "\n";
	}

	if (!array_key_exists('list', $data) || count($data['list']) == 0) return;

	$str .= $tabs . '	<ul class="local">' . "\n";

	$current_index = $data['current'];

	foreach($data['list'] as $i=>$entry)
	{
		$current = ($i == $current_index)?' class="current"':'';
		$label = (array_key_exists('labels', $entry))?$entry['labels']:"";
		$has_sub = array_key_exists('list', $entry);

		$str .= $tabs . '		<li' . $current . '>';
		if ($has_sub) $str .= "\n" . $tabs . '			';

		$has_url = (array_key_exists('url', $entry));

		if ($has_url) $str .= '<a href="' . $entry['url'] . '">';
		$str .= $label;
		$str .= $entry['name'];
		if ($has_url) $str .= '</a>';

		if ($has_sub)
		{
			$str .= "\n";
			$str .= $tabs . '			<ul class="sub">' . "\n";

			foreach($entry['list'] as $entry2)
			{
				$str .= $tabs . '				<li>' . "\n";
				$str .= $tabs . '					<a href="' . $entry2['url'] . '">' . $entry2['name'] . '</a>' . "\n";
				$str .= $tabs . '				</li>' . "\n";
			}

			$str .= $tabs . '			</ul>' . "\n";
			$str .= $tabs . '		';
		}

		$str .= '</li>' . "\n";
	}
	$str .= $tabs . '	</ul>' . "\n";

	return $str;
}


function get_seminar_calendar($data, $index)
{
	$str = "";
	$tabs = get_tabs(3);

	$str .= $tabs . '<div class="seminar-calendar">' . "\n";

	$htag = 'h4';
	$str .= $tabs . '	<div class="header">' . "\n";
	$str .= $tabs . '		<' .  $htag . '>' . '<i class="fa fa-calendar" aria-hidden="true"></i>セミナーカレンダー' . '</' .  $htag . '>' . "\n";
	$str .= $tabs . '	</div>' . "\n";

	if (!array_key_exists('list', $data) || count($data['list']) == 0) return;

	foreach($data['list'] as $m_key=>$m_ary)
	{
		preg_match("/([0-9]{4,})([0-9]{2,})/", $m_key, $m);
		$mon_jp = "";

		if (count($m) > 0) $mon_jp = $m[1] . '年' . $m[2] . '月';

		$str .= $tabs . '	<span class="subtitle month">' . $mon_jp . '</span>' . "\n";

		$str .= $tabs . '	<ul>' . "\n";

		foreach($m_ary as $i=>$entry)
		{
			$str .= $tabs . '		<li>';

			$str .= '<a href="' . $entry['url'] . '">' . $entry['name'] . '</a><br/>';
			$str .= '<span class="date">' . $entry['date'] . '</span>';

			$str .= '</li>' . "\n";
		}

		$str .= $tabs . '	</ul>' . "\n";
	}

	$str .= $tabs . '</div>' . "\n";

	return $str;
}

function get_nav_list_categories($taxonomy_name, $slug = "", $get_parent = true, $has_header = true)
{
	global $side_nav_datas;

	$side_nav_datas = array();
	$side_nav_datas[] = get_nav_categories_data($taxonomy_name, $slug, $get_parent, $has_header);
}

function get_nav_list_pages($post_type, $taxonomy_name = "", $args = null)
{
	global $side_nav_datas;

	$side_nav_datas = array();
	$side_nav_datas[] = get_nav_category_pages_data($post_type, $taxonomy_name, $args);
}

function get_nav_list_custom($post_type, $taxonomy_name = "", $slug = "")
{
	global $post, $side_nav_datas;

	$side_nav_datas = array();

	if (get_field("lmenu-current-cat"))
	{
		if ($post_type == "page") $post_type = "article";
		$side_nav_datas[] = get_nav_category_pages_data($post_type, $taxonomy_name, "", false);
	}

	$elements = get_field("lmenu-elements");

	if (is_array($elements) && count($elements) > 0)
	{
		foreach($elements as $element)
		{
			switch($element)
			{
				case "category-article":
					//$side_nav_datas[] = get_nav_list_pages($post_type, "category");
					$side_nav_datas[] = get_nav_category_pages_data($post_type, "category");
				break;
				case "category-item":
					$side_nav_datas[] = get_nav_cat_data_for_custom($element, "lmenu-cat-item");
				break;
				case "category-seminar":
					$side_nav_datas[] = get_nav_cat_data_for_custom($element, "lmenu-cat-seminar");
				break;
				case "category-course":
					$side_nav_datas[] = get_nav_cat_data_for_custom($element, "lmenu-cat-course");
				break;
				case "calendar-seminar":
					$side_nav_datas[] = get_nav_cat_data_for_seminar_calendar();
				break;
			}
		}
	}
}

function get_nav_cat_data_for_custom($taxonomy_name, $field_name)
{
	$selected = get_field($field_name);

	$slug = "";

	if ($selected != "")
	{
		$cats = get_the_terms($selected, $taxonomy_name);

		if ($cats)
		{
			$cats = sort_terms_hierarchicaly($cats);
			$cat = $cats[count($cats) - 1];

			$slug = $cat->name;
		}
	}

	return get_nav_categories_data($taxonomy_name, $slug, false, true, true);
}

function get_nav_categories_data($taxonomy_name, $slug = "", $get_parent = true, $has_header = true, $get_pages_on_no_categories = false)
{
	if (!$taxonomy_name) return;

	global $post, $wp_query;

	$current_term_id = -1;
	$parent_term_id = 0;

	if ($slug == "") $slug = get_query_var( 'term' ); 

	$term = get_term_by('slug', $slug, $taxonomy_name);

	if ($term)
	{
		if ($get_parent)
		{
			$current_term_id = $term->term_id;
			$parent_term_id = $term->parent;
		}
		else
		{
			$parent_term_id = $term->term_id;
		}
	}

	$cats = get_custom_categories($taxonomy_name, $parent_term_id);
	$header = null;
	$depth = -1;

	if (count($cats) == 0 && $get_pages_on_no_categories)
	{
		$post_type = get_post_type_from_category($parent_term_id, $taxonomy_name);

		return get_nav_category_pages_data($post_type, $taxonomy_name, $slug);
	}

	//Make List
	$list = array();

	if ($parent_term_id != 0)
	{
		$parent = get_term($parent_term_id, $taxonomy_name);

		$header = array(
			'name' => $parent->name,
			'url'  => get_term_link($parent)
		);
	}

	$current_index = -1;

	foreach($cats as $i=>$cat)
	{
		$id = $cat->term_id;

		$eAry = array(
			'name' => $cat->name,
			'url'  => get_term_link( $cat , $taxonomy_name )
		);

		if ($id == $current_term_id)
		{
			$current_index = $i;

			//Add children of current category
			$args = array( 'parent' => $id );
			$ary = get_terms( $cat->taxonomy , $args );

			if (is_array($ary) && count($ary) > 0)
			{
				$eAry['list'] = array();

				foreach($ary as $cat2)
				{
					$eAry2 = array(
						'name' => $cat2->name,
						'url'  => get_term_link( $cat2 , $taxonomy_name )
					);

					$eAry['list'][] = $eAry2;
				}
			}
		}

		$list[] = $eAry;

		if ($depth == -1)
		{
			$ancestors = get_ancestors($cat->term_id, $taxonomy_name);
			$depth = count($ancestors);
		}
	}

	if ($depth == -1) $depth = 0;

	$data = array(
		'type'		=> "nav",
		'list'		=> $list,
		'current'	=> $current_index,
		'depth'		=> $depth
	);

	if ($header != null && $has_header)
	{
		$data['header'] = filter_nav_header($header, $depth);
	}

	return $data;
}

function get_nav_category_pages_data($post_type, $taxonomy_name = "", $slug = "", $has_header = true)
{
	global $post, $isnew_label;

	$cat = null;
	$header = null;
	$depth = 0;

	if ($taxonomy_name != "")
	{
		if ($slug == "")
		{
			//Get First Parent Category
			$cat = get_first_category($post->ID, $taxonomy_name);
			if (!$cat) return;
		}
		else
		{
			$cat = get_term_by('slug', $slug, $taxonomy_name);
		}
		if (!$cat) return;


		//Get all posts below the Category
		$args = get_args_for_category_query($post_type, $taxonomy_name, $cat->term_id);

		if ($post_type == "article")
		{
			$parent_id = $post->post_parent;
			$parent_post = get_post($parent_id);

			//$args = get_args_for_post_type_query($post_type);
			$args["post_parent"] = $parent_id;

			$header = array(
				'name' => $parent_post->post_title,
				'url'  => get_permalink($parent_id)
			);
		}
		else
		{
			$header = array(
				'name' => $cat->name,
				'url'  => get_term_link($cat)
			);

			$ancestors = get_ancestors($cat->term_id, $taxonomy_name);
			$depth = count($ancestors);
		}
	}
	else
	{
		//Get all posts from the post type
		$args = get_args_for_post_type_query($post_type);
	}

	$depth++;

	$posts = get_posts($args);

	//Make List
	$list = array();

	$current_index = -1;

	foreach($posts as $i=>$entry)
	{
		$post_id = $entry->ID;
		$name = $entry->post_title;
		$url = get_permalink($post_id);

		$name2 = "";

		//Rename Functions
		if (post_type_is_or_includes("magazine", $post_type))
		{
			$name2 = rename_magazine_title_for_list($name);
		}

		if ($cat != null && $name2 == "")
		{
			$regex = "/^《?" . $cat->name . "》?/u";
			$name = preg_replace($regex, "", $name);
		}
		else if ($name2 != "")
		{
			$name = $name2;
		}

		$eAry = array(
			'name' => $name,
			'url'  => $url
		);

		if ($cat && $post_id == $post->ID)
		{
			$current_index = $i;

			//Add children of current page
			$args = get_args_for_category_query($post_type, $taxonomy_name, $cat->term_id);

			$args["post_parent"] = $post_id;

			$posts2 = get_posts($args);

			if (is_array($posts2) && count($posts2) > 0)
			{
				$eAry['list'] = array();

				foreach($posts2 as $i2=>$entry2)
				{
					$eAry2 = array(
						'name' => $entry2->post_title,
						'url'  => get_permalink($entry2->ID)
					);

					$eAry['list'][] = $eAry2;
				}
			}
		}

		//Get Labels (ie: NEW, Recommended)
		$eAry['labels'] = "";

		if ($taxonomy_name == "category-item")
		{
			$eAry['labels'] = get_pub_labels_for_list("magazine", $post_id);
		}

		$list[] = $eAry;
	}

	$data = array(
		'type'		=> "nav",
		'list'		=> $list,
		'current'	=> $current_index,
		'depth'		=> $depth
	);

	if ($header != null && $has_header)
	{
		$data['header'] = filter_nav_header($header, $depth);
	}

	//Main Nav
	//Set Pagination for Next and Prev Entries
	$prev_url = "";
	$next_url = "";

	if ($current_index > 0) $next_url = $list[$current_index - 1]['url'];
	if ($current_index < count($posts) - 1) $prev_url = $list[$current_index + 1]['url'];

	$data['prev-url'] = $prev_url;
	$data['next-url'] = $next_url;

	return $data;
}

function get_nav_cat_data_for_seminar_calendar()
{
	$args = array(
		'post_type'		=> 'seminar',
		'post_status' 	=> 'publish',
		'orderby'		=> 'meta_value',
		'meta_key'		=> 'date',
		'order'			=> 'ASC',
		'posts_per_page'=> 10
	);

	$posts = get_posts($args);

	//Make List
	$list = array();

	foreach($posts as $i=>$entry)
	{
		$post_id = $entry->ID;

		$name = $entry->post_title;
		$url = get_permalink($post_id);

		$date = get_field("date", $post_id);

		$display_date = get_field("date_display", $post_id);
		if ($display_date != "")
		{
			$d_date = format_display_date($display_date);
		}
		else
		{
			$d_date = format_date_short($date);
		}

		$d_date .= ' ' . get_field("time", $post_id);

		$mon_date = substr($date, 0, 6);

		$eAry = array(
			'name' => $name,
			'url'  => $url,
			'date' => $d_date
		);

		if (!array_key_exists($mon_date, $list)) $list[$mon_date] = array();

		$list[$mon_date][] = $eAry;
	}

	ksort($list);

	$data = array(
		'type'		=> "seminar-calendar",
		'list'		=> $list
	);

	return $data;
}

function filter_nav_header($header_ary, $depth)
{
	global $page_params;

	if ($depth <= 1)
	{
		switch($header_ary['name'])
		{
			case "出版物":
				$header_ary['url'] = $page_params["publications"]['url'];
			break;
			case "予防教育グッズ":
				$header_ary['url'] = $page_params["goods"]['url'];
			break;
			case "講演・出張講座":
				$header_ary['url'] = $page_params["lectures"]['url'];
			break;
		}
	}

	return $header_ary;
}

function get_nav_list_search_results()
{
	global $wp_query, $search_results_data, $side_nav_datas;

	$types = $search_results_data["types"];

	$list = array();

	$i = 0;
	$current_index = -1;

	foreach($types as $type=>$num)
	{
		$jp_name = "";
		$order = 0;

		if ($type == "article")
		{
			$jp_name = "その他";
			$order = 99;
		}
		else $jp_name = get_jp_name_from_post_type($type);

		$eAry = array(
			'name' => $jp_name . ' (' . $num . '件)',
			'url'  => home_url( '/' ) . "?s=" . $wp_query->query["s"] . "&post_type=" . $type,
			'order' => $order + $i
		);

		$list[] = $eAry;

		$i++;
	}

	usort($list, function($a, $b)
	{
		if ($a['order'] == $b['order']) return 0;
		else return ($a['order'] < $b['order'])?-1:1;
	}
	);

	$data = array(
		'type'		=> "nav",
		'list'		=> $list,
		'current'	=> $current_index
	);

	$side_nav_datas = array($data);
}

/*-------------------------
 Sub Column Pub
-------------------------*/

function rename_magazine_title_for_list($str)
{
	$regex = "/(季刊〔ビィ〕Be!(増刊号)?|季刊［ビィ］Be!)[ 　]*((No.)?[0-9]+号?)[　…]*(特集／)?(.*)$/u";

	preg_match($regex, $str, $m);
	if (count($m) > 0) $str = $m[3] . " " . $m[6];

	return $str;
}

function get_pub_labels_for_list($post_type, $post_id = null)
{
	$pub_labels = get_pub_label_html("span", $post_id);

	return $pub_labels;
}

/*-------------------------
 Archives
-------------------------*/

function write_archives_from_query($query, $archive_func, $error_message)
{
	global $wp_query;
	if ($query == null) $query = $wp_query;

	if ( $query->have_posts() ) :

		while ( $query->have_posts() ) : $query->the_post();
			if (function_exists($archive_func)) $archive_func();
		endwhile;
?>
		<!-- ページネーション -->
		<?php wp_pagination($query); ?>
		<!-- /ページネーション -->
<?php
	else :
		write_error_message($error_message);
	endif;
}

/*-------------------------
 Contents
-------------------------*/

function write_content()
{
	$content = get_the_content();

	if ($content != ""):
?>
			<div class="section honbun">
<?php the_content(); ?>
			</div>
<?php			
	endif;
}

function get_contents_for_list($post_id = null)
{
	$str = "";

	$list_description = get_field( 'list-description' , $post_id);
	if ($list_description != "") return $list_description;

	$description = get_field( 'description' , $post_id);
	if ($description != "") return $description;

	$contents = get_field( 'content' , $post_id );
	if (!$contents || count($contents) == 0) return get_post_field('post_content', $post_id);
	
	else if (is_array($contents))
	{
		$content1 = $contents[0];
		return $content1['text'];
	}

	/*
	$bool = have_rows( 'content' );
	if  ($bool)
	{
		the_row();
		return get_sub_field('text');
	}
	*/

	return $str;
}

function get_contents_w_img()
{
	$contents = get_field( 'content' );

	$str = "";
	$tabs = get_tabs(3);

	if (!$contents || count($contents) == 0) return $str;

	foreach($contents as $entry)
	{
		$str .= $tabs . '<!-- セクション -->' . "\n";
		$str .= $tabs . '<div class="section block-content">' . "\n";
		$str .= $tabs . '	<h3>' . $entry['title'] . '</h3>' . "\n";

		$img_class = '';

		if (array_key_exists('img', $entry))
		{
			$imgs = $entry['img'];

			if (count($imgs) > 0 && $imgs[0]['url'])
			{
				$img_class = ' w-img';

				$str .= $tabs . '	<div class="imgs">' . "\n";
				$str .= $tabs . '		<ul>' . "\n";
				foreach($entry['img'] as $img)
				{
					$str .= $tabs . '			<li>' . "\n";
					$str .= $tabs . '				<img src="' . $img['url'] . '" alt="' . $img['alt']  . '">' . "\n";
					if ($img["caption"]) $str .= $tabs . '				<span class="caption">' . $img["caption"] . '</span>' . "\n";
					$str .= $tabs . '			</li>' . "\n";;

				}
				$str .= $tabs . '		</ul>' . "\n";
				$str .= $tabs . '	</div>' . "\n";
			}		
		}

		$str .= $tabs . '	<div class="content clearfix' . $img_class . '">' . "\n";

		$text = $entry['text'];
		$text = convert_em_in_content($text);

		$str .= $tabs . '		' . $text . "\n";

		$str .= $tabs . '	</div>' . "\n";
		$str .= $tabs . '</div>' . "\n";
		$str .= $tabs . '<!-- //セクション -->' . "\n";
	}
	return $str;
}

/*-------------------------
 参加者の声
-------------------------*/

function write_voices($name_jp)
{
	$contents = get_field( "voices" );
	if ($contents == "") return;

	$entries = split_tag_to_array($contents, "p");
	if (!$entries || count($entries) == 0) return;

	$str = "";
	$tabs = get_tabs(3);

	$str .= $tabs . '<!-- ' . $name_jp . ' -->' . "\n";
	$str .= $tabs . '<div class="section voices">' . "\n";
	$str .= $tabs . '	<h3>' . $name_jp .'より</h3>' . "\n";
	$str .= $tabs . '	<div class="contents">' . "\n";
	$str .= $tabs . '		<ul>' . "\n";

	foreach($entries as $entry)
	{
		$entry = strip_tags($entry, '<br/>');
		$str .= $tabs . '			<li>' . "\n";
		$str .= $tabs . '			' . $entry . "\n";
		$str .= $tabs . '			</li>' . "\n";
	}

	$str .= $tabs . '		</ul>' . "\n";
	$str .= $tabs . '	</div>' . "\n";
	$str .= $tabs . '</div>' . "\n";
	$str .= $tabs . '<!-- //' . $name_jp .' -->' . "\n";

	echo $str;
}

/*-------------------------
 ページ下部共通
-------------------------*/

function write_contents_footer()
{
	write_tags();
	write_child_sns();
	write_recommendations();
}

/*-------------------------
 タグ
-------------------------*/

function write_tags()
{
	$str = '';
	$tabs = get_tabs(3);

	$tags = get_the_tags();

	if ( $tags )
	{
		$str .= $tabs . '<div class="tags">' . "\n";
		$str .= $tabs . '	<p class="title">' . '<i class="fa fa-tags" aria-hidden="true"></i>タグ：' . '</p>' . "\n";
		
			foreach ( $tags as $i=>$tag )
			{
				$url = get_tag_link($tag->term_id);
				if ($i > 0) $str .= '　'; 
				$str .= get_alink_html($tag->name, $url);
			}

		$str .= $tabs . '</div>' . "\n";
	}

	echo $str;
}

/*-------------------------
 もっと知りたい人
-------------------------*/

function write_recommendations()
{
	$entries = get_field( "page-links" );
	if (!$entries || count($entries) == 0) return;

	$str = "";
	$tabs = get_tabs(3);

	$str .= $tabs . '<!-- ベージュボックス -->' . "\n";
	$str .= $tabs . '<div class="box recommend">' . "\n";

	$str .= $tabs . '	<div class="box-title">もっと知りたい人に</div>' . "\n";

	$str .= $tabs . '	<div class="box-content">' . "\n";
	$str .= $tabs . '		<ul class="recommend-list">' . "\n";

	foreach($entries as $entry)
	{
		$category = "";

		$target_blank = false;

		if ($entry["acf_fc_layout"] == "internal-link")
		{
			$url = $entry["url"];
			$post_id = url_to_postid( $url );
			$post_type = get_post_type($post_id);

			$category = get_recommendation_category($post_id);
			$category_class = get_class_name_from_post_type($post_type);

			$title =	get_the_title($post_id);
			$img_tag = 	get_acf_img_main($title, $post_id);
			$text = 	wp_trim_words(get_contents_for_list($post_id), 100);
		}
		else
		{
			$category = $entry['category'];
			$category_class = "other";

			$title =	$entry['title'];
			$url =		$entry["url"];
			$img_url = 	$entry['img'];
			$text = 	$entry['text'];
			$target_blank = 	$entry['target-blank'];

			$img_tag = ($img_url == "")?"":get_img_tag($img_url, $title);
		}

		//If there are no eyecatch image
		if (!$img_tag || $img_tag == "") $img_tag = get_img_tag(get_temp_img("thumb"), $title);

		$link_tag = '<a href="' . $url . '" target="' . (($target_blank)?'_blank':'_self') . '">';

		$str .= $tabs . '			<li>' . "\n";
		$str .= $tabs . '				<div class="detail-img">' . $link_tag . $img_tag . '</a></div>' . "\n";
		$str .= $tabs . '				<div class="detail">' . "\n";
		if ($category != "")
		$str .= $tabs . '					<div class="detail-category"><p class="' . $category_class . '">' . $category . '</p></div>' . "\n";
		$str .= $tabs . '					<div class="detail-title">' . $link_tag . $title . '</a></div>' . "\n";
		$str .= $tabs . '					<div class="detail-text">' . "\n";
		$str .= $text . "\n";
		$str .= $tabs . '					</div>' . "\n";
		$str .= $tabs . '				</div>' . "\n";
		$str .= $tabs . '			</li>' . "\n";
	}

	$str .= $tabs . '		</ul>' . "\n";
	$str .= $tabs . '	</div>' . "\n";

	$str .= $tabs . '</div>' . "\n";
	$str .= $tabs . '<!-- //ベージュボックス -->' . "\n";

	echo $str;
}

/*-------------------------
 SNS 子ページ
-------------------------*/

function write_child_sns()
{
if(!is_home() && get_field("social-buttons") == 1): ?>
	<!-- ページをシェア -->
	<div class="sns-child">
<?php write_sns_links(get_permalink()); ?>
	</div>
	<!-- // ページをシェア -->
<?php endif;
}

/*-------------------------
 スライダーバナー
-------------------------*/

function write_title_slider()
{
?>
	<!-- バナーエリア -->
	<div class="area slider">
		<div class="slide-wrapper">
			<ul class="bxslider">
<?php echo get_list_for_slider() ?>
			</ul>
		</div>
	</div>
	<!-- // バナーエリア -->
<?php
}

function get_list_for_slider()
{
	global $post_ids;

	$post_id = $post_ids["top-slides"];
	$field_name = 'slide-entry';

	$str = "";
	$tabs = get_tabs(2);

	$i = 0;

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$title = get_sub_field('title');
		$img = get_sub_field('img');

		echo $tabs.'<li>'."\n";
		echo $tabs.'	' . get_link_image_html_from_subfields($img, $title) . "\n";
		echo $tabs.'</li>'."\n";
		$i++;

	endwhile;

	return $str;
}

/*-------------------------
　ページ下部 リンク
-------------------------*/

function write_list_of_notice_links()
{
	global $post_ids;

	$post_id = $post_ids["top-links"];
	$field_name = 'notice-links';

	$str = "";
	$tabs = get_tabs(4);

	$ri = 0;

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$title = get_sub_field('title');
		$link = get_link_object_from_subfields();

		$li_class = ($ri%4 == 0)?' class="first"':'';

		$str .= $tabs . '<li' . $li_class . '>' . get_alink_html($title, $link["url"], $link["target"]) . '</li>' . "\n";

		$ri++;

	endwhile;

	echo $str;
}


function write_list_of_external_links()
{
	global $post_ids;

	$post_id = $post_ids["top-links"];
	$field_name = 'external-links';

	$str = "";
	$tabs = get_tabs(4);

	$ri = 0;

	while ( have_rows( $field_name, $post_id ) ) : the_row();

		$title = get_sub_field('title');
		$url = get_sub_field('url');

		$li_class = ($ri%4 == 0)?' class="first"':'';
		$str2 = $title . '<i class="fa fa-external-link" aria-hidden="true"></i>';

		$str .= $tabs . '<li' . $li_class . '>' . get_alink_html($str2, $url, "_blank") . '</li>' . "\n";

		$ri++;

	endwhile;

	echo $str;
}

/*-------------------------
 エラーメッセージ
-------------------------*/

function write_error_message($message)
{
	$str = '';
	$tabs = get_tabs(3);

	$str .= $tabs . '<div class="section error">' . "\n";
	$str .= $tabs . '	' . $message . "\n";
	$str .= $tabs . '</div>' . "\n";

	echo $str;
}

function get_category_error_message($name)
{
	return 'このカテゴリに<strong>' . $name . '</strong>はありません。';
}

function get_category_error_message_by_post_type($post_type)
{
	$jp_name = get_jp_name_from_post_type($post_type);
	return get_category_error_message($jp_name);
}

