<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head prefix="og: https://ogp.me/ns#">
<?php get_template_part('includes/head'); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>



<div class="container">



<header class="header">
<div class="header__inner">

<?php $html_tag = (is_home() || is_front_page()) ? 'h1' : 'p'; ?>
<<?php echo $html_tag; ?> class="header__logo">
  <a href="<?php echo esc_url(home_url('/')); ?>">
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo.svg" alt="">
  </a>
</<?php echo $html_tag; ?>>
<!-- /.header__logo -->



<button class="header__btn hamburger" aria-label="メニューを開く">
  <span class="bar"></span>
  <span class="bar"></span>
  <span class="bar"></span>
</button>
<!-- /.header__btn hamburger -->



<nav class="gnav">

  <p class="gnav__logo">
    <a href="<?php echo esc_url(home_url('/')); ?>">
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/logo.jpg" alt="">
    </a>
  </p>

  <nav class="gnav__nav">
    <div class="gnav__nav-item">
      <p><a href="<?php echo esc_url(home_url('/')); ?>">test</a></p>
      <p><a href="<?php echo esc_url(home_url('/about')); ?>">About</a></p>
      <p><a href="<?php echo esc_url(home_url('/')); ?>">test</a></p>
    </div>
    <!-- gnav__nav-item -->
  </nav>

  <div class="gnav__btns">
    <div class="gnav__btn">
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn _white">
        <span>ご相談・お問い合わせ</span>
      </a>
    </div>
    <!-- /.gnav__btn -->
    <div class="gnav__btn">
      <a href="<?php echo esc_url(home_url('/resources')); ?>" class="btn _white">
        <span>ブログ一覧ページ</span>
      </a>
    </div>
    <!-- /.gnav__btn -->
  </div>
  <!-- /.gnav__btns -->

</nav>
<!-- /.gnav sp-menu -->



<nav class="header__nav">

  <ul class="header__nav-item">
    <li><a href="<?php echo esc_url(home_url('/')); ?>case">test</a></li>
    <li><a href="<?php echo esc_url(home_url('/')); ?>knowledge">test</a></li>
    <li><a href="<?php echo esc_url(home_url('/')); ?>news">test</a></li>
    <li><a href="<?php echo esc_url(home_url('/')); ?>about">About</a></li>
    <li><a href="<?php echo esc_url(home_url('/')); ?>careers">test</a></li>
  </ul>
  <!-- header__nav-item -->

</nav>
<!-- /.header__nav ---------->



</div>
<!-- /.header__inner -->

</header>
<!-- /.header -->
