<?php get_header(); ?>

<main class="newsDetail">



<div class="breadcrumbWrap">
  <div class="inner">
  <?php get_template_part('includes/breadcrumb'); ?>
  </div>
</div>
<!-- /.breadcrumbWrap -->



<div class="newsDetail__container padding _underPage">

  <article class="newsDetail__article">
    <div class="newsDetail__title">
      <h1 class="newsDetail__headingLv1"><?php the_title(); ?></h1>
      <div class="newsDetail__titleInfo">
        <?php
          $category = get_the_category();
          echo '<a class="newsDetail__cat cat" href="'.get_category_link($category[0]->term_id).'">'.$category[0]->name.'</a>';
        ?>
        <time class="newsDetail__date" datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.m.d'); ?></time>
      </div>
      <!-- /.newsDetail__titleInfo -->
    </div>
    <!-- /.newsDetail__title -->

    <div class="newsDetail__thumb">
      <?php if(has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('post-thumbnail', array('alt' => the_title_attribute('echo=0'))); ?>
      <?php else: ?>
          <img src="<?php echo get_template_directory_uri(); ?>/img/common/noimage-gray.png" alt="">
      <?php endif; ?>
    </div>
    <!-- /.newsDetail__thumb -->

    <div class="newsDetail__content single-content">
      <?php the_content(); ?>
    </div>

  </article>

  <div class="newsDetail__pagenavi wp-pagenavi__wrap">
    <?php get_template_part('includes/wp-pagenavi'); ?>
  </div>

</div>
<!-- /.newsDetail__container -->



</main>
<!-- /.newsDetail -->


<?php get_footer(); ?>
