<?php get_header(); ?>

<main class="top-page">



<section class="top-mv fadeUp0">
  <div class="inner top-mv__inner">

  <div class="top-mv__heading">

    <div class="top-mv__headingInner">
      <h2 class="sectionTitle _top">update structure</h2>
      <p class="section-title _lead"><span>ビジネスの"仕組み"をアップデートし、</span><br class="sp"><span>成果・事業成長に繋がるコンサルティングを<br class="sp">提供する</span><span>マーケティング・テクノロジー<br class="sp">カンパニー</span></p>
      <div class="top-mv__img sp">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/mv.webp" alt="">
      </div>
    </div>
    <!-- /.top-mv__headingInner -->
    <div class="top-mv__btns">
      <div class="top-mv__inner">
        <p class="top-mv__btn">
          <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn _black _w190"><span>まずは相談する</span></a>
        </p>
        <p class="top-mv__btn">
          <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn _white _w260"><span>ブログ一覧へ</span></a>
        </p>
      </div>
    </div>
    <!-- /.top-mv__btns -->
  </div>
  <!-- /.top-mv__heading -->
  <div class="top-mv__img pc">
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/top/mv.webp" alt="">
  </div>
  <div class="mt">
    <p>あああああ</p>
  </div>

  </div>
  <!-- /.top-mv__inner -->
</section>
<!-- /.top-mv -->


<section class="top-about">
<div class="card_box">
<?php
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  $query = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 2,
    'paged' => $paged,
    'order' => 'DESC',
  ));

  if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
?>

<div class="card">

</div>

<?php
  endwhile;
  endif;
    wp_reset_postdata();
?>
</div>

</section>




</main>
<!-- /.top-page -->

<?php get_footer(); ?>
