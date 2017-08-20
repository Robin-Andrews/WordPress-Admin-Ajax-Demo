<?php
/*
  Plugin Name: Ajax Demo
  Description: A basic WP ajax demo
 */

function raad_admin_page() {
    global $raad_settings;
    $raad_settings = add_options_page(__('Ajax Demo', 'raad'), __('Ajax Demo', 'raad'), 'manage_options', 'ajax-demo', 'raad_render_admin');
}

add_action('admin_menu', 'raad_admin_page');

function raad_render_admin() {
    ?>
    <div class="wrap">
        <h2><?php _e('Ajax Demo', 'raad'); ?></h2>
        <form id="raad-form" method="post">
            <div>
                <input type="submit" id="raad_submit" name="raad-submit" class="button-primary" value="<?php _e('get results', 'raad'); ?>">
                <img id="raad_loading" src="<?= admin_url( '/images/wpspin_light.gif' ); ?>" style="display: none;">
            </div>
        </form>
        <div id="raad-results"></div>
    </div>
    <?php
}

function raad_load_scripts($hook) {
    global $raad_settings;
    if ($hook != $raad_settings) {
        return;
    }
    wp_enqueue_script('raad-ajax', plugins_url('js/raad-ajax.js', __FILE__), array('jquery'));
    wp_localize_script('raad-ajax', 'raad_vars', array(
        'raad_nonce' => wp_create_nonce('raad-nonce')
    ));
}

add_action('admin_enqueue_scripts', 'raad_load_scripts');

function raad_process_ajax() {
    
    if( !isset($_POST['raad_nonce']) || !wp_verify_nonce( $_POST['raad_nonce'], 'raad-nonce' )){
        die('permissions check failed');
    }

    $my_posts = get_posts(array('post_type' => 'post', 'posts_per_page' => 4));
    
    if ( $my_posts ):
        echo '<ul>';
           foreach($my_posts as $my_post){
               echo '<li>' . get_the_title($my_post->ID) . '<a href="' . get_the_permalink($my_post->ID) . '"> ' . __('view post', 'raad') . '</a></li>';
           }
        echo '</ul>';
        
    else: 
        echo '<p>' . __('No results found', 'raad') . '</p>';
    endif;

    die();
}

add_action('wp_ajax_raad_get_results', 'raad_process_ajax');
