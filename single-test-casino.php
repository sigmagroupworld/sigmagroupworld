<?php
/**
 * The template for displaying single post of casino 
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();

// GET ALL DETAILS
$post_id = get_the_ID();

$casino_title = get_the_title( $post_id ); 
$casino_common_rules = get_field('casino_inner_pages_options','options');
// FIELD FROM COMMON RULES
$star_img = $casino_common_rules['star_image'];
$visit_casino = $casino_common_rules['button_text__visit_casino_'];
$title_extension = $casino_common_rules['casino_main_title'];
$casino_tabs_btn = $casino_common_rules['tabs_button_text'];
$overview_btn = $casino_tabs_btn['overview_button_text'];
$details_btn = $casino_tabs_btn['details_button_text'];
$bonus_btn = $casino_tabs_btn['bonus_button_text'];
$player_review_btn = $casino_tabs_btn['player_review_text'];
$show_all_text = $casino_common_rules['show_all_text'];
// SIDEBAR FIELDS FOR CASINO INNER PAGES

$casino_sidebar = $casino_common_rules['sidebar_fields'];
$games_title = $casino_sidebar['games_title_text'];
$payment_title = $casino_sidebar['paymenet_method_title_text'];
$withdraw_title = $casino_sidebar['withdraw_limit_title_text'];
$games_provider_title = $casino_sidebar['games_provider_title_text'];
$signup_btn_text = $casino_common_rules['bonus_signup_button_text'];

// OVERVIEW TAB FIELDS

$overview_fields = $casino_common_rules['overview_tabs'];
$of_bonust = $overview_fields['bonus_title'];
$of_reveiwt = $overview_fields['review_title'];
$of_viewsect = $overview_fields['view_section_title'];



// DETAILS FIELD
$details_tab_fields = $casino_common_rules['details_tab'];
$procons = $details_tab_fields['pros_cons_title'];
$pro_title = $procons['pros_title'];
$con_title = $procons['cons_title'];
$dt_lict = $details_tab_fields['licenses_title'];
$dt_payprot = $details_tab_fields['payment_providers_title'];
$dt_langt = $details_tab_fields['languages_title'];
$dt_gamept = $details_tab_fields['game_providers_title'];

// VISIT CASINO LINK FOR EACH CASINO PAGE

$visit_casino_inner = get_field('visit_casino');
$visit_link = $visit_casino_inner['button_link'];

// BONUS TAB FIELD
$bonus_tab = $casino_common_rules['bonus_tab'];
$bt_bonust = $bonus_tab['bonus_title'];



// PLAYER REVIEW TAB FIELDS

$player_review_tab = $casino_common_rules['player_review_tab'];
$pt_plarewt = $player_review_tab['player_reviews_title'];
$pt_write_t = $player_review_tab['write_a_review_button_text'];
$pt_readicon = $player_review_tab['read_more_icon_image'];

// CASINO SIDEBAR FIELD


$casino_sidebar_solo = get_field('casino_sidebar');
$games = $casino_sidebar_solo['games'];
$payment_provider = $casino_sidebar_solo['payment_options'];
$withdraw_limitz = $casino_sidebar_solo['withdraw_limits'];
$games_provider = $casino_sidebar_solo['games_provider'];
$casino_company = $casino_sidebar_solo['casino_company_details'];

// FIELD FROM SINGLE CASINO
$featured_ig=  wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'full' );
$color = get_field('casino_theme_color', $post_id);
$top_sec = get_field('top_section', $post_id);
$detail = get_field('visit_casino', $post_id);


// OVERVIEW TAB

$overview = get_field('casino_overview_tab',$post_id);
$news_slider = $overview['learnmore_news_slider'];
$faqz = $overview['faqs_sec'];
// DETAILS TAB

$details_tab = get_field('casino_details_tab',$post_id);
 $payment_provider_detail_tab = $details_tab['payment_provider'];


(empty($details_tab)) ? $pross= "" : $pross= $details_tab['pros'];
(empty($details_tab['licenses_county'])) ? $licence_country= "" : $licence_country = $details_tab['licenses_county'];
(empty($details_tab['languages'])) ? $languagess= "" : $languagess = $details_tab['languages'];

// BONUS TAB
$bonus_tabz = get_field('casino_bonus_tab',$post_id);

$casino_bonus_theme = get_field('casino_theme_color_for_bonus_box');
?>


<style type="text/css">
    :root {
  --page: #284095;
  --pageO: #2840955e;
  --border: #696969;
  --ribbon: #93c841;
  --shadow: 10px 4px 15px rgba(0, 0, 0, 0.6);
  --border-l: linear-gradient(to right,var(--page) 40%,var(--pageO));
  --orangeDark:  #EA3E3A;
  --orangeLight : #FFF239;
  --orangeB : linear-gradient(to left,var(--orangeDark),var(--orangeLight));
  --liteBlue : #00AEEF;
  --cbTheme : <?php echo $casino_bonus_theme; ?>
}

</style>
<div class="casino-container ff">
        <div class="casino-content-wrapper">
            <div class="top-section">
                <div class="top-bg" style="background-image: url(<?php echo $featured_ig;?>);">

                </div>
                <div class="casino-info-wrapper">
                    <div class="casino-img">
                        <img src="<?php echo $top_sec['casino_banner']?>" alt="">
                    </div>
                    <div class="casino-info">
                        <div class="casino-stars">
                            <div class="casino-name">
                                <h2><?php echo $casino_title.' '.$title_extension ?></h2>
                                <div class="start-rating">
                                    <?php
                                    if(isset($top_sec['casino_star']) && !empty($top_sec['casino_star'])) {
                                        $count = $top_sec['casino_star'];
                                    } else {
                                        $count = 'zero';
                                    }
                                    // $args = array(
                                    //    'rating' => $count,
                                    //    'type' => 'rating',
                                    //    'number' => 12345,
                                    // );
                                    // //$rating = wp_star_rating($args);
                                    // wp_star_rating($args)
                                    ?>
                                </div>
                                 <div class="starts <?php echo $top_sec['casino_star'];?>">
                                    <div class="star-grey" style="background-image: url(<?php echo $star_img; ?>)"></div>
                                    <div class="star-given" style="background-image: url(<?php echo $star_img; ?>)"></div>
                                </div> 
                            </div>
                            <div class="visit-casino">
                                <a href="<?php echo $visit_link; ?>"><?php echo $visit_casino; ?></a>
                            </div>
                        </div>
                        <!-- CASINO BUTTONS -->
                        <div class="casino-btn-wrapper">
                            <a href="#overview" class="overview  active tab-o-btn" data-open="overview">
                                <img src="/wp-content/uploads/2021/09/03.png"
                                    alt="">
                                <h3><?php echo $overview_btn; ?></h3>
                            </a>

                            <a href="#details" class="overview  tab-o-btn" data-open="details">
                                <img src="/wp-content/uploads/2021/09/04.png"
                                    alt="">
                                <h3><?php echo $details_btn ?></h3>
                            </a>
                            <a href="#bonus" class="overview tab-o-btn" data-open="bonus">
                                <img src="/wp-content/uploads/2021/09/05.png"
                                    alt="">
                                <h3><?php echo $bonus_btn ?></h3>
                            </a>
                            <a href="#player_review" class="overview tab-o-btn" data-open="player">
                                <img src="/wp-content/uploads/2021/09/Player-reviews.svg"
                                    alt="">
                                <h3><?php echo $player_review_btn ?></h3>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- BOTTOM SECTION -->
            <div class="bottom-section flex">
                <div class="casino-sidebar">
                    <!-- ALL GAMES -->
                    <div class="games-casino sidebar-phase-casino">
                        <div class="game-heading flex space-between align-center">
                            <div class="title flex">
                                <img src="/wp-content/uploads/2021/09/Games.svg" alt="">
                                <h3><?php echo $games_title; ?></h3>
                            </div>
                            <?php
                            $gameOpt = array('Slots','Jackpot games','Roulette','Live games','Blackjack','Poker','sport betting','Craps','Video poker','keno','Bingo','Scratch cards','Baccart','eSports betting');
                            $gameCount = 0;
                              $arrayGam = array();

                              foreach($games as $val) {
                                $arrayGam[] = $val;
                              }

                             ?>
                            <div class="show-all">
                                <a href="" class="show-all-btn-global" data-open="games"><?php echo $show_all_text; ?><span>(<?php echo count($gameOpt); ?>)</span></a>
                            </div>
                        </div>
                        <!-- ALL GAMES -->

                        <div class="all-games hain connector-show-all" data-open="games">
                            <?php 
                              $Slots = "/wp-content/uploads/2021/09/Slots.svg";
                              $Jackpot_games = "/wp-content/uploads/2021/09/Jackpot-Games.svg";
                              $Roulette= "/wp-content/uploads/2021/09/Roulette.svg";
                              $Live_games= "/wp-content/uploads/2021/09/Live.svg";
                              $Blackjack= "/wp-content/uploads/2021/09/Roulette.svg";
                              $Poker= "/wp-content/uploads/2021/09/Poker.svg";
                              $sport_betting= "/wp-content/uploads/2021/09/Roulette.svg";
                              $Craps= "/wp-content/uploads/2021/09/Roulette.svg";
                              $Video_poker= "/wp-content/uploads/2021/09/Roulette.svg";
                              $keno= "/wp-content/uploads/2021/09/Roulette.svg";
                              $Bingo= "/wp-content/uploads/2021/09/Roulette.svg";
                              $Scratch_cards= "/wp-content/uploads/2021/09/scratch-cards.svg";
                              $Baccart= "/wp-content/uploads/2021/09/Roulette.svg";

                              $eSports_betting= "/wp-content/uploads/2021/09/Sports-betting.svg";
                            
                             
                                  foreach($gameOpt as $val) {
                                      $class = ((in_array($val, $arrayGam)) ? '' : 'no-game');
                                      $no_txt = ((in_array($val, $arrayGam)) ? '' : 'no ');
                                        if($gameCount >= 12){
                                            $noClass = ' hide-all';
                                        }
                                        else{
                                            $noClass = '';
                                        }
                                      // echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
                                        $imgSrc = "";
                                     switch ($val) {
                                       case "Slots":
                                         $imgSrc = $Slots;
                                         break;
                                       case "Jackpot games":
                                         $imgSrc = $Jackpot_games;
                                         break;
                                        case "Roulette":
                                         $imgSrc = $Roulette;
                                         break;
                                        case "Live games":
                                         $imgSrc = $Live_games;
                                         break; 
                                         case "Blackjack":
                                         $imgSrc = $Blackjack;
                                         break; 
                                         case "Poker":
                                         $imgSrc = $Poker;
                                         break; 
                                         case "sport betting":
                                         $imgSrc = $sport_betting;
                                         break; 
                                         case "Craps":
                                         $imgSrc = $Craps;
                                         break;
                                         case "Video poker":
                                         $imgSrc = $Video_poker;
                                         break;
                                         case "keno":
                                         $imgSrc = $keno;
                                         break;
                                         case "Bingo":
                                         $imgSrc = $Bingo;
                                         break;
                                         case "Scratch cards":
                                         $imgSrc = $Scratch_cards;
                                         break;
                                         case "Baccart":
                                         $imgSrc = $Baccart;
                                         break;
                                         case "eSports betting":
                                         $imgSrc = $eSports_betting;
                                         break;
                                       default:
                                         $imgSrc = "";
                                     }
                                      echo '<div class="single-game '.$class.$noClass.'" data-count="'.$gameCount.'"><img src="'.$imgSrc.'"><span>'.$no_txt.$val.'</span></div>';
                                      $gameCount++;
                                  }
                                
                            ?>
                            
                            
                                           

                        </div>
                    </div>
                    <!-- payment methods -->
                    <div class="payment-method sidebar-phase-casino">
                        <div class="all-heading-casino flex">
                            <div class="title flex">
                                <img src="/wp-content/uploads/2021/09/Payments-Methods.svg" alt="">
                                <h3><?php echo $payment_title; ?></h3>
                            </div>
                            <div class="show-all">
                                <a href="#" class="show-all-btn-global" data-open="pp-provider"><?php echo $show_all_text; ?> <span>(<?php echo count($payment_provider); ?>)</span></a>
                            </div>
                        </div>
                         <?php if(isset($payment_provider)) { ?>
                        <div class="images-info casino-grid-img connector-show-all" data-open="pp-provider">
                            <?php
                                                     $visa = 'Visa';
                                                    $mastercard = 'Mastercard';
                                                    $neteller ='Neteller';
                                                    $skrill = 'Skrill';
                                                    $paypal = 'Paypal';
                                                    $bitcoin = 'Bitcoin';
                                                    $ecopayz = 'Ecopayz';
                                                    $muchbetter = 'MuchBetter';
                                                    $trustly = 'Trustly';
                                                    $paysafecard = 'Paysafecard';
                                                    $astropay = 'AstroPay';
                                                    $bankwire = 'BankWire';
                                                    $maestro = 'Maestro';
                                                    $ethereum = 'Ethereum';
                                                    $litecoin = 'Litecoin';
                                                    $applepay = 'ApplePay';
                                                    $content = '';
                                                    $ppCOunter = 0;
                                                    foreach($payment_provider as $value) {
                                                         
                                                         if($ppCOunter >= 5){
                                                            $noClass = "hide-all";
                                                         }
                                                         else{
                                                            $noClass = '';
                                                         }
                                                        // $content .= '<div class="single-options">';
                                                            if($value === $visa) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">';
                                                            if($value === $mastercard) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">';
                                                            if($value === $neteller) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Neteller.jpg">';
                                                            if($value === $skrill) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Skrill.jpg">';
                                                            if($value === $bitcoin) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                            if($value === $paypal) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Paypal.jpg">';
                                                            if($value === $ecopayz) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Ecopayz.png">';
                                                            if($value === $muchbetter) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/MuchBetter.jpg">';
                                                            if($value === $trustly) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Trustly.jpg">';
                                                            if($value === $paysafecard) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Paysafecard.jpg">';
                                                            if($value === $astropay) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Astropay.png">';
                                                            if($value === $bankwire) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Bankwire.jpg">';
                                                            if($value === $maestro) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Maestro.jpg">';
                                                            if($value === $ethereum) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Ethereum.png">';
                                                            if($value === $litecoin) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Litecoin.png">';
                                                            if($value === $applepay) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Applepay.png">';
                                                        // $content .= '</div>';
                                                            $ppCOunter++;
                                                    }
                                                    echo $content;
                                                    ?>

                        </div>
                    <?php } ?>
                    </div>
                    <!-- WITHDRAWA LIMIT -->
                    <div class="withdraw-limit sidebar-phase-casino">
                        <div class="all-heading-casino flex">
                            <div class="title flex">
                                <img src="/wp-content/uploads/2021/09/Withdraw-Limits.svg" alt="">
                                <h3><?php echo $withdraw_title; ?></h3>
                            </div>

                        </div>
                        <?php  if(isset($withdraw_limitz) && !empty($withdraw_limitz)){ ?>
                        <div class="withdraw-limit-phases flex">
                            <?php 
                                foreach($withdraw_limitz as $wl){
                                    ?>
                                    <div class="p-m wlc">
                                        <?php echo $wl['title']; ?>
                                        <span><?php echo $wl['withdraw_limit_text']; ?></span>
                                    </div>
                                <?php
                                }
                                ?>
                        </div>
                       <?php }  ?>
                    </div>
                    <!-- GAMES PROVIDER -->
                    <div class="games-provider sidebar-phase-casino">
                        <div class="all-heading-casino flex">
                            <div class="title flex">
                                <img src="/wp-content/uploads/2021/09/Games-Provider.svg" alt="">
                                <h3><?php echo $games_provider_title; ?></h3>
                            </div>
                            <div class="show-all">
                                <a href="#" class="show-all-btn-global" data-open="gamePro"><?php echo $show_all_text; ?><span>(<?php echo count($games_provider); ?>)</span></a>
                            </div>
                        </div>
                        <?php  if(!empty($games_provider)) { ?>
                        <div class="images-info casino-grid-img connector-show-all" data-open="gamePro">
                            <?php
                                                     $netent = 'netent';
                                                    $novomatic = 'novomatic';
                                                    $EGT ='EGT';
                                                    $Microgaming = 'Microgaming';
                                                    $playtech = 'playtech';
                                                    $PlayNGo = 'PlayNGo';
                                                    
                                                     $ppCOunter = 0;
                                                    $content = '';
                                                    foreach($games_provider as $value) {
                                                          if($ppCOunter >= 2){
                                                            $noClass = "hide-all";
                                                         }
                                                         else{
                                                            $noClass = '';
                                                         }
                                                        
                                                        // $content .= '<div class="single-options">';
                                                            if($value === $netent) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">';
                                                            if($value === $novomatic) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">';
                                                            if($value === $EGT) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Neteller.jpg">';
                                                            if($value === $Microgaming) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Skrill.jpg">';
                                                            if($value === $playtech) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                            if($value === $PlayNGo) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                        // $content .= '</div>';
                                                            $ppCOunter++;
                                                    }
                                                    echo $content;
                                                    ?>
                        </div>
                    <?php } ?>
                    </div>
                    <!-- ABOUT casino -->
                    <div class="about-casino relative justify-center flex flex-col">
                        <img src="<?php echo $top_sec['casino_banner']?>" alt="">
                        <?php if(!empty($casino_company)) { 
                           foreach ($casino_company as $cc){
                            ?>
                        <div class="establish ac-phase">
                            <strong><?php echo $cc['casino_company_details_title']; ?></strong><span><?php echo $cc['casino_company_details_text']; ?></span>
                        </div>
                         <?php } } ?>
                    </div>
                    <div class="visit-casino seperate">
                        <a href="<?php echo $visit_link; ?>"><?php echo $visit_casino; ?></a>
                    </div>
                </div>

                <!-- RIGHT SECTION -->
                <div class="casino-all-content sidebar-phase-casino">
                    <!-- CASINO OVERVIEW -->
                    <div class="casino-overview casino-tabz" data-tab="overview">
                        <div class="overview-wrapper">
                            <div class="txt-video flex">
                                <?php if($overview){ ?>
                                <div class="video-wrapper">
                                    <?php echo $overview['featured_video_']; ?>
                                </div>
                                <div class="about-casino-tx">
                                    <h3><?php echo $overview['info_title']; ?></h3>
                                    <?php echo $overview['info_text_']; ?>
                                    <div class="read-more-para flex">
                                        <a href="" class="red-more-para">
                                        <img src="/wp-content/uploads/2021/09/41-01.png">
                                        <span>...</span>
                                        </a>
                                    </div>

                                </div>
                            <?php } ?>
                            </div>
                            <!-- INSIDER BONUS -->
                            <div class="casino-bonus-wrapper-overview">
                                <div class="all-heading-casino flex main-header">
                                    <div class="title flex">
                                        <img src="/wp-content/uploads/2021/09/05.png" alt="">
                                        <h3 class="relative ow-bonus"><?php echo $of_bonust; ?></h3>
                                    </div>
                                    <div class="show-all">
                                        <a href="#"><?php echo $show_all_text; ?> <span>(17)</span></a>
                                    </div>
                                </div>
                                <!-- BONUS BOXES -->
                                <div class="bonus-boxes-wrapper-short">
                                    
                                   <?php echo $overview['bonus_shortcode'];?>
                                    
                                </div>
        
                            </div>
                            <!-- REVIEW SECTION -->
                            <div class="review-wrapper inside-overview-off">
                                <div class="all-heading-casino flex main-header">
                                    <div class="title flex">
                                        <img src="/wp-content/uploads/2021/09/Review.svg" alt="">
                                        <h3><?php echo $of_reveiwt;  ?></h3>
                                    </div>
                                   
                                </div>
                                <!-- VIEW SECTION -->
                                <div class="view-section-wrap">
                                    <h4><?php echo $of_viewsect;  ?></h4>
                                    <!-- points -->

                                    <div class="sec-point">
                                        <?php 
                                        
                                    (empty($overview['review_section'])) ? $sub_sec= "" : $sub_sec = $overview['review_section'];
                                        if($sub_sec){
                                        $sss = 1;
                                        foreach ($sub_sec as $ss) {
                                            ?>
                                           <div class="single-point">
                                               <a href="#<?php echo $ss['link_text'];  ?>" class="single-point-list" data-sec="<?php echo $sss; ?>"><?php echo $ss['title'];  ?></a>
                                               
                                           </div>
                                         <?php 
                                         $sss++;
                                        }
                                        }
                                        ?>
                                        
                                    </div>
                                </div>
                                <!-- ALL REVIEWS -->
                                 <div class="all-review-wrapper">
                                   <?php if($sub_sec){ 
                                    $ppp = 1;
                                    foreach($sub_sec as $sss){
                                    ?>
                                     <div class="single-review" id="<?php echo $sss['link_text']; ?>" data-num-review="<?php echo $ppp; ?>">
                                        <h4 class="review-heading"><?php echo $sss['title']; ?></h4>
                                         <?php echo $sss['text_in_brief']; ?>
 
                                     </div>
                                   <?php $ppp++; } } ?>
                                 </div>
                                 <?php if(isset($faqz) && !empty($faqz)){ ?>
                                 <div class="faqzz">
                                    <h4 class="review-heading">Most frequently questions asked by our community</h4>
                                       <?php foreach($faqz as $ff) { ?>
                                            <div class="single-faq">
                                                <h5 class="faq-title"><?php echo $ff['faqs_title'];  ?></h5>
                                                 <p class="faq-desc"><?php echo $ff['faqs_text'];  ?></p>                                     
                                            </div>

                                       <?php } ?>
                                 </div>
                             <?php } ?>
                            </div>
                            <!-- LEARN MORE SECTION -->
                            <div class="learnmore-wrapper inside-overview-off">
                                <div class="all-heading-casino flex main-header">
                                    <div class="title flex">
                                        <img src="/wp-content/uploads/2021/09/39-01.png" alt="">
                                        <h3>Learn More</h3>
                                    </div>
                                </div>
                                <!-- NEWS SLIDER -->
                               <?php if(!empty($news_slider)){ ?>
                                <div class="news-slider related-news-slider">
                                    <div class="site-slider">
                                    <?php foreach($news_slider as $ns) { 
                                        $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $ns->ID ), 'full' );
                                        ?>
                                      <div class="single-news">
                                         <a href="<?php the_permalink($ns->ID); ?>" target="_blank" class="single-slide">
                                             <img src="<?php echo $featured_image[0]; ?>">
                                             <h4 class="ns-title"><?php echo $ns->post_title; ?></h4>
                                         </a>

                                      </div>
                                     <?php } ?>
                                  </div>
                              </div>
                               <?php } ?>
                                  
                            </div>
                        </div>
                    </div>


                    <!-- CASINO OVERVIEW-END -->
                    <!-- CASINO DETAILS -->
                    <div class="casino-detail-tab casino-tabz" data-tab="details">
                        <div class="pro-con flex" style="background: url(<?php echo $procons['pro_con_bg']; ?>);">
                            <div class="pros-sec pro-con-inner">
                                <div class="pro-con-title">
                                    <h4><?php echo $pro_title;  ?></h4>
                                </div>
                                <?php  if($pross){ ?>
                                <ul class="pro-lists">
                                    <?php foreach($pross as $pr){ if(!empty($pr['pros_list'])) { ?>
                                    <li class="pro-list-item"><?php echo $pr['pros_list']; ?></li>
                                   <?php } }?>
                                </ul>
                                 <?php  } ?>
                            </div>
                            <div class="cons-sec pro-con-inner">
                                <div class="pro-con-title">
                                    <h4><?php echo $con_title;  ?></h4>
                                </div>
                               <?php  if($pross){ ?>
                               <ul class="con-lists">
                                   <?php foreach($pross as $cr){  if(!empty($cr['cons_list'])) { ?>

                                   <li class="pro-list-item z"><?php echo $cr['cons_list']; ?></li>
                                  <?php } }?>
                               </ul>
                                <?php  } ?>

                            </div>


                        </div>
                        <!-- CASINO MORE DETAILS -->
                        <div class="casino-more-details">
                            <!-- licence -->
                            <div class="casino-licence">
                                <div class="all-heading-casino flex main-header">
                                    <div class="title flex">
                                        <img src="/wp-content/uploads/2021/09/Licenses.svg">
                                    <h3><?php echo $dt_lict;  ?></h3>
                                    </div>
                                </div>
                                <div class="country-wrapper">
                                    <?php  if(!empty($licence_country)){
                                         foreach ($licence_country as $lc){
                                         
                                        ?>

                                    <div class="single-country flex">

                                        <img src="africa-flag1.png" alt="">
                                        <span class="country-name"></span>
                                    </div>
                                
                                    <?php } } ?>
                                </div>
                            </div>
                            <!-- PAYMENT PROVIDERS -->
                            <div class="payment-pro">
                               <div class="all-heading-casino flex main-header">
                                   <div class="title flex">
                                    <img src="/wp-content/uploads/2021/09/Payment-providers.svg">
                                    <h3><?php echo $dt_payprot;  ?></h3>
                                    </div>
                                    <div class="show-all">
                                        <a href="#" class="show-all-btn-global" data-open="ppinner"><?php echo $show_all_text;  ?><span>(<?php  echo count($payment_provider_detail_tab); ?>)</span></a>
                                    </div>

                                </div>
                                <!-- PAYMENT PROVIDER IMAGES -->
                                    <?php  
                                     
                                    if(!empty($payment_provider_detail_tab)) { ?>
                                    <div class="image-wrapper-pp connector-show-all" data-open="ppinner">
                                        <?php
                                                                 $netent = 'netent';
                                                                $novomatic = 'novomatic';
                                                                $EGT ='EGT';
                                                                $Microgaming = 'Microgaming';
                                                                $playtech = 'playtech';
                                                                $PlayNGo = 'PlayNGo';
                                                                $paymentPro = 1;
                                                              
                                                                $content = '';
                                                                foreach($payment_provider_detail_tab as $value) {
                                                                    if($paymentPro >= 6){
                                                                        $noClass = ' hide-all';
                                                                    }
                                                                    else{
                                                                        $noClass = '';
                                                                    }
                                                                    
                                                                    // $content .= '<div class="single-options">';
                                                                        if($value === $netent) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">';
                                                                        if($value === $novomatic) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">';
                                                                        if($value === $EGT) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Neteller.jpg">';
                                                                        if($value === $Microgaming) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Skrill.jpg">';
                                                                        if($value === $playtech) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                                        if($value === $PlayNGo) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                                    // $content .= '</div>';
                                                                        $paymentPro++;
                                                                }
                                                                echo $content;
                                                                ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- LANGUAGES -->
                            <div class="casino-lang">
                                <div class="all-heading-casino flex main-header">
                                    <div class="title flex">
                                        <img src="/wp-content/uploads/2021/09/languages.svg">
                                    <h3><?php echo $dt_langt;  ?></h3>
                                 </div>
                                </div>
                                <div class="country-wrapper">
                                     <?php  if($languagess){
                                         foreach($languagess as $langg){
                                        ?>
                                    <div class="single-country flex">
                                        <img src="<?php echo $langg['flag_img'] ?>" alt="">
                                        <span class="country-name"><?php echo $langg['lang_text'] ?></span>
                                    </div>
                                  <?php } } ?>

                                </div>
                            </div>
                            <!-- game PROVIDERS -->
                            <div class="payment-pro">
                                <div class="all-heading-casino flex main-header">
                                    <div class="title flex">
                                        <img src="/wp-content/uploads/2021/09/Games-Provider.svg">
                                    <h3><?php echo $dt_gamept;  ?></h3>
                                    </div>
                                    <div class="show-all">
                                        <a href="#" class="show-all-btn-global" data-open="gproin"><?php echo $show_all_text;  ?> <span>(<?php  echo count($games_provider); ?>)</span></a>
                                    </div>
                                </div>
                                <!-- GAME PROVIDER IMAGES -->
                                   <?php  if(!empty($games_provider)) { ?>
                                   <div class="image-wrapper-pp connector-show-all" data-open="gproin">
                                       <?php
                                                                $netent = 'netent';
                                                               $novomatic = 'novomatic';
                                                               $EGT ='EGT';
                                                               $Microgaming = 'Microgaming';
                                                               $playtech = 'playtech';
                                                               $PlayNGo = 'PlayNGo';
                                                               $gameCount = 1;
                                                             
                                                             if($gameCount >= 5){
                                                                 $noClass = ' hide-all';
                                                             }
                                                             else{
                                                                 $noClass = '';
                                                             }
                                                               $content = '';
                                                               foreach($games_provider as $value) {
                                                                   
                                                                   // $content .= '<div class="single-options">';
                                                                       if($value === $netent) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">';
                                                                       if($value === $novomatic) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">';
                                                                       if($value === $EGT) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Neteller.jpg">';
                                                                       if($value === $Microgaming) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Skrill.jpg">';
                                                                       if($value === $playtech) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                                       if($value === $PlayNGo) $content .= '<img class="'.$noClass.'" src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                                   // $content .= '</div>';
                                                               }
                                                               $gameCount++;
                                                               echo $content;
                                                               ?>
                                   </div>
                               <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- CASINO DETAILS END -->

                    <!-- CASINO BONUS SECTION -->
                    <div class="casino-bonus-wrapper casino-tabz" data-tab="bonus">
                        <div class="all-heading-casino flex main-header">
                            <div class="title flex">
                                <img src="/wp-content/uploads/2021/09/05.png">
                                <h3><?php echo $bt_bonust;  ?></h3>
                            </div>
                            <div class="show-all">
                                <a href="#" class="show-all-btn-global" data-open="allBonus"><?php echo $show_all_text;  ?> <span></span></a>
                            </div>
                        </div>
                        <!-- BONUS BOXES -->
                        <div class="bonus-boxes-wrapper-short connector-show-all" data-open="allBonus">
                          <?php echo $bonus_tabz['bonus_shortcode']; ?>
                        </div>

                    </div>
                    <!-- CASINO BONUS SECTION END -->

                    <!-- PLAYER REVIEW SECTION STARTED -->
                    <div class="player-review all-wrap-casino casino-tabz" data-tab="player">
                        <div class="player-review-content ">

                            <div class="all-heading-casino flex main-header">
                                <div class="title flex">
                                    <img src="/wp-content/uploads/2021/09/Player-reviews.svg">
                                    <h3><?php echo $pt_plarewt; ?></h3>
                                </div>
                                <div class="show-all">
                                    <a href="#"><?php echo $show_all_text; ?><span>(17)</span></a>
                                </div>
                            </div>

                        </div>
                        <div class="review-form-wrapper flex align-center">
                            <div class="avtar-sec relative flex flex-col justify-center align-center">
                                <img src="africa-flag1.png" alt="">
                                <div class="stars">
                                    <div class="star-bg"></div>
                                </div>
                            </div>
                            <!-- middle grey sec -->
                            <div class="blank-area">
                             <div class="com-form"> </div>

                            </div>
                            <!-- BUTTON -->
                         
                        </div>
                       
                         <div class="reviez"><?php echo do_shortcode('[reviews]'); ?><!-- <?php echo ic_get_reviews_average_html() ?> --></div>
                    </div>
                    <!-- PLAYER REVIEW SECTION END HERE -->
                    <!--  -->

                </div>
            </div>
        </div>
    </div>
    </div>


<?php get_footer(); ?>