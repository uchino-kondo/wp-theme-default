<?php
function my_setup()
{
  add_theme_support('post-thumbnails');
  add_theme_support('automatic-feed-links');
  add_theme_support('title-tag');
  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ));
}
add_action('after_setup_theme', 'my_setup');



/*
･add_image_size( 'サムネイル名', widthサイズ, heightサイズ, true(切り取る) or false(比率を維持してリサイズ));
<?php the_post_thumbnail('post_thumb', array('alt' => esc_attr(get_the_title()))); ?>
･既存の画像は反映されない。削除が必要
*/
add_image_size('post_thumbnails', 1280, 900, true);



//投稿名変更
function Change_menulabel()
{
  global $menu;
  global $submenu;
  $name = 'News';
  $menu[5][0] = $name;
  $submenu['edit.php'][5][0] = $name . '一覧';
  $submenu['edit.php'][10][0] = '新しい' . $name;
  $menu[10][0] = '画像・ファイル';
  $submenu['upload.php'][5][0] = '画像・ファイル一覧';
  $submenu['upload.php'][10][0] = '画像・ファイルを追加';
}
function Change_objectlabel()
{
  global $wp_post_types;
  $name = 'News';
  $labels = &$wp_post_types['post']->labels;
  $labels->name = $name;
  $labels->singular_name = $name;
  $labels->add_new = _x('追加', $name);
  $labels->add_new_item = $name . 'の新規追加';
  $labels->edit_item = $name . 'の編集';
  $labels->new_item = '新規' . $name;
  $labels->view_item = $name . 'を表示';
  $labels->search_items = $name . 'を検索';
  $labels->not_found = $name . 'が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に' . $name . 'は見つかりませんでした';
}
add_action('init', 'Change_objectlabel');
add_action('admin_menu', 'Change_menulabel');



//管理画面並べ替え
function sort_side_menu($menu_order)
{
  return array(
    "index.php",
    "edit.php", // 投稿
    "edit.php?post_type=stay", // カスタム投稿宿泊
    "separator1",
    "edit.php?post_type=page", // 固定ページ
    "upload.php", // メディア
    "edit-comments.php",
    "separator2",
    "themes.php",
    "plugins.php",
    "users.php",
    "tools.php",
    "options-general.php",
    "separator-last"
  );
}
add_filter('custom_menu_order', '__return_true');
add_filter('menu_order', 'sort_side_menu');



// カスタム投稿呼び出し
require_once(dirname(__FILE__) . '/includes/custom-post.php');


// パンくずリスト
require_once(dirname(__FILE__) . '/includes/breadcrumb.php');


// ダッシュボード一部消去
function remove_dashboard_widget()
{
  // remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' ); // サイトヘルスステータス
  // remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // 概要
  remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // アクティビティ
  // remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // クイックドラフト
  remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress イベントとニュース
  // remove_action( 'welcome_panel', 'wp_welcome_panel' ); // ウェルカムパネル
}
add_action('wp_dashboard_setup', 'remove_dashboard_widget');



// ページネーションを使用するために必須
function my_parse_query($query)
{
  if (!isset($query->query_vars['paged']) && isset($query->query_vars['page']))
    $query->query_vars['paged'] = $query->query_vars['page'];
}
add_action('parse_query', 'my_parse_query');



// エディター自動保存延長
function change_autosave_interval($editor_settings)
{
  $editor_settings['autosaveInterval'] = 3600;
  return $editor_settings;
}
add_filter('block_editor_settings', 'change_autosave_interval');



// ブラウザタブの２ページ目表示を消す
function remove_title_pagenation($title)
{
  unset($title['page']);
  return $title;
};
add_filter('document_title_parts', 'remove_title_pagenation');



// セパレータ変更
function change_title_separator($sep)
{
  $sep = ' | ';
  return $sep;
}
add_filter('document_title_separator', 'change_title_separator');



// 自動成形阻止
add_action('init', function () {
  remove_filter('the_title', 'wptexturize');
  remove_filter('the_content', 'wptexturize');
  remove_filter('the_excerpt', 'wptexturize');
  remove_filter('the_title', 'wpautop');
  remove_filter('the_content', 'wpautop');
  remove_filter('the_excerpt', 'wpautop');
  remove_filter('widget_text_content', 'wpautop');
  remove_filter('the_editor_content', 'wp_richedit_pre');
});



function my_script_init()
{
  $lated_ver = '1.0.0';
  wp_deregister_script('jquery');

  wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), "3.7.1");

  // JS
  wp_enqueue_script('slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array(), '1.9.0');
  wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js', array(), '3.9.1');
  wp_enqueue_script('scrollTrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js', array(), '3.9.1');
  wp_enqueue_script('main', get_template_directory_uri() . '/js/common.js', array('jquery'), $lated_ver, true);

  // CSS
  wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', array(), $lated_ver,);
  wp_enqueue_style('slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', array(), '1.9.0');
  wp_enqueue_style('slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', array(), '1.9.0');
}
add_action('wp_enqueue_scripts', 'my_script_init');



