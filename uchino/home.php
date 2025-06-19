<?php get_header(); ?>

<main class="">
<?php
// if ( have_posts() ) :
//     while ( have_posts() ) : the_post();
        ?>

        <?php
//     endwhile;
// else :
    ?>
    <!-- <p>投稿が見つかりませんでした。</p> -->
    <?php
// endif;
?>
<ul class="card-list _col-3">
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

  <li class="card">
    <a href="<?php the_permalink(); ?>" class="card__link">

    <figure class="card__thumb">
      <?php if (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('post_thumb', array('alt' => esc_attr(get_the_title()))); ?>
      <?php else : ?>
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/common/noimage-gray.png" alt="">
      <?php endif; ?>
    </figure>

    <div class="card__info">
      <p class="time"><time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time></p>
      <p class="cat"><?php echo get_the_category()[0]->name; ?></p>
      <?php
        $post_time = get_the_time('U');
        $days = 14; // Newバッジを表示させる日数
        $last = time() - ($days * 24 * 60 * 60);
        if ($post_time > $last) {
          echo '<p class="badge">new</p>';
        }
      ?>
    </div>
    <!-- /.card__info -->

    <h3 class="card__title"><?php the_title(); ?></h3>

    </a>
  </li>

<?php
  endwhile;
  endif;
    wp_reset_postdata();
?>
</ul>

<?php include(locate_template('includes/pagenation.php')); ?>


</main>

<?php get_footer(); ?>
