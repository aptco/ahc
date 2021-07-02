<?php
/**
 * AHC
 * @package ahc-ahc
 */

global $main_slugs, $page_params, $page_ids, $undeletable, $more_link_text, $custom_tax;
global $is_recommend_label, $is_discount_label, $shop_policy_url, $temp_img;

$main_slugs = array(
);

include_once "functions-page-params.php";

$post_ids = array();
foreach($page_params as $key=>$ary) $post_ids[$key] = $ary['id'];

$temp_imgs = array();

$temp_imgs["thumb"] = get_assets_dir() . "images/common/temp_thumb.png";
$temp_imgs["event"] = get_assets_dir() . "images/common/temp_event.png";
$temp_imgs["normal"] = get_assets_dir() . "images/common/temp_normal.png";

$is_recommend_label = "おすすめ";
$is_discount_label = "割引価格";

$shop_policy_url = "http://shop.a-h-c.jp/eshopdo/refer/refer.php?&hd_kcont=ht3&vnt=n#1";

$restricted_pages = array();
foreach ($post_ids as $key=>$val) $restricted_pages[] = $val;

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

add_action('init', 'init_actions');
add_action('pre_get_posts', 'pre_get_posts_actions', 10, 1);
add_action('admin_footer', 'admin_footer_actions');
add_action('admin_enqueue_scripts', 'admin_enqueue_scripts_actions' );

add_theme_support('post-thumbnails');

function init_actions()
{
	add_taxonomies_to_custom_posts();
}

function pre_get_posts_actions($query)
{
	merge_custom_posts_to_archives( $query );
}

function admin_footer_actions()
{
	global $post, $post_ids;

	if (is_admin() && $post && $post_ids)
	{
		if ($post->ID == $post_ids["seminars"])
		{
			//acf_seminars_list_page_js();
		}
	}
}

function admin_enqueue_scripts_actions()
{
	wp_enqueue_style('admin_enqueue_scripts_actions', get_template_directory_uri().'/admin_style.css' );
}

/*-----------------------------
　 バージョンアップ通知を非表示にします。
------------------------------*/
function hide_update_nag()
{
    remove_action( 'admin_notices', 'update_nag', 3 );
}

function hide_update_footer()
{
    remove_filter( 'update_footer', 'core_update_footer' ); 
}

add_action( 'admin_menu', 'hide_update_footer' );
add_action( 'admin_init', 'hide_update_nag' );

/*-----------------------------
　オプションページをダッシュボードに追加
------------------------------*/

function add_options_to_dashboard($title, $slug)
{
	global $options_position_id;

	if( function_exists('acf_add_options_page') )
	{
		acf_add_options_page(array(
			'page_title' 	=> $title,
			'menu_slug' 	=> $slug,
			'position'		=> $options_position_id++,
			'parent_slug' 	=> 'options-general.php',
			'redirect'		=> false
		));
	}
}

add_options_to_dashboard('会社情報', 'options-company');
add_options_to_dashboard('商品設定', 'options-pubs');
add_options_to_dashboard('オンラインショップ設定', 'options-shop');
add_options_to_dashboard('購入ボタン設定', 'options-buy-btn');

/*---------------------------
　カスタム投稿にカテゴリ・タグ追加
----------------------------*/

function add_taxonomies_to_custom_posts() 
{ 
	global $category_post_types, $all_post_types;

	foreach($category_post_types as $post_type)
	{
		register_taxonomy_for_object_type('category', $post_type); 
	} 

	foreach($all_post_types as $post_type)
	{
		register_taxonomy_for_object_type('post_tag', $post_type);
	}
}


function merge_custom_posts_to_archives( $query )
{ 
	global $category_post_types, $all_post_types;

	if ( $query->is_main_query() )
	{
		if ( $query->is_category　== true )
		{ 
			$post_types = array_merge(array('post', 'nav_menu_item'), $category_post_types);

			$query->set('post_type', $post_types); 
		}

		if ( $query->is_tag() )
		{
			$post_types = array_merge(array('post'), $all_post_types);

			$query->set('post_type', $post_types);
		}
	}
} 

/*----------------------------
 ビジュアルエディタの変換機能を無効化
-----------------------------*/

function override_mce_options( $init_array )
{
    global $allowedposttags;

    $init_array['valid_elements']          = '*[*]';
    $init_array['extended_valid_elements'] = '*[*]';
    $init_array['valid_children']          = '+a[' . implode( '|', array_keys( $allowedposttags ) ) . ']';
    $init_array['indent']                  = true;
    $init_array['wpautop']                 = false;
    $init_array['force_p_newlines']        = false;

    return $init_array;
}

add_filter( 'tiny_mce_before_init', 'override_mce_options' );

/*-------------------------
 空文字の検索はホームにリダイレクト
-------------------------*/

