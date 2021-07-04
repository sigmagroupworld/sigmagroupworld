<?php
/**
 * Template Name: Elementor Right Sidebar
 * Created By: Rinkal Petersen
 * Created at: 29 June 2021
 */

get_header();

?>

<div class="sidebar">
    Right Sidebar
</div>

<div class="main_content">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content">
            <?php
            the_content();
            ?>
        </div><!-- .entry-content -->
    </article><!-- #post-<?php the_ID(); ?> -->
</div>

<div class="sidebar">
    Right Sidebar
</div>

<?php

get_footer();
