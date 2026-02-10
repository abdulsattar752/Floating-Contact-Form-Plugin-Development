<?php
/*
Plugin Name: Floating Contact Form
Description: Lightweight floating contact form with admin-controlled colors, text, and online dot.
Version: 1.2
Author: Abdul Sattar
*/

if (!defined('ABSPATH')) exit;

// Load admin settings
if (is_admin()) {
  require_once plugin_dir_path(__FILE__) . 'admin/admin-settings.php';
}

// Enqueue front-end CSS & JS
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('faic-css', plugin_dir_url(__FILE__) . 'chat.css');
  wp_enqueue_script('faic-js', plugin_dir_url(__FILE__) . 'chat.js', [], time(), true);

  wp_localize_script('faic-js', 'faic_ajax', [
    'ajax_url' => admin_url('admin-ajax.php')
  ]);
});

// Load HTML in footer
add_action('wp_footer', function () {
  include plugin_dir_path(__FILE__) . 'chat.php';
});

// AJAX form submission
add_action('wp_ajax_faic_submit_form', 'faic_submit_form');
add_action('wp_ajax_nopriv_faic_submit_form', 'faic_submit_form');

function faic_submit_form()
{
  $name    = sanitize_text_field($_POST['name'] ?? '');
  $email   = sanitize_email($_POST['email'] ?? '');
  $phone   = sanitize_text_field($_POST['phone'] ?? '');
  $region  = sanitize_text_field($_POST['region'] ?? '');
  $project = sanitize_textarea_field($_POST['project'] ?? '');

  if (!$name || !$email || !$phone || !$region || !$project) {
    wp_send_json_error('Please fill all fields.');
  }

  $to = get_option('admin_email');
  $subject = 'Floating Contact Form';
  $message = "Name: $name\nEmail: $email\nPhone: $phone\nRegion: $region\n\nProject:\n$project";
  $headers = ['Content-Type: text/plain; charset=UTF-8'];

  if (wp_mail($to, $subject, $message, $headers)) {
    wp_send_json_success('Thanks! We will contact you soon.');
  } else {
    wp_send_json_error('Email failed. Check SMTP.');
  }
  wp_die();
}

// Dynamic front-end styles from admin settings
add_action('wp_head', function () {
  $color = get_option('faic_theme_color', '#d10000');
  $dot   = get_option('faic_online_dot', 1);
?>
  <style>
    #faic-float-btn,
    #faic-header,
    #faic-widget button {
      background: <?php echo esc_attr($color); ?> !important;
    }

    #faic-widget input:focus,
    #faic-widget textarea:focus,
    #faic-widget select:focus {
      border-color: <?php echo esc_attr($color); ?> !important;
    }

    <?php if (!$dot): ?>#faic-online-dot {
      display: none !important;
    }

    <?php endif; ?>
  </style>
<?php
});