function empty_search_redirect($wp_query)
{
	if ( $wp_query->is_main_query() && $wp_query->is_search && ! $wp_query->is_admin )
	{
		$s = $wp_query->get( 's' );
		$s = trim( $s );
		if ( empty( $s ) )
		{
			wp_safe_redirect( home_url('/') );
			exit;
		}
	}
}
add_action('parse_query', 'empty_search_redirect');

/*-------------------------
 Page Deletion Protection
-------------------------*/

function restrict_post_deletion($post_ID)
{
	global $restricted_pages;
	if(in_array($post_ID, $restricted_pages))
	{
		$doc = new DOMDocument();
		$t = $doc->createTextNode("このページは削除できません。");
		$doc->appendChild($t);
		$str = mb_convert_encoding($doc->saveHTML(), 'UTF-8', 'HTML-ENTITIES');

		echo $str;
		exit;
	}
}

add_action('wp_trash_post', 'restrict_post_deletion', 10, 1);
add_action('before_delete_post', 'restrict_post_deletion', 10, 1);

/*--------------------
　filter タイトル
---------------------*/

function filter_enter_title_here($title, $post)
{
    if( is_admin() )
    {
    	if ($post->post_type == "lecturer" ) $title = "ここに講師名を入力";
    }

	return $title;
}
add_filter( 'enter_title_here', 'filter_enter_title_here', 10, 2 );

/*--------------------
ACF filter 説明
---------------------*/

function acf_render_field_description($field)
{
	global $post;

	switch($field['_name'])
	{
		case "furigana":
			$field["instructions"] = "姓と名の間に全角スペースを入力してください。";
		break;
	}

	return $field;
}


add_filter('acf/load_field', 'acf_render_field_description', 20, 1);

/*--------------------
ACF filter 価格
---------------------*/

function acf_render_field_price($field)
{
	if ($field['_name'] == 'price'):

	global $tax_percentage;
	get_tax_percentage();
?>
	<ul class="acf-actions acf-hl acf-btn-tax"><li>
		<button type="button" class="button" id="calculate-tax">税抜き計算</button>
	</li></ul>
	<script type='text/javascript'>
		jQuery(document).ready(function()
		{
			var $ = jQuery;

			var $button = $("button#calculate-tax");
			var $input = $("ul.acf-btn-tax").parent(".acf-input").find("input");
			var tax_per = 1 + <?php echo $tax_percentage; ?> / 100;

			$button.click(function()
			{
				var price = Math.round($input.val().replace(/[\\,]/g, "") / tax_per);
				$input.val(price);
			}
			);
		}
		);
	</script>
<?php		
	endif;
}

function acf_update_value_price($value, $post_id, $field)
{
	return intval(str_replace(',', '', $value));
}

add_action('acf/render_field/type=text', 'acf_render_field_price', 20, 1);
add_filter('acf/update_value/name=price', 'acf_update_value_price', 10, 3);

/*--------------------
ACF filter 書籍
---------------------*/

function acf_loadfield_pubs_pub_date($field)
{
	$field['choices'] = get_select_values_from_field('select-pub-date-label', 'option');
	return $field;
}

function acf_loadfield_pubs_author($field)
{
	$field['choices'] = get_select_values_from_field('select-author-label', 'option');
	return $field;
}

function acf_loadfield_pubs_book_size($field)
{
	$field['choices'] = get_select_values_from_field('select-book-size', 'option');
	return $field;
}

function acf_loadfield_pubs_sales_status($field)
{
	$field['choices'] = get_select_values_from_field('select-sales-status', 'option');
	return $field;
}

add_filter('acf/load_field/name=pub-date-label', 'acf_loadfield_pubs_pub_date');
add_filter('acf/load_field/name=author-label', 'acf_loadfield_pubs_author');
add_filter('acf/load_field/name=book-size', 'acf_loadfield_pubs_book_size');
add_filter('acf/load_field/name=sales-status', 'acf_loadfield_pubs_sales_status');

/*--------------------
　ACF filter よくある質問
---------------------*/

function acf_loadfield_faq_categories($field)
{
	// reset choices
	$field['choices'] = array();

	$ary = split_newline_to_array( get_field('faq-categories') );

	if( is_array($ary) )
	{
		foreach( $ary as $choice ) $field['choices'][ $choice ] = $choice;
	}

	return $field;
}

add_filter('acf/load_field/name=select-faq-cats', 'acf_loadfield_faq_categories');

/*--------------------
　SNS
---------------------*/

function write_sns_links($share_url)
{
	$str = "";
	$tabs = get_tabs(3);

	$facebook_tag = '<div class="fb-like" data-href="' . $share_url .'" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>';
	$twitter_tag = '<a href="https://twitter.com/share" data-url="'.$share_url.'" data-text="" data-lang="ja" class="twitter-share-button">'.'ツイート'.'</a>';
	$twitter_js = "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";

	$str .= $tabs . '<ul class="sns">'."\n";
	$str .= $tabs . '	<li class="facebook">'."\n";
	$str .= $tabs . '		'.$facebook_tag."\n";
	$str .= $tabs . '	</li>'."\n";
	$str .= $tabs . '	<li class="twitter">'."\n";
	$str .= $tabs . '		'.$twitter_tag."\n";
	$str .= $tabs . '		'.$twitter_js."\n";
	$str .= $tabs . '	</li>'."\n";
	$str .= $tabs . '</ul>'."\n";

	echo $str;
}

