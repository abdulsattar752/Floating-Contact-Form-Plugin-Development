<?php
/*
Plugin Name: Floating Contact Form
Description: Floating Contact Form is a lightweight and production-ready WordPress plugin that allows you to add a floating contact button on any page.

Features:

Floating button always visible on bottom-right corner and Green online dot indicator 
AJAX form submission without page reload and Live validation of required fields
Instant email notifications to admin
Lightweight and compatible with all WordPress themes

This plugin improves user engagement and ensures smooth communication with website visitors.
It’s easy to install, fully tested, and ready for production use.
Version: 1.1
Author: Abdul Sattar
*/

if (!defined('ABSPATH')) exit;

/* Enqueue CSS & JS */
add_action('wp_enqueue_scripts', function () {

  wp_enqueue_style(
    'faic-css',
    plugin_dir_url(__FILE__) . 'chat.css'
  );

  wp_enqueue_script(
    'faic-js',
    plugin_dir_url(__FILE__) . 'chat.js',
    [],
    time(),
    true
  );

  wp_localize_script('faic-js', 'faic_ajax', [
    'ajax_url' => admin_url('admin-ajax.php')
  ]);
});

/* Load HTML in footer */
add_action('wp_footer', function () {
  include plugin_dir_path(__FILE__) . 'chat.html';
});

/* AJAX handlers */
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
    wp_die();
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
