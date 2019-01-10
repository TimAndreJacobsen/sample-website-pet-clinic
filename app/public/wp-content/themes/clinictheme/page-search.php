<?php
  get_header();
  while (have_posts()) {
      the_post(); 
      page_banner();
      ?>

<div class="container container--narrow page-section">

  <?php /* Breadcrumb box / metabox */
  $theParentPage = wp_get_post_parent_id(get_the_ID());
  if ($theParentPage) { ?>
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParentPage); ?> ">
      <i class="fa fa-home" aria-hidden="true"></i>
      <?php echo get_the_title($theParentPage); ?></a>
      <span class="metabox__main">
      <?php echo the_title(); ?> </span></p>
    </div> 
  <?php } ?>

  <?php /* Right hand sidebar box in child pages */

  $isParentPage = get_pages(array(
    'child_of' => get_the_ID()
  ));
  if ($theParentPage or $isParentPage) { /* Checks if the page is a parent page */ ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($theParentPage); ?> ">
      <?php echo get_the_title($theParentPage) ?> </a></h2>
      <ul class="min-list">
      <?php
      if ($theParentPage) {
          $findChildren = $theParentPage;
      } else {
          $findChildren = get_the_ID();
      }
      wp_list_pages(array(
        'title_li' => null,
        'child_of' => $findChildren,
        'sort_column' => 'menu_order'
      )); ?>
      </ul>
    </div>
  <?php } /* end of sidebar box in child pages */ ?>

  <div class="generic-content">
    <form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); /* Security: Whenever manually echoing from the database. Prevents hacked website from endangering users */ ?>">
        <label class="headline headline--medium" for="s">Perform a New Search:</label>
        <div class="search-form-row">
            <input placeholder="Write your search here..." class="s" id="s" type="search" name="s">
            <input clas="search-submit" type="submit" value="Search">
        </div>
    </form>
  </div>

</div>

<?php
  }
  get_footer();
?>