/*--------------------
　Contact Form 7
---------------------*/

function wpcf7_text_validation_filter_extend( $result, $tag )
{
	$type = $tag['type'];
	$name = $tag['name'];
	$_POST[$name] = trim( strtr( (string) $_POST[$name], "\n", " " ) );
	if ( 'email' == $type || 'email*' == $type ) {
		if (preg_match('/(.*)_confirm$/', $name, $matches)){
			$target_name = $matches[1];
			if ($_POST[$name] != $_POST[$target_name]) {
				if (method_exists($result, 'invalidate')) {
					$result->invalidate( $tag,"確認用のメールアドレスが一致していません");
				} else {
					$result['valid'] = false;
					$result['reason'] = array( $name => '確認用のメールアドレスが一致していません' );
				}
			}
		}
	}
	return $result;
}

add_filter( 'wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2 );

/*-------------------------
 Labels
-------------------------*/

function get_is_new_label($post_type)
{
	global $is_new_labels, $jp_names;

	if ($is_new_labels == null)
	{
		$labels = get_field( 'sales-labels', 'option' );

		foreach($labels as $entry)
		{
			$type = $jp_names[$entry['type']];
			$is_new_labels[$type] = $entry["label"];
		}
	}

	return $is_new_labels[$post_type];
}

function init_buy_btn_params()
{
	global $buy_btn_labels, $jp_names;

	if ($buy_btn_labels == null)
	{
		$labels = get_field( 'buy-btn-message', 'option' );

		foreach($labels as $entry)
		{
			$post_type = $jp_names[$entry['type']];

			$ary = array(
				"label"			=>	$entry["label"],
				"top-message"	=>	$entry["top-message"]
			);

			$bottom_message = ($entry["bottom-message-bool"] == 1)?$entry["bottom-message"]:$entry["top-message"];

			$ary["bottom-message"] = $bottom_message;

			$buy_btn_labels[$post_type] = $ary;
		}
	}
}

function get_buy_btn_labels($post_type)
{
	global $buy_btn_labels;

	if ($buy_btn_labels == null) init_buy_btn_params();

	return $buy_btn_labels[$post_type]["label"];
}

function write_buy_btn_top_message($post_type)
{
	global $buy_btn_labels;
	if ($buy_btn_labels == null) init_buy_btn_params();

	$str =  $buy_btn_labels[$post_type]["top-message"];
	echo get_buy_btn_message($str);
}

function write_buy_btn_bottom_message($post_type)
{
	global $buy_btn_labels;
	if ($buy_btn_labels == null) init_buy_btn_params();

	$str = $buy_btn_labels[$post_type]["bottom-message"];
	echo get_buy_btn_message($str);
}

function get_buy_btn_message($str)
{
	$str2 = "";
	$tabs = get_tabs(3);

	$str2 .= $tabs . '<div class="btn-message">';
	$str2 .= $tabs . '	' . $str;
	$str2 .= $tabs . '</div>';

	return $str2;
}

/*-------------------------
 Search
-------------------------*/

function search_result_types( $hits )
{
    global $search_results_data;

    $types = array();

    if (!empty( $hits ))
    {
        foreach ($hits[0] as $post)
        {
        	$post_type = $post->post_type;
        	if ($post_type == "page") continue;

        	if (!array_key_exists($post_type, $types)) $types[$post_type] = 0;
            $types[$post_type] ++;
        }
    }

    $search_results_data["types"] = $types;

    return $hits;
}

add_filter('relevanssi_hits_filter', 'search_result_types');

/*-------------------------
 Pagenation
-------------------------*/

function wp_pagination($query = null)
{
	global $wp_query;
	if ($query == null) $query = $wp_query;

	$tabnum = 3;

	$tabs = get_tabs($tabnum);
	$big = 99999999;

	$page_format = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $query->max_num_pages,
		'type'  => 'array',
		'mid_size'  => 4
	) );

	$str = "";

	if( is_array($page_format) )
	{
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');

		//$str .= $tabs . '		<li><span>'. $paged . ' of ' . $query->max_num_pages .'</span></li>' . "\n";
		foreach ( $page_format as $page )
		{
			$str .= $tabs . "		<li>$page</li>" . "\n";
		}
	}

	if ($str != "") $str = get_pagenation_wrapper($str, $tabnum);

	echo $str;
}

