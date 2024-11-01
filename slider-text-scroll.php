<?php
/**
 * Plugin Name:       Easy Slider Text Scroll
 * Plugin URI:        https://wordpress.org/plugins/slider-text-scroll
 * Description:       Easy to add Slider Text Scroll via shortcode [sts] for every WordPress theme. It Designed, Developed, Maintained & Supported by vir-za Team.
 * Version:           1.0.0
 * Author:            1mdalamin1
 * Author URI:        https://www.vir-za.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain:       slider-text-scroll
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define 
$st1 = get_option('ests_text_color') ? get_option('ests_text_color') :'#000';
$st2 = get_option('ests_text_size') ? get_option('ests_text_size') :'24';
$st3 = get_option('ests_text_style') ? get_option('ests_text_style') :'bold';
$st4 = get_option('ests_ft_speed') ? get_option('ests_ft_speed') :'70';
$st5 = get_option('ests_bk_speed') ? get_option('ests_bk_speed') :'60';
$st6 = get_option('ests_start_delay') ? get_option('ests_start_delay') :'0';
$st7 = get_option('ests_end_delay') ? get_option('ests_end_delay') :'1400';
$st8 = get_option('ests_st_hight') ? get_option('ests_st_hight') :'-1';

if ($st8<0) {
  $minHight = $st2 * 1.5; 
}else {
  $minHight = $st8; 
}
$st9 = get_option('ests_loop') ? get_option('ests_loop') :'true';
$st10= get_option('ests_text') ? get_option('ests_text') :__('It Designed, Developed, Maintained, Supported, vir-za.com','slider-text-scroll');

$arr = explode(",", $st10);
$arr = array_map('trim', $arr); // to remove any extra white space around each element
$output = json_encode($arr);

define('ESTS_ST_COLOR',$st1);
define('ESTS_ST_SIZE',$st2);
define('ESTS_ST_STYLE',$st3);
define('ESTS_ST_STYPE_S',$st4);
define('ESTS_ST_BK_S',$st5);
define('ESTS_ST_S_D',$st6);
define('ESTS_ST_BK_D',$st7);
define('ESTS_ST_H',$minHight); // works....
define('ESTS_ST_LOOP',$st9);
define('ESTS_ST_TEXT',$output); // works....

$tColor = get_option('ests_ts_text_color') ? get_option('ests_ts_text_color') :'#000';
$tSize  = get_option('ests_ts_text_size') ? get_option('ests_ts_text_size') :'24';
$tStyle = get_option('ests_ts_text_style') ? get_option('ests_ts_text_style') :'bold';
$tgap   = get_option('ests_ts_text_gap') ? get_option('ests_ts_text_gap') :'30';
$tdir   = get_option('ests_ts_text_dir') ? get_option('ests_ts_text_dir') :'left';
$tdur   = get_option('ests_ts_text_dur') ? get_option('ests_ts_text_dur') :'10000';
$text   = get_option('ests_ts_text') ? get_option('ests_ts_text') :__('Slider Text Scroll','slider-text-scroll');
$visi   = get_option('ests_ts_start_visible') ? get_option('ests_ts_start_visible') :'false';

define('ESTS_T_COLOR',$tColor);
define('ESTS_T_SIZE',$tSize);
define('ESTS_T_STYLE',$tStyle);
define('ESTS_T_GAP',$tgap);
define('ESTS_TDIR',$tdir);
define('ESTS_T_DUR',$tdur);
define('ESTS_TEXT',$text);
define('ESTS_VISI',$visi);


/*
* Plugin Option Page Style
*/
function ests_add_wp_admin_plugin_css(){
    wp_enqueue_style( 'sts-admin-style', plugins_url( 'css/sts-admin-style.css', __FILE__ ), false, "1.0.0");
    $ests_admin_custom_css = '
        .marquee_text {
            font-size: ' . esc_attr(ESTS_T_SIZE) . 'px;
            font-weight: ' . esc_attr(ESTS_T_STYLE) . ';
            color: ' . esc_attr(ESTS_T_COLOR) . ';
            overflow: hidden;
        }
    
        .hero_title {
            font-size: ' . esc_attr(ESTS_ST_SIZE) . 'px;
            font-weight: ' . esc_attr(ESTS_ST_STYLE) . ';
            color: ' . esc_attr(ESTS_ST_COLOR) . ';
            min-height: ' . esc_attr(ESTS_ST_H) . 'px;
        }
    ';
    
    wp_add_inline_style('sts-admin-style', $ests_admin_custom_css);
    
    wp_enqueue_script('jquery');
    wp_enqueue_script('sts-plugin-script', plugins_url('js/sts.marquee.min.js', __FILE__), array('jquery'), '1.0.0', 'true');
    wp_enqueue_script('sts-typed-script', plugins_url('js/sts.typed.js', __FILE__), array('jquery'), '1.0.0', 'true');

    wp_enqueue_script('ests-admin-script', plugins_url('js/ests_admin_custom.js', __FILE__), array('jquery'), '1.1.0', 'true');
    // Localize the script and pass PHP values
    wp_localize_script('ests-admin-script', 'estsObjAdmin', array(
      'tDir' => ESTS_TDIR,
      'tDur' => ESTS_T_DUR,
      'tGap' => ESTS_T_GAP,
      'visi' => ESTS_VISI,
      'stText' => ESTS_ST_TEXT,
      'stTypeSpeed' => ESTS_ST_STYPE_S,
      'stStartDelay' => ESTS_ST_S_D,
      'stBackSpeed' => ESTS_ST_BK_S,
      'stBackDelay' => ESTS_ST_BK_D,
      'stLoop' => ESTS_ST_LOOP
    ));

}
add_action('admin_enqueue_scripts', 'ests_add_wp_admin_plugin_css');