function block_theme_setup()
{
  // ブロックエディタ用のスタイルを有効にする
  add_theme_support('wp-block-styles');

  // エディタ側にフロントと同じスタイルを適用させる
  add_theme_support('editor-styles');
  add_editor_style('style.css');

  // theme.jsonの設定を有効化（WordPress 5.8以降）
  add_theme_support('editor-color-palette');
  add_theme_support('editor-font-sizes');
  add_theme_support('editor-spacing');
}
add_action('after_setup_theme', 'block_theme_setup');



// theme.jsonの設定をCSS変数として出力する
function enqueue_theme_json_styles()
{
  // WordPressが自動的にtheme.jsonを読み込んでCSS変数を生成する
  // 追加のカスタムCSS変数が必要な場合はここに記述
}
add_action('wp_enqueue_scripts', 'enqueue_theme_json_styles');



// Contact Form 7の自動pタグ無効
function wpcf7_autop_return_false()
{
  return false;
}
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');



// 投稿ページのパーマリンクをカスタマイズ
function add_article_post_permalink($permalink)
{
  $permalink = '/news' . $permalink;
  return $permalink;
}
add_filter('pre_post_link', 'add_article_post_permalink');

function add_article_post_rewrite_rules($post_rewrite)
{
  $return_rule = array();
  foreach ($post_rewrite as $regex => $rewrite) {
    $return_rule['news/' . $regex] = $rewrite;
  }
  return $return_rule;
}
add_filter('post_rewrite_rules', 'add_article_post_rewrite_rules');



//bodyクラスにページスラッグと最上の親ページスラッグのクラスを追加
function add_page_slug_class_name($classes)
{
  if (is_page()) {
    $page = get_post(get_the_ID());
    $classes[] = $page->post_name;

    $parent_id = $page->post_parent;
    if (0 == $parent_id) {
      $classes[] = get_post($parent_id)->post_name;
    } else {
      $progenitor_id = array_pop(get_ancestors($page->ID, 'page', 'post_type'));
      $classes[] = get_post($progenitor_id)->post_name;
    }
  }
  return $classes;
}
add_filter('body_class', 'add_page_slug_class_name');

//カテゴリスラッグクラスをbodyクラスに追加
function add_category_slug_classes_to_body_classes($classes)
{
  global $post;
  if (is_single()) {
    foreach ((get_the_category($post->ID)) as $category)
      $classes[] = $category->category_nicename;
  } elseif (is_category()) {
    $catInfo = get_queried_object(); //get_category($cat)でも可能。$catは現在のカテゴリーIDは入る。
    $catSlug = $catInfo->slug; //現在表示のカテゴリースラッグ
    $catParent = $catInfo->parent; //親カテゴリーのID。なければ0。
    $thisCat =  $catInfo->cat_ID; //現在表示のカテゴリーID
    if (!$catParent) { //現在のページが一番上の親カテゴリーなら（0なら）
      $classes[] =  $catSlug; //カテゴリー名を表示
    } else {
      $ancestor = array_pop(get_ancestors($thisCat, 'category')); //配列の一番最後の値（一番上のカテゴリーID）を取得
      $classes[] =  get_category($ancestor)->slug;
    }
  }
  return $classes;
}
add_filter('body_class', 'add_category_slug_classes_to_body_classes');



// ショートコード テーマの「img」フォルダへのURL
// usage: [img]hoge.jpg
function my_images_dir()
{
  return get_template_directory_uri() . '/img/';
}
add_shortcode('img', 'my_images_dir');



//ショートコード get_template_partをショートコード化
//argsはjson形式
//usage: [template slug="includes/header" name="nav" args="{"hoge":"fuga","hogehoge":"fugafuga"}"]
function my_get_template_part($atts)
{
  extract(shortcode_atts(
    [
      'slug' => '',
      'name' => null,
      'args' => '',
    ],
    $atts,
    'template'
  ));

  ob_start();
  get_template_part($slug, $name, empty($args) ? [] : json_decode($args));
  $html = ob_get_contents();
  ob_end_clean();

  return $html;
}
add_shortcode('template', 'my_get_template_part');