function write_single_pagenation($prev_str, $next_str)
{
	global $side_nav_datas;

	$tabnum = 3;

	$str = "";
	$tabs = get_tabs($tabnum);

	if ($side_nav_datas != null && count($side_nav_datas) > 0)
	{
		$data = $side_nav_datas[0];

		if (array_key_exists('prev-url', $data) && $data['prev-url'] != "")
		$str .= $tabs . '		<li><a href="'. $data['prev-url'] . '">&laquo; ' . $prev_str . '</a></li>' . "\n";
		if (array_key_exists('next-url', $data) && $data['next-url'] != "")
		$str .= $tabs . '		<li><a href="'. $data['next-url'] . '">' . $next_str . ' &raquo;</a></li>' . "\n";

		$str = get_pagenation_wrapper($str, $tabnum);
	}

	echo $str;
}

function get_pagenation_wrapper($html, $tabnum)
{
	$str = "";
	$tabs = get_tabs($tabnum);

	$str .= $tabs . '<!--　ぺージネーション　-->' . "\n";
	$str .= $tabs . '<div class="pagenation">' . "\n";
	$str .= $tabs . '	<ul>' . "\n";

	$str .= $html;

	$str .= $tabs . '	</ul>' . "\n";
	$str .= $tabs . '</div>' . "\n";
	$str .= $tabs . '<!--　//ぺージネーション　-->' . "\n";

	return $str;
}

/*-------------------------
Shop
-------------------------*/

function get_shop_buttons($post_type, $btn_class, $html, $tabnum = 4, $post_id = null)
{
	$item_id = 0;
	$item_url = get_field('shop-url', $post_id);

	if (preg_match("/^[0-9]+$/", $item_url))
	{
		$item_id = $item_url;

		global $shop_url_pc, $shop_url_sp;

		if (!$shop_url_pc) $shop_url_pc = get_field( 'shop-item-url-pc', 'option' );
		if (!$shop_url_sp) $shop_url_sp = get_field( 'shop-item-url-sp', 'option' );

		$pc_url = preg_replace("/%id%/", $item_id, $shop_url_pc);
		$sp_url = preg_replace("/%id%/", $item_id, $shop_url_sp);
	}
	else
	{
		$pc_url = $sp_url = $item_url;
	}

	return get_shop_buttons_html($post_type, $item_id, $btn_class, $pc_url, $sp_url, $html, $tabnum);
}

function get_shop_buttons_html($post_type, $item_id, $btn_class, $pc_url, $sp_url, $html, $tabnum = 4)
{
	$str = "";
	$tabs = get_tabs($tabnum);

	$ga_ary = array('send', 'event', 'click-shop', $post_type, $item_id);

	$js_str = 'onclick="ga(\'' . implode('\', \'', $ga_ary) .'\');"';

	$str .= '<a class="btn ' . $btn_class . ' pc" href="' . $pc_url . '" target="_blank" ' . $js_str . '>' . $html . '</a>' . "\n";
	$str .= '<a class="btn ' . $btn_class . ' sp" href="' . $sp_url . '" target="_blank" ' . $js_str . '>' . $html . '</a>' . "\n";

	return $str;
}

/*-------------------------
 ACF Prices
-------------------------*/

function get_tax_percentage()
{
	global $tax_percentage;
	if (!$tax_percentage) $tax_percentage = intval(get_field( 'tax-percentage', 'option' ));
}

function get_price_from_field($fieldname, $has_tax = true, $post_id = null)
{
	global $tax_percentage;

	$price_str = get_field( $fieldname, $post_id );
	if ($price_str == "") return $price_str;

	$price = intval($price_str);
	if ($price == 0) return $price;

	get_tax_percentage();
	if ($has_tax) $price *= (1 + $tax_percentage / 100);

	return $price;
}

function get_price($has_tax = true, $post_id = null)
{
	return get_price_from_field('price', $has_tax, $post_id);
}

function get_price_discount($has_tax = true, $post_id = null)
{
	return get_price_from_field('price-discount', $has_tax, $post_id);
}

function get_price_tag($has_tax = true, $post_id = null)
{
	$price = get_price($has_tax, $post_id);
	$price_discount = get_price_discount($has_tax, $post_id);

	$tax_label = ($has_tax)?"税込":"税抜き";

	if ($price == 0) return "";

	$price = number_format($price) . "円";
	$tax_label = "（" . $tax_label . "）";

	if ($price_discount != "")
	{
		$price_discount = number_format($price_discount) . "円";
		$str = '<s>' . $price . '</s> ' . '<span class="discount">' . $price_discount . $tax_label . '</span>';
	}
	else
	{
		$str = $price . $tax_label;
	}

	return $str;
}

function get_price_text($label = '', $post_id = null)
{
	$price_alt = get_field( 'price-alt', $post_id );
	if ($label) $label .= '：';
	
	if (!$price_alt) $str = $label . get_price_tag(get_field( 'price-tax' ), $post_id) . "\n";
	else $str = $price_alt;

	return $str;
}

