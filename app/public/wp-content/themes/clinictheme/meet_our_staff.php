<?php /* Template Name: MeetOurStaff */

get_header();
page_banner(); 

/* Custom WP_Query for fetching Employee info used in employee cards */
$allEmployees = new WP_Query(array( 
    'posts_per_page' => -1,
    'post_type' => 'employee',
    'orderby' => 'title',
    'order' => 'ASC'
));


?>

<div class="container container--narrow page-section">

    <?php /* Breadcrumb box / metabox on banner*/
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

    <div class="generic_content">

        <div class="row group"> 
            <div class="two-thirds"> <?php /* Employee cards */
                if( $allEmployees->have_posts() ){ /* Checks if Locale has Employees to display */
                    /* Handles outputting and displaying employees for selected Locale */
                    echo '<ul class="employee-cards">';
                    while ($allEmployees->have_posts()) {
                        $allEmployees->the_post(); ?>
                        <li class="employee-card__list-item">
                        <a class="employee-card" href="<?php the_permalink(); ?>">
                        <img class="employee-card__image" src="<?php the_post_thumbnail_url($size="employee-landscape"); ?>">
                        <span class="employee-card__name"><?php the_title(); ?></span>
                        </a>
                        </li>
                    <?php }
                    echo '</ul>';
                    } wp_reset_postdata(); ?>
            </div>
        
            <div class="one-third"><?php /* Employee Bio */ 
                /* Right hand sidebar box in child pages */
                /* Check if the page is a parent page */
                $isParentPage = get_pages(array(
                  'child_of' => get_the_ID()
                ));
                if ($theParentPage or $isParentPage) { ?>
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
                        )); ?> </ul>
                    </div>
                <?php } /* end of sidebar box in child pages */ ?>
            </div>
        </div> <?php /* end of row group layout */ ?>

    </div>
</div>



<?php
get_footer();
?>