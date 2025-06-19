<?php
// カスタム投稿タイプの追加
function create_post_type_and_taxonomy() {

  // News投稿タイプの追加
  register_post_type('news', // 投稿タイプ名の定義
    array(
      'labels' => array(
        'name' => __('News一覧'),
        'singular_name' => __('News')
      ),
      'public' => true,
      'has_archive' => true,
      'menu_icon' => 'dashicons-media-text', // アイコン
      'rewrite' => array('slug' => 'news'), // URLのスラグ
      'supports' => array('title', 'editor', 'thumbnail'), // サポート機能
      // 'menu_position' => 7, // メニュー位置の変更は下の管理画面設定にて行う
      'show_in_rest' => true, // グーテンベルク画面にする為必要
    )
  );

  // カスタムタクソノミー('news-cat')の追加
  register_taxonomy(
    'news-cat', // タクソノミー名の定義
    'news', // このタクソノミーが関連付けられる投稿タイプ
    array(
      'label' => __('Newsカテゴリ'),
      'rewrite' => array('slug' => 'news-cat'),
      'hierarchical' => true, // 階層を持たせる場合は true
      'show_ui' => true, // 管理画面で表示
      'show_in_rest' => true, // REST APIを通じて利用可能にし、ブロックエディタで表示を有効にする
    )
  );

  // Works投稿タイプの追加
  register_post_type('works', // 投稿タイプ名の定義
    array(
      'labels' => array(
        'name' => __('Works一覧'),
        'singular_name' => __('Works')
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'works'),
      'supports' => array('title', 'editor', 'thumbnail'),
      'show_in_rest' => true,
    )
  );

  // カスタムタクソノミー('works-cat')の追加
  register_taxonomy(
    'works-cat',
    'works',
    array(
      'label' => __('Worksカテゴリ'),
      'rewrite' => array('slug' => 'works-cat'),
      'hierarchical' => true,
      'show_ui' => true,
      'show_in_rest' => true,
    )
  );
}
add_action('init', 'create_post_type_and_taxonomy');



// news-itemとworks-itemのデフォルトカテゴリーを設定
function set_default_category_for_news_and_works($post_id, $post, $update) {
  // 自動保存やリビジョンの際は何もしない
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  // 投稿タイプが 'news' の場合
  if ($post->post_type == 'news') {
    // 'news-cat' タクソノミーのデフォルトカテゴリーを設定
    $default_category_id = get_term_by('slug', 'news-item', 'news-cat'); // 'default-news-category'はカテゴリーのスラグ
    if ($default_category_id) {
      wp_set_object_terms($post_id, array($default_category_id->term_id), 'news-cat', false);
    }
  }

  // 投稿タイプが 'works' の場合
  if ($post->post_type == 'works') {
    // 'works-cat' タクソノミーのデフォルトカテゴリーを設定
    $default_category_id = get_term_by('slug', 'works-item', 'works-cat'); // 'default-works-category'はカテゴリーのスラグ
    if ($default_category_id) {
      wp_set_object_terms($post_id, array($default_category_id->term_id), 'works-cat', false);
    }
  }
}
add_action('save_post', 'set_default_category_for_news_and_works', 10, 3);

?>