function get_pub_label_html($tagname, $post_id = null)
{
	$post = get_post($post_id);

	$is_new = get_field( 'is-new', $post_id );
	$is_recommend = get_field( 'is-recommend', $post_id );
	$is_discount = (get_price_discount(true, $post_id) != "");

	global $is_recommend_label, $is_discount_label;
	$is_new_label = get_is_new_label($post->post_type);

	$str = "";

	if ($is_new)		$str .= '<' . $tagname .' class="is-new">' . $is_new_label . '</' . $tagname .'>';
	if ($is_recommend)	$str .= '<' . $tagname .' class="is-recommend">' . $is_recommend_label . '</' . $tagname .'>';
	if ($is_discount)	$str .= '<' . $tagname .' class="is-discount">' . $is_discount_label . '</' . $tagname .'>';

	return $str;
}

/*-------------------------
 ACF IMG
-------------------------*/

function get_acf_img_main($alt = "", $post_id = null)
{
	if (!$post_id) $post_id = get_the_ID();

	$url = get_field( 'img-main' , $post_id);
	if ($url) return get_img_tag($url, $alt);

	$thumb = get_the_post_thumbnail($post_id);
	if ($thumb) return $thumb;

	return get_img_tag(get_temp_img(), $alt);
}

function get_img_tag($url, $alt = "")
{
	$html = '<img ';
	$html .= 'src="' . $url . '"';
	if ($alt != "") $html .= ' alt="' . $alt . '"';
	$html .= '>';
	return $html;
}

function get_temp_img($size = "normal")
{
	global $temp_imgs;
	if (!array_key_exists($size, $temp_imgs)) return "";
	return $temp_imgs[$size];
}

/*-------------------------
 ACF Dates
-------------------------*/

function date_is_valid($date_str)
{
	return preg_match("/^[0-9]{8,}/", $date_str);
}

function format_date($date_str)
{
	$date = date_create($date_str);

	return date_format($date, 'Y/m/d' );
}

function format_date_short($date_str)
{
	$date = date_create($date_str);

	$date_str2 = date_format($date, 'n/j' );
	$w = (int)$date->format('w');
	$date_str2 .= get_jp_week($w);

	return $date_str2;
}

function format_date_to_jp($date_str)
{
	$date = date_create($date_str);

	$date_str2 = date_format($date, 'Y/n/j');
	$w = (int)$date->format('w');
	$date_str2 .= get_jp_week($w);

	return $date_str2;
}

function get_jp_week($w)
{
	return ' ('. get_week_name($w) .')';
}

function format_custom_date($date_str, $mode = 1)
{
	if (!date_is_valid($date_str)) return $date_str;

	$ary = preg_split('/\//', $date_str, 0, PREG_SPLIT_NO_EMPTY);

	foreach($ary as $i=>$str)
	{
		$ary2 = preg_split('/,/', $str, 0, PREG_SPLIT_NO_EMPTY);

		foreach($ary2 as $j=>$str2)
		{
			if ($mode == 1) $str2 = format_date_to_jp($str2);
			else $str2 = format_date($str2);
			$ary2[$j] = $str2;
		}

		$ary[$i] = implode("、", $ary2);
	}

	return implode("～", $ary);
}

function get_week_name($index)
{
	$weekdays = array("日", "月", "火", "水", "木", "金", "土");
	return $weekdays[$index];
}

function get_acf_date_string($date, $display_date)
{
	if ($display_date != "")
	{
		return format_display_date($display_date);
	}
	else
	{
		return format_date_to_jp($date);
	}
}

function format_display_date($string)
{
	$d_date = mb_convert_kana($string, "n");

	$d_regex = "(([0-9]+年)?([0-9]+月)?([0-9]+日))";
	$regex = "/" . $d_regex ."([～－\-])" . $d_regex ."/u";
	preg_match($regex, $d_date, $m);

	if ($m && count($m) > 6)
	{
		return $m[1] . "～" . $m[8] . $m[9];
	}
	else
	{
		return $d_date;
	}
}

/*-------------------------
 ACF Links
-------------------------*/

function get_alink_tag($url, $target = "")
{
	$str = "";
	if ($url != "")
	{
		$str .= '<a href="' . $url . '"';
		if ($target != "") $str .= ' target="' . $target . '"';
		$str .= '>';
	}

	return $str;
}

function get_alink_html($html, $url, $target = "")
{
	$str = "";
	if ($url != "") $str .= get_alink_tag($url, $target);
	$str .= $html;
	if ($url != "") $str .= '</a>';

	return $str;
}

function get_link_image_html_from_subfields($img, $title)
{
	$html = '<img src="' . $img . '" alt="' . $title . '">';
	$link = get_link_object_from_subfields();

	if ($link["url"] != "")
	{
		$html = get_alink_html($html, $link["url"], $link["target"] );
	}

	return $html;
}

function get_link_object_from_subfields()
{
	$i_url = get_sub_field('internal-url');
	$e_url = get_sub_field('external-url');

	$regex = "/^https?:\/\//";

	$has_e_url = (trim(preg_replace($regex, "", $e_url)) != "");
	$isExternal = preg_match($regex, $e_url);

	if ($has_e_url && !$isExternal) $e_url = home_url($e_url);
	$url = ($has_e_url)?$e_url:$i_url;

	$target = (get_sub_field('target-blank'))?"_blank":"_self";

	$link = array(
		"url" => $url,
		"target" => $target,
		"isExternal" => $isExternal
	);

	return $link;
}