// === >>>> Dashboard Left side menu <<<< === \\

add_action("admin_menu", "ests_wp_admin_dashboard_sts_menu_reg");
function ests_wp_admin_dashboard_sts_menu_reg() {
    add_menu_page(
        __('Slider Text Scroll','slider-text-scroll'), 
        __('Text Scroll','slider-text-scroll'), // menu title
        'manage_options', // capability
        'sliderTextScroll', // sluge
        'ests_text_scroll_setting_fun', // function for page
        'dashicons-ellipsis',
        10
        // plugins_url('/img/icon.png',__DIR__) // icon url
    );

    //add submenu 2
    add_submenu_page(
        'sliderTextScroll', // parent menu slug
        __('Slider Text ','slider-text-scroll'), // Page title
        'Text Slider', // Menu title
        'manage_options',  // Capability
        'textSlider', // sub menu slug
        'ests_text_slider_setting_fun' // sub meun funciton for page
    );

}




// Including CSS
function ests_enqueue_style(){
    wp_enqueue_style('sts-style', plugins_url('css/sts-style.css', __FILE__));
    $custom_css = '
        .marquee_text {
            font-size: ' . esc_attr(ESTS_T_SIZE) . 'px;
            font-weight: ' . esc_attr(ESTS_T_STYLE) . ';
            color: ' . esc_attr(ESTS_T_COLOR) . ';
            overflow: hidden;
        }
    
        .hero_title {
            font-size: ' . esc_attr(ESTS_ST_SIZE) . 'px;
            font-weight: ' . esc_attr(ESTS_ST_STYLE) . ';
            color: ' . esc_attr(ESTS_ST_COLOR) . ';
            min-height: ' . esc_attr(ESTS_ST_H) . 'px;
        }
    ';
    
    wp_add_inline_style('sts-style', $custom_css);
}
add_action( "wp_enqueue_scripts", "ests_enqueue_style" );

// Including JavaScript
function ests_enqueue_scripts(){
    //wp_enqueue_script('jquery');
    wp_enqueue_script('sts-plugin-script', plugins_url('js/sts.marquee.min.js', __FILE__), array('jquery'), '1.0.0', 'true');
    wp_enqueue_script('sts-typed-script', plugins_url('js/sts.typed.js', __FILE__), array('jquery'), '1.0.0', 'true');
    wp_enqueue_script('ests-custom-script', plugins_url('js/ests_custom.js', __FILE__), array('jquery'), '1.1.0', 'true');
    // Localize the script and pass PHP values
    wp_localize_script('ests-custom-script', 'estsCustomData', array(
      'tDir' => ESTS_TDIR,
      'tDur' => ESTS_T_DUR,
      'tGap' => ESTS_T_GAP,
      'visi' => ESTS_VISI,
      'stText' => ESTS_ST_TEXT,
      'stTypeSpeed' => ESTS_ST_STYPE_S,
      'stStartDelay' => ESTS_ST_S_D,
      'stBackSpeed' => ESTS_ST_BK_S,
      'stBackDelay' => ESTS_ST_BK_D,
      'stLoop' => ESTS_ST_LOOP
    ));

}
add_action( "wp_enqueue_scripts", "ests_enqueue_scripts" );


