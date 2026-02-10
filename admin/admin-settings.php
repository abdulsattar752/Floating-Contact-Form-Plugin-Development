<?php
if (!defined('ABSPATH')) exit;

/* Admin Menu */
add_action('admin_menu', function () {
  add_options_page(
    'Floating Contact Form',
    'Floating Contact Form',
    'manage_options',
    'faic-settings',
    'faic_settings_page'
  );
});

/* Register Settings */
add_action('admin_init', function () {
  register_setting('faic_settings_group', 'faic_theme_color');
  register_setting('faic_settings_group', 'faic_header_text');
  register_setting('faic_settings_group', 'faic_submit_text');
  register_setting('faic_settings_group', 'faic_online_dot');
});

/* Settings Page HTML */
function faic_settings_page()
{ ?>
  <div class="wrap">
    <h1>Floating Contact Form Settings</h1>
    <form method="post" action="options.php">
      <?php settings_fields('faic_settings_group'); ?>
      <table class="form-table">

        <tr>
          <th scope="row">Main Theme Color</th>
          <td>
            <input type="color" name="faic_theme_color"
              value="<?php echo esc_attr(get_option('faic_theme_color', '#d10000')); ?>">
          </td>
        </tr>

        <tr>
          <th scope="row">Header Text</th>
          <td>
            <input type="text" class="regular-text" name="faic_header_text"
              value="<?php echo esc_attr(get_option('faic_header_text', 'Get In Touch')); ?>">
          </td>
        </tr>

        <tr>
          <th scope="row">Submit Button Text</th>
          <td>
            <input type="text" class="regular-text" name="faic_submit_text"
              value="<?php echo esc_attr(get_option('faic_submit_text', 'Submit')); ?>">
          </td>
        </tr>

        <tr>
          <th scope="row">Show Online Dot</th>
          <td>
            <label>
              <input type="checkbox" name="faic_online_dot" value="1"
                <?php checked(get_option('faic_online_dot', 1), 1); ?>>
              Enable green online dot
            </label>
          </td>
        </tr>

      </table>
      <?php submit_button('Save Settings'); ?>
    </form>
  </div>
<?php }