/*-------------------------
 ACF Repeaters
-------------------------*/

function get_li_from_repeater($field_name, $label_name, $value_name, $tabnum = 4)
{
	$entries = get_field($field_name);

	return get_li_from_repeater_entries($entries, $label_name, $value_name, $tabnum);
}

function get_li_from_repeater_entries($entries, $label_name, $value_name, $tabnum = 4)
{
	$str = "";
	$tabs = get_tabs($tabnum);

	foreach($entries as $entry)
	{
		$str .= $tabs . '<li>' . $entry[$label_name] . '：' . $entry[$value_name] . '</li>' . "\n";
	}
	return $str;
}

/*-------------------------
 ACF Admin Select
-------------------------*/

function get_select_values_from_field($field_name, $post_id)
{
	$selects = array();

	$ary = split_newline_to_array( get_field($field_name, $post_id) );

	foreach( $ary as $select ) $selects[ $select ] = $select;

	return $selects;
}

/*-------------------------
 Contents Text
-------------------------*/

function convert_em_in_content($str)
{
	$str = preg_replace("/<\/em>([\r\n]*<br *\/?>[\r\n]*)<em>/", "<br/>", $str);
	$str = preg_replace("/<\/em>([\r\n]*<\/?p>[\r\n]*)*<em>/", "<br/>", $str);
	return $str;
}

/*-------------------------
 Subtitle
-------------------------*/

function get_subtitle($post_id = null)
{
	$str = get_field( 'subtitle', $post_id ) . "";
	if ($str != "") return '<p class="subtitle">' . $str . '</p>';
	return "";
}

/*-------------------------
 Categories
-------------------------*/

function post_type_is_or_includes($post_type, $target)
{
	if (is_array($target))
	{
		return in_array($post_type, $target);
	}
	else if(is_string($target))
	{
		return $post_type == $target;
	}
	return false;
}

function get_root_name_from_post_type($post_type)
{
	global $type_params;

	if (!array_key_exists($post_type, $type_params)) return "";

	return $type_params[$post_type]['root_name'];
}

function get_taxonomy_name_from_post_type($post_type)
{
	global $type_params;

	if (!array_key_exists($post_type, $type_params)) return "";

	return $type_params[$post_type]['taxonomy_name'];
}

function get_jp_name_from_post_type($post_type)
{
	global $type_params;

	if (!array_key_exists($post_type, $type_params)) return "";

	return $type_params[$post_type]['jp_name'];
}

function get_class_name_from_post_type($post_type)
{
	global $type_params;

	if (!array_key_exists($post_type, $type_params)) return "";

	return $type_params[$post_type]['class_name'];
}

function get_recommendation_category($post_id)
{
	$post = get_post($post_id);

	switch($post->post_type)
	{
		case "magazine":
		case "book":
		case "goods":
		case "seminar":
		case "lecturer":
		case "course":
			return get_jp_name_from_post_type($post->post_type);
		case "page":
		case "article":
			$cat = get_first_category($post_id, "category");
			return $cat->name;
		break;
	}
}

function get_permalink_from_key($key)
{
	global $page_params;

	if (!array_key_exists($key, $page_params)) return "";

	return $page_params[$key]['url'];
}

function get_post_type_from_slug($slug)
{
	global $slug_params;

	if (!array_key_exists($slug, $slug_params)) return "";

	return $slug_params[$slug]['post_type'];
}

function get_top_banner_from_slug($slug)
{
	global $slug_params;

	if (!array_key_exists($slug, $slug_params)) return "";

	return $slug_params[$slug]['banner'];
}

function get_category_slug_from_slug($slug)
{
	global $slug_params;

	if (!array_key_exists($slug, $slug_params)) return "";

	return $slug_params[$slug]['category-slug'];
}

function get_categories_from_parent_slug($slug)
{
	$term = get_category_by_slug($slug);

	$args = array(	"hide_empty" => false,
					"parent" => $term->term_id );

	return get_categories( $args );
}

function get_all_slugs_from_post_type($slug, $post_type)
{
	$slugs = array();

	//$slug = urlencode($slug);

	$taxonomy_name = get_taxonomy_name_from_post_type($post_type);
	$term = get_term_by("slug", $slug, $taxonomy_name);

	$slugs[] = strtolower($slug);

	
	if ($term != null)
	{
		$cats = get_custom_categories($taxonomy_name, $term->term_id);

		foreach($cats as $cat)
		{
			$slugs[] = strtolower($cat->slug);
		}
	}

	return $slugs;
}

function get_book_slugs()
{
	global $book_slugs;

	if ($book_slugs == null)
	{
		$book_slugs = get_all_slugs_from_post_type("books", "book");
	}

	return $book_slugs;
}