// add from Short code
add_shortcode('sts','ests_short_code_fun');
function ests_short_code_fun($jekono){ 
$result = shortcode_atts(array( 
   'move' =>'',
),$jekono);
extract($result);
ob_start();


  if ($move) {
    if ($move === 'sts') {
      // echo ESTS_TEXT;
      ?>
        <div class='marquee_text'><?php echo ESTS_TEXT?></div>
      <?php
    } else{
      ?>
        <div class='marquee_text'><?php echo $move?></div>
      <?php
    }
  }else{
    echo '<div class="hero_title"></div>';
  }


return ob_get_clean();
}



// Text Scroll wp dashboard setting page
function ests_text_scroll_setting_fun(){
    ?>
      <div class="sts_main_area">

        <div class="sts_body_area sts_common">
          <h3  class="sts-title"><?php echo esc_attr( '💐 Text Scroll Setting ✩࿐︵‿︵‿︵‿︵👻' ); ?></h3>
          <form action="options.php" method="post">
            <?php wp_nonce_field('update-options'); ?>

            <table>
              <tr>
                <td>
                  <!-- text Color -->
                  <label for="ts1" name="ests_ts_text_color"><?php echo esc_attr( 'Text Color' ); ?></label>
                  <small><?php echo esc_html( 'Add your Text Color' ); ?></small>
                </td>
                <td>
                  <input id="ts1" type="color" name="ests_ts_text_color" value="<?php echo get_option('ests_ts_text_color') ?>">
                </td>
                <td>
                  <!-- Font size -->
                  <label for="ts2"><?php echo esc_attr(__('Font size')); ?></label>
                  <small><?php echo esc_html( 'Default 24' ); ?></small>
                </td>
                <td>
                  <input id="ts2" type="number" name="ests_ts_text_size" value="<?php echo get_option('ests_ts_text_size') ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <!-- text style -->
                  <label for="ts3" name="ests_ts_text_style"><?php echo esc_attr( 'Text style' ); ?></label>
                  <small><?php echo esc_html( 'normal, bold | 400, 700' ); ?>normal, bold | 400, 700</small>
                </td>
                <td>
                  <input id="ts3" type="text" name="ests_ts_text_style" value="<?php echo get_option('ests_ts_text_style') ?>">
                </td>
                <td>
                  <!-- Text Gap -->
                  <label for="ts4"><?php echo esc_attr(__('Text Gap')); ?></label>
                  <small><?php echo esc_html( 'Default 30' ); ?></small>
                </td>
                <td>
                  <input id="ts4" type="number" name="ests_ts_text_gap" value="<?php echo get_option('ests_ts_text_gap') ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <!-- Text Direction -->
                  <label for="ts5"><?php echo esc_attr(__('Text Direction')); ?></label>
                  <small><?php echo esc_html( 'Set Text Direction' ); ?></small>
                </td>
                <td>
                  <select name="ests_ts_text_dir" id="ts5">
                    <option value="left" <?php if( get_option('ests_ts_text_dir') == 'left'){ echo 'selected="selected"'; } ?>><?php echo esc_html( 'Left' ); ?></option>
                    <option value="right" <?php if( get_option('ests_ts_text_dir') == 'right'){ echo 'selected="selected"'; } ?>><?php echo esc_html( 'Right' ); ?></option>
                  </select>
                </td>
                <td>
                  <!-- Text Duration -->
                  <label for="ts6"><?php echo esc_attr(__('Text Duration')); ?></label>
                  <small><?php echo esc_html( '1000ms = 1s Default 10000' ); ?></small>
                </td>
                <td>
                  <input id="ts6" type="number" name="ests_ts_text_dur" value="<?php echo get_option('ests_ts_text_dur') ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <!-- Scroll Text -->
                  <label for="ts7"><?php echo esc_attr(__('Scroll Text')); ?></label>
                  <small><?php echo esc_html( 'Enter your Scroll Text' ); ?></small>
                </td>
                <td colspan="3">
                  <input id="ts7" type="text" name="ests_ts_text" value="<?php echo get_option('ests_ts_text') ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <!-- startVisible -->
                  <label><?php echo esc_attr(__('Start Visible')); ?></label>
                  <small><?php echo esc_html( 'Default No' ); ?></small>
                </td>
                <td>
                  <div class="radio-wrap">
                    <label class="radios">
                      <input type="radio" name="ests_ts_start_visible" value="false"  <?php if( get_option('ests_ts_start_visible') == 'false'){ echo 'checked="checked"'; } ?> id="ests_ts_start_visible-no" ><span><?php echo esc_html( 'No' ); ?></span>
                    </label>
                    <label class="radios">
                      <input type="radio" name="ests_ts_start_visible" value="true" <?php if( get_option('ests_ts_start_visible') == 'true'){ echo 'checked="checked"'; } ?> id="ests_ts_start_visible-yes"><span><?php echo esc_html( 'Yes' ); ?></span>
                    </label>
                  </div>
                </td>
              </tr>
            </table>

            <!-- Round Corner -->
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="page_options" value="ests_ts_text_color, ests_ts_text_size, ests_ts_text_style, ests_ts_text_gap, ests_ts_text_dir, ests_ts_text_dur, ests_ts_text, ests_ts_start_visible">
            <input type="submit" name="submit" value="<?php _e('Save Changes', 'clpwp') ?>">
          </form>
        </div>

        <div class="sts_sidebar_area sts_common">
          <h3 class="sts-title"><?php echo esc_attr( '⭐☜ Preview ☞⭐' ); ?></h3>
          <div>
            
            <?php echo do_shortcode('[sts move="sts"]'); ?>

          </div>

          <h3 class="sts-title"> </h3><br>
          <h3 class="sts-title-sub"><?php echo esc_attr( '✍️ Manual [sts move="sts"]' ); ?></h3>
          <small><?php echo esc_html( 'Please use shortcod [sts move="sts"] 🎉 anywhere.' ); ?></small>
          <p><?php echo esc_html( 'If you need multiple, you will use shortcode [sts move="Any text here"] just like this, anywhere' ); ?></p>
          <br>
          <h3 class="sts-title"><?php echo esc_html( '乂❤‿❤乂' ); ?></h3>
          
          <br>
          <br>
          <p class="btn-youtube"><a href="<?php echo esc_url( 'https://www.youtube.com/@1mdalamin1' ); ?>" target="_blank" class="btn"><?php echo esc_html( '💎 Watch On YouTube' ); ?></a><img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '/img/logo.png' ); ?>" alt=""></p>

        </div>

      </div>
    <?php
}

