<?php
/**
 * Template Name: SigmaMT Floor Plan Page Layout
 * Created By: Rinkal Petersen
 * Created at: 9 June 2021
 */
/* Floor Plan template css */
wp_enqueue_style('directory', get_stylesheet_directory_uri().'/floor-plan/css/floor-plan.css'); 
get_header();

$page_id = $wp_query->get_queried_object()->ID;
?>

<!-- Main floor plan section start -->
<div class="floor-plan-page">
  <?php ob_start(); $plan = get_field('plan');
  if ($plan){ ?>
    <?php if( !empty( $plan['floor_plan'] ) ){ ?>
      <section class="main-plan">
        <div class="container">
          <div class="page-title">
            <h2 style="color: <?php echo $plan['country_color']; ?>;">
              <?php echo $plan['plan_title']; ?>
            </h2>
          </div>
          <div class="country-plan" style="background-image: url(<?php echo $plan['background_image']; ?>);">
            <div class="single-country">
              <?php
              foreach ($plan['country_plan'] as $key => $value) { ?>
                <a href="<?php echo $value['country_event_link']; ?>" class="europe <?php echo $value['country_name']; ?>">
                  <?php if( !empty( $value['country_logo'] ) ){ ?>
                    <img src="<?php echo $value['country_logo']['url']; ?>" alt="<?php echo $value['country_logo']['alt']; ?>">
                  <?php } ?>
                  <span>
                    <span class="event-title">
                      <?php echo $value['country_title']; ?>
                    </span>
                    <span class="event-date">
                      <?php echo $value['event_date']; ?>
                    </span>
                  </span>
                </a>
              <?php } ?>
            </div>
            <div class="single-plan">
              <?php echo $plan['floor_plan']; ?>
            </div>
          </div>
        </div>
      </section>
    <?php } ?>
  <?php
  }
  ?>
  <!-- Main floor plan section end -->

  <!-- News Image slider start -->
  <?php $for_advertisement = get_field('add_banner');
  if ($for_advertisement){ ?>
    <?php if( !empty( $for_advertisement['add_banner_image'] ) ){ ?>
      <?php echo do_shortcode( '[sigma-mt-banner-adds banner_add = '.$for_advertisement["add_banner_image"].' banner_url = '.$for_advertisement["add_banner_link"].' ]' ); ?>
    <?php } ?>
  <?php
  }
  ?>
  <!-- News Image slider end -->

  <!-- Exhibitors & Partners Section Start -->
  <?php
  $field = get_field('our_sponsors_and_exhibitors', $page_id);
  echo do_shortcode($field['sponsors_shortcode']);
  ?>
  <!-- Exhibitors & Partners Section End -->

  <!-- Become Sponsor Section Start -->
  <?php ob_start(); $become_sponsor = get_field('become_sponsor');
  if ($become_sponsor){ ?>
    <?php if( !empty( $become_sponsor['link_boxes'] ) ){ ?>
      <!-- Explore All Section Strat -->
      <section class="explore-all">
        <div class="container">
          <div class="some-explore"> 
              <?php
              foreach ($become_sponsor['link_boxes'] as $key => $value) { ?>
                <div class="single-explore">
                  <?php if( !empty( $value['logo'] ) ){ ?>
                    <div class="explore-img">
                      <img src="<?php echo $value['logo']['url']; ?>" alt="<?php echo $value['logo']['alt']; ?>">
                    </div>
                  <?php } ?>
                  <div class="explore-title">
                    <h2><?php echo $value['title']; ?></h2>
                  </div>
                  <div class="explore-sub-txt">
                    <?php echo $value['sub_text']; ?>
                  </div>
                  <div class="explore-btns">
                    <?php if( !empty( $value['button_text'] ) ){ ?>
                      <span>
                        <a href="<?php echo $value['button_link']; ?>"><?php echo $value['button_text']; ?></a>
                      </span>
                    <?php } ?>
                  </div>
                </div>
              <?php } ?>
            </div>
        </div>
      </section>
      <!-- Explore All Section End -->
    <?php } ?>
  <?php
  }
  ?>
  <!-- Become Sponsor Section End -->

  <?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

</div>
<?php get_footer(); ?>