function get_magazine_slugs()
{
	global $magazine_slugs;

	if ($magazine_slugs == null)
	{
		$magazine_slugs = get_all_slugs_from_post_type("magazines", "magazine");
	}

	return $magazine_slugs;
}

function get_slug_from_category($post_id, $taxonomy_name="category")
{
	$terms = get_the_terms($post_id, $taxonomy_name);
	if (is_array($terms) && count($terms) > 0)
	{
		$terms = sort_terms_hierarchicaly($terms);
		return $terms[0]->slug;
	}
	else return "";
}

function get_custom_categories($taxonomy_name, $parent_id = 0)
{
	$args = array(
		'order'			=> 'ASC',
		'orderby' 		=> 'name',
		//'post_type'		=> $post_type,
		'hierarchical'  => true,
		'hide_empty'    => false
	);

	$args['parent'] = $parent_id;

	return get_terms($taxonomy_name, $args);
}

function get_first_category($post_id, $taxonomy_name)
{
	//Get First Parent Category
	$cats = get_the_terms($post_id, $taxonomy_name);
	if (!$cats || !is_array($cats) || count($cats) == 0) return null;

	$cats = sort_terms_hierarchicaly($cats);
	return $cats[count($cats) - 1];
}

function sort_terms_hierarchicaly(Array &$cats)
{
	if ($cats == null || count($cats) == 0) return　null;

	$links = array();
	$cats2 = array();
	$link_id = 0;

	foreach($cats as $cat)
	{
		$cat->family = 0;
		$cat->link_id = -1;
		$cat->link_length = 0;

		$cats2[$cat->term_id] = $cat;
	}

	foreach($cats2 as $cat)
	{
		$cat2 = $cat;
		while ($cat2->parent != 0)
		{
			$cat->family ++;
			if (!array_key_exists($cat2->parent, $cats2)) break;
			$cat2 = $cats2[$cat2->parent];
			if ($cat2->link_id > -1)
			{
				if ($cat->link_id == -1)
				{
					$cat->link_id = $cat2->link_id;
					$links[$cat->link_id][] = $cat;
				}
			}
			else 
			{
				$cat2->link_id =  $link_id;
				$links[$link_id][] = $cat2;
			}
		}
		if ($cat->link_id == -1)
		{
			$cat->link_id = $link_id;
			$links[$link_id][] = $cat;
			$link_id++;
		}
	}

	foreach($links as $i=>$ary)
	{
		foreach($ary as $cat) $cat->link_length = count($ary);
	}

	usort($cats2, function($a, $b)
	{
		if ($a->link_length == $b->link_length)
		{
			if ($a->family == $b->family)
			{
				if ($a->term_order == $b->term_order)return 0;
				return ($a->term_order < $b->term_order)?-1:1;
			}
			return ($a->family < $b->family)?-1:1;
		}
		else
		{
			return ($a->link_length > $b->link_length)?-1:1;
		}
	}
	);

	$cats = $cats2;

	return $cats2;
}

function get_category_tree_of_post($post)
{
	$ary = array();

	$ary[] = get_root_name_from_post_type($post->post_type);

	$taxonomy_name = get_taxonomy_name_from_post_type($post->post_type);

	if ($taxonomy_name != "")
	{
		$cats = get_the_terms($post->ID, $taxonomy_name);

		if (count($cats) > 0)
		{
			sort_terms_hierarchicaly($cats);
		}

		foreach($cats as $i=>$cat)
		{
			$ary[$i + 1] = $cat->name;
		}
	}
		
	return $ary;
}

function get_args_for_post_type_query($post_type)
{
	$args = array(
		'post_type'			=> $post_type,
		'posts_per_page'	=> -1,
		'post_status' 		=> 'publish'
	);

	$args = set_args_by_post_type($args, $post_type);

	return $args;
}

function get_args_for_category_query($post_type, $taxonomy_name, $term_id)
{
	$args = array(
		'post_type'			=> $post_type,
		'posts_per_page'	=> -1,
		'post_status' 		=> 'publish',
		'tax_query' => array(
			array(
				'taxonomy'	=> $taxonomy_name,
				'field'		=> 'term_id',
				'terms' 	=> $term_id
			)
		)
	);

	$args = set_args_by_post_type($args, $post_type);

	return $args;
}

function set_args_by_post_type($args, $post_type)
{
	if (is_array($post_type)) return array();

	$meta_query = array();
	$orderby = array();

	$pub_post_types = array("book", "magazine", "goods");

	//セミナー
	if ( $post_type == "seminar" )
	{
		$meta_query['by_date'] = array(
			'key' => 'date'
		);

		$orderby['by_date'] = 'ASC';
	}
	//出版物
	if ( in_array( $post_type, $pub_post_types ) )
	{
		$meta_query['by_new'] = array(
			'key' => 'is-new',
			'type' => 'BINARY'
		);
		$meta_query['by_recommend'] = array(
			'key' => 'is-recommend',
			'type' => 'BINARY'
		);

		$orderby['by_new'] = 'DESC';
		$orderby['by_recommend'] = 'DESC';

		//雑誌
		if ( $post_type == "magazine" )
		{
			$meta_query['by_volume'] = array(
				'key' => 'volume',
				'type' => 'NUMERIC'
			);

			$orderby['by_volume'] = 'DESC';
		}
	}

	$orderby['name'] = 'ASC';

	$args['meta_query'] = $meta_query;
	$args['orderby'] = $orderby;

	return $args;
}