// Text Slider wp dashboard setting page
function ests_text_slider_setting_fun(){
  ?>
    <div class="sts_main_area">
  
      <div class="sts_body_area sts_common">
          <h3  class="sts-title"><?php echo esc_attr( '︵‿︵‿︵Slider Text Setting︵‿︵‿︵' ); ?></h3>
          <form action="options.php" method="post">
          <?php wp_nonce_field('update-options'); ?>
  
          <table>
              <tr>
              <td>
                  <!-- text Color -->
                  <label for="st1" name="ests_text_color"><?php echo esc_attr( 'Text Color' ); ?></label>
                  <small><?php echo esc_html( 'Add your Text Color' ); ?></small>
              </td>
              <td>
                  <input id="st1" type="color" name="ests_text_color" value="<?php echo get_option('ests_text_color') ?>">
              </td>
              <td>
                  <!-- Font size -->
                  <label for="st2"><?php echo esc_attr(__('Font size')); ?></label>
                  <small><?php echo esc_html( 'Default 24' ); ?></small>
              </td>
              <td>
                  <input id="st2" type="number" name="ests_text_size" value="<?php echo get_option('ests_text_size') ?>">
              </td>
              </tr>
              <tr>
              <td>
                  <!-- text style -->
                  <label for="st3" name="ests_text_style"><?php echo esc_attr( 'Text style' ); ?></label>
                  <small><?php echo esc_html( 'normal, bold | 400, 700' ); ?></small>
              </td>
              <td>
                  <input id="st3" type="text" name="ests_text_style" value="<?php echo get_option('ests_text_style') ?>">
              </td>
              <td>
                  <!-- typeSpeed -->
                  <label for="st4"><?php echo esc_attr(__('Type Speed')); ?></label>
                  <small><?php echo esc_html( 'Default 70 ' ); ?></small>
              </td>
              <td>
                  <input id="st4" type="number" name="ests_ft_speed" value="<?php echo get_option('ests_ft_speed') ?>">
              </td>
              </tr>
              <tr>
              <td>
                  <!-- startDelay -->
                  <label for="st5"><?php echo esc_attr(__('Start Delay')); ?></label>
                  <small><?php echo esc_html( 'Default 0 ' ); ?></small>
              </td>
              <td>
                  <input id="st5" type="number" name="ests_start_delay" value="<?php echo get_option('ests_start_delay') ?>">
              </td>
              <td>
                  <!-- backSpeed -->
                  <label for="st6"><?php echo esc_attr(__('Back Speed')); ?></label>
                  <small><?php echo esc_html( 'Default 60 ' ); ?></small>
              </td>
              <td>
                  <input id="st6" type="number" name="ests_bk_speed" value="<?php echo get_option('ests_bk_speed') ?>">
              </td>
              </tr>
              <tr>
              <td>
                  <!-- Back Delay -->
                  <label for="st7"><?php echo esc_attr(__('Back Delay')); ?></label>
                  <small><?php echo esc_html( 'Default 1400 ' ); ?></small>
              </td>
              <td>
                  <input id="st7" type="number" name="ests_end_delay" value="<?php echo get_option('ests_end_delay') ?>">
              </td>
              <td>
                  <!-- typeSpeed -->
                  <label for="st8"><?php echo esc_attr(__('Hight')); ?></label>
                  <small><?php echo esc_html( 'Default -1=auto ' ); ?></small>
              </td>
              <td>
                  <input id="st8" type="number" name="ests_st_hight" value="<?php echo get_option('ests_st_hight') ?>">
              </td>
              
              </tr>
              <tr>
              <td>
                  <!-- startVisible -->
                  <label><?php echo esc_attr(__('Loop')); ?></label>
                  <small><?php echo esc_html( 'Default Yes' ); ?></small>
              </td>
              <td>
                  <div class="radio-wrap">
                  <label class="radios">
                      <input type="radio" name="ests_loop" value="false"  <?php if( get_option('ests_loop') == 'false'){ echo 'checked="checked"'; } ?> id="ests_loop-no" ><span><?php echo esc_html( 'No' ); ?></span>
                  </label>
                  <label class="radios">
                      <input type="radio" name="ests_loop" value="true" <?php if( get_option('ests_loop') == 'true'){ echo 'checked="checked"'; } ?> id="ests_loop-yes"><span><?php echo esc_html( 'Yes' ); ?></span>
                  </label>
                  </div>
              </td>
              </tr>
              <tr>
              <td>
                  <!-- Scroll Text -->
                  <label for="st9"><?php echo esc_attr(__('Slider Text')); ?></label>
                  <small><?php echo esc_html( 'Please Read Manual' ); ?></small>
              </td>
              <td colspan="3">
                  <textarea id="st9" name="ests_text" rows="4" cols="70"  value="<?php echo get_option('ests_text') ?>"><?php 
                   $textArea = get_option('ests_text') ? get_option('ests_text') :__('It Designed, Developed, Maintained, Supported, vir-za.com','slider-text-scroll');
                   echo esc_html($textArea); ?></textarea>
              </td>
              </tr>
          </table>
  
          <!-- Round Corner -->
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="page_options"  value="ests_text_color, ests_text_size, ests_text_style, ests_ft_speed, ests_start_delay, ests_bk_speed, ests_end_delay, ests_st_hight, ests_loop, ests_text">
          <input type="submit" name="submit" value="<?php _e('Save Changes', 'clpwp') ?>">
          </form>
      </div>
  
      <div class="sts_sidebar_area sts_common">
          <h3 class="sts-title"><?php echo esc_html( '⭐☜ Preview ☞⭐' ); ?></h3>
          <div>
          
          <?php echo do_shortcode('[sts]'); ?>
  
          </div>
  
          <h3 class="sts-title"></h3><br>
          <h3 class="sts-title-sub"><?php echo esc_html( '✍️ Manual [sts]' ); ?></h3>
          <small><?php echo esc_html( 'Please use shortcode [sts] 🎉 anywhere.' ); ?></small>
          <p><?php echo esc_html( 'If you need multiple words or sentences, you can input them separated by commas (,). For example: [It Designed, Developed, Maintained & Supported, vir-za.com, Team. etc.]' ); ?></p>
          <br>
          <h3 class="sts-title"><?php echo esc_html( '乂❤‿❤乂' ); ?></h3>

          <br>
          <br>
          <p class="btn-youtube"><a href="<?php echo esc_url( 'https://www.youtube.com/@1mdalamin1' ); ?>" target="_blank" class="btn"><?php echo esc_html( '💎 Watch On YouTube' ); ?></a><img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . '/img/logo.png' ); ?>" alt=""></p>

  
      </div>
  
    </div>
  <?php
}







