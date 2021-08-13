<?php
/**
 * The template for displaying single Game
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */
get_header();
?>
    <div class="container">
        <div class="single-game-wrapper">
            <div class="single-game">
                <iframe src="<?php echo get_field('game_url'); ?>" height="600px" width="100%"></iframe>
            </div>
        </div>
    </div>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>