/*---------------------------------------
 Loop for Custom Category archives
---------------------------------------*/

function custom_pre_get_posts( $query )
{
	if ( !is_admin() && $query->is_main_query() )
	{
		$q = $query->query;

		$key_seminar = "category-seminar";
		//$key_pub = get_taxonomy_name_from_post_type("magazine");
		$key_pub = "category-item";

		$post_type = "";

		//セミナー
		if ( array_key_exists( $key_seminar, $q ) )
		{
			$post_type = "seminar";
		}
		//出版物
		else if ( array_key_exists( $key_pub, $q ) )
		{
			$name = strtolower($q[$key_pub]);

			//雑誌
			if ( in_array( $name, get_magazine_slugs() ) )
			{
				$post_type = "magazine";
			}
			else if ( in_array( $name, get_book_slugs() ) )
			{
				$post_type = "book";
			}
			else
			{
				$post_type = "goods";
			}
		}

		$args = set_args_by_post_type(array(), $post_type);

		if ($post_type != "")
		{
			$query->set('meta_query', $args['meta_query']);
			$query->set('orderby', $args['orderby']);
		}
	}
}

add_action( 'pre_get_posts', 'custom_pre_get_posts' );

/*---------------------------------------
 Breadcrumb
---------------------------------------*/

function get_breadcrumb_string_of_post($post)
{
	$ary = get_category_tree_of_post($post);

	$str = "";

	foreach($ary as $i=>$name)
	{
		if ($i > 0) $str .= " ＞ ";
		$str .= $name;
	}

	return $str;
}

/*---------------------------
　 Breadcrumb NavXT Hooks
----------------------------*/

function action_bcn_after_fill( $instance )
{ 	
	global $post, $page_params;

	$taxonomy_name = get_query_var("taxonomy");
	if ($taxonomy_name == "")
	{
		if ($post) $taxonomy_name = get_taxonomy_name_from_post_type($post->post_type);
	}

	$trails = $instance->trail;
	$count = count($trails);

	//商品カテゴリの最上位階層「出版物」「予防教育グッズ」のURLを変える
	if ($taxonomy_name == "category-item")
	{
		foreach($trails as $i=>$trail)
		{
			if ($i >= $count - 2)
			{
				switch($trail->get_title())
				{
					case "出版物":
						$trail->set_url($page_params['publications']['url']);
					break;
					case "予防教育グッズ":
						$trail->set_url($page_params['goods']['url']);
					break;
				}
			}
		}
	}
	else if ($post)
	{
		$article_names = array("seminars", "publications", "goods", "courses", "lectures", "lecturers");

		if ($post->post_type == "article")
		{
			foreach($article_names as $name)
			{
				$param = $page_params[$name];

				if (has_category($param["name"]))
				{
					$home = array_shift($trails);

					$add = clone $home;
					$add->set_title($param["name"]);
					$add->set_url($param['url']);

					$instance->trail = array_merge(array($home, $add), $trails);
				}
			}
		}
	}

	return $instance;
}; 

add_action( 'bcn_after_fill', 'action_bcn_after_fill', 10, 1 ); 

/*-------------------------
 Common
-------------------------*/

function get_common()
{
	global $post;
	if ($post == null) return;
}

function assets_dir()
{
	echo get_assets_dir();
}

function get_assets_dir()
{
	return esc_url (home_url('/'))."assets/";
}

function get_tabs($num)
{
	$tabs = "";
	while($num--) $tabs .= "\t";
	return $tabs;
}

function format_url($url)
{
	if (!preg_match("/^(\.\/)/", $url)) $url = "./" . $url;
	if (!preg_match("/\/$/", $url) && !preg_match("/\.html?$/", $url)) $url .= "/";
	return $url;
}

function split_newline_to_array( $str )
{
	$ary = preg_split("/\r?\n/", $str);
	$ary = array_map('trim', $ary);
	return $ary;
}

function split_tag_to_array( $str, $tag )
{
	$str2 = $str;
	$str2 = preg_replace("/^(< *" . $tag ." *>)/", "", $str2);
	$str2 = preg_replace("/(< *\/ *" . $tag ." *>)$/", "", $str2);

	$ary = preg_split("/(< *\/ *" . $tag ." *>)[\r\n\t]*(< *" . $tag ." *>)/", $str2);
	$ary = array_map('trim', $ary);
	return $ary;
}

function var_pre($var)
{
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

include_once "functions-template.php";