// 構造化
function insert_json_ld()
{
  global $post;
  $post_data = $post;
  $category = get_the_category();
  $payload["@context"] = "http://schema.org/";

  // JSON-LD for every signle article page.
  if (is_single()) {
    $author_data = get_userdata($post_data->post_author);
    $post_url = get_permalink();
    $post_thumb = wp_get_attachment_url(get_post_thumbnail_id($post->ID));

    $payload["@type"] = "Article";
    $payload["url"] = $post_url;
    $payload["author"] = array(
      "@type" => "Person",
      "name" => $author_data->display_name,
    );
    $payload["headline"] = $post_data->post_title;
    $payload["datePublished"] = $post_data->post_date;
    $payload["image"] = $post_thumb;
    $payload["ArticleSection"] = $category[0]->cat_name;
    $payload["Publisher"] = "TeraDas";
  }

  // JSON-LD for front page.
  if (is_front_page()) {
    $payload["@type"] = "Organization";
    $payload["name"] = "株式会社";
    $payload["logo"] = "https://sankyo.web-develop.biz/sankyo/img/common/logo-w.svg";
    $payload["url"] = "https://sankyo.web-develop.biz/";
    $payload["sameAs"] = array(
      "https://twitter.com/teradas",
      "https://www.facebook.com/TeraDas.net"
    );
    $payload["contactPoint"] = array(
      array(
        "@type" => "ContactPoint",
        "telephone" => "+81 00 0000 0000",
        "email" => "sales@example.com",
        "contactType" => "sales"
      )
    );
  }

  // JSON-LD for author pages.
  if (is_author()) {
    $author_data = get_userdata($post_data->post_author);

    $x_url = get_the_author_meta('x');
    $website_url = get_the_author_meta('url');
    $facebook_url = get_the_author_meta('facebook');

    $payload["@type"] = "Person";
    $payload["name"] = $author_data->display_name;
    $payload["email"] = $author_data->user_email;
    $payload["sameAs"] =  array(
      $x_url, $website_url, $facebook_url
    );
  }

  if (!empty($payload)) {
    echo '<script type="application/ld+json">' . json_encode($payload) . '</script>';
  }
}
add_action('wp_head', 'insert_json_ld');



// 構造化ぱんくず
class WP_insert_json_ld_breadcrumb
{
  public function __construct()
  {
    // アクションフック（wp_head）を登録してheadタグに出力します。
    add_action('wp_head', array($this, 'structured_data'), 1);
  }

  public function structured_data()
  {

    $site_name        = get_bloginfo('name') . '（お店の名前）';
    $site_description = get_bloginfo('description');
    $site_icon        = get_site_icon_url(270);
    $home_url         = home_url('/');
    $schema_org       = array();

    $publisher = array(
      '@context'    => 'http://schema.org',
      '@type'       => 'Organization',
      'name'        => $site_name,
      'description' => $site_description,
      'logo'        => array(
        '@type' => 'ImageObject',
        'url'   => $site_icon,
      ),
    );

    // トップページ
    if (is_front_page() || is_home()) {
      $schema_org['home'] = array(
        '@context'  => 'http://schema.org',
        '@type'     => 'WebSite',
        'name'      => $site_name,
        'url'       => $home_url,
        'publisher' => $publisher,
      );
    }

    // ブログ詳細
    if (is_singular('post')) {
      $post_type  = get_post_type();
      $post_ID    = get_the_ID();
      $og_url     = wp_upload_dir()['baseurl'] . '/og/';
      $image_name = "{$post_type}_{$post_ID}.png";

      $schema_org['blog_posting'] = array(
        '@context'         => 'https://schema.org',
        '@type'            => 'BlogPosting',
        'mainEntityOfPage' => array(
          '@type' => 'WebPage',
          '@id'   => get_the_permalink(),
        ),
        'headline'         => get_the_title(),
        'image'            => array(
          $og_url . $image_name,
        ),
        'datePublished'    => get_the_time('c'),
        'dateModified'     => get_the_modified_time('c'),
        'author'           => array(
          '@type' => 'Person',
          'name'  => 'Simmon',
        ),
        'publisher'        => $publisher,
      );

      $schema_org['breadcrumb'] = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => array(
          array(
            '@type'    => 'ListItem',
            'position' => 1,
            'name'     => 'Home',
            'item'     => $home_url,
          ),
          array(
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => 'Blog',
            'item'     => $home_url . 'blog',
          ),
          array(
            '@type'    => 'ListItem',
            'position' => 3,
            'name'     => get_the_title(),
            'item'     => get_the_permalink(),
          ),
        ),
      );
    }

    // Aboutページ
    if (is_page('about')) {
      $schema_org['about'] = array(
        '@context'  => 'https://schema.org',
        '@type'     => 'AboutPage',
        'name'      => get_the_title(),
        'description' => get_the_excerpt(),
        'url'       => get_the_permalink(),
        'publisher' => $publisher,
      );

      $schema_org['breadcrumb'] = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => array(
          array(
            '@type'    => 'ListItem',
            'position' => 1,
            'name'     => 'Home',
            'item'     => $home_url,
          ),
          array(
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => get_the_title(),
            'item'     => get_the_permalink(),
          ),
        ),
      );
    }

    $this->output_as_json($schema_org);
  }

  private function output_as_json($schema_org)
  {
    foreach ($schema_org as $data) {
      echo '<script type="application/ld+json" class="json-ld">';
      echo wp_json_encode($data);
      echo '</script>';
    }
  }
}

new WP_insert_json_ld_breadcrumb();
