<?php

/**
 * Login Page for Inform plugin
 */

?>
<div>

  <h3>
    <span>
      <?php esc_html_e( 'Login with your NDN Control Room credentials. If you don\'t have an Inform Control Room login, contact your account manager ', 'ndn_admin' ); ?>
      <a href="mailto:wordpress@newsinc.com" title="plugin email address"><?php esc_html_e( 'or click here.', 'ndn_admin' ) ?></a>
    </span>
    </h3>
  <form name="ndn-plugin-login-form" action="" method="post" analytics-category="WPSettings" analytics-label="SettingsLogin" novalidate>

    <fieldset style="margin:10px 0;padding:0 12px;">
      <label for="<?php echo esc_attr( self::$login_form_options['ndn_username'] ) ?>">Username</label><br />
      <input style="min-width:400px;" type="text" value="" class="regular-text" name="username" /><br />
    </fieldset>

    <fieldset style="margin:10px 0;padding:0 12px;">
      <label for="<?php echo esc_attr( self::$login_form_options['ndn_password'] ) ?>">Password</label><br />
      <input style="min-width:400px;" type="password" value="" class="regular-text" name="password" /><br />
    </fieldset>

    <input type="hidden" name="redirect-login-submission" value="1" />
    <?php wp_nonce_field( 'ndn_setting_nonce_action', 'ndn_setting_nonce_field' ); ?>
    <input class="button-primary" type="submit" name="submit" style="margin: 10px 10px 10px 12px;" value="<?php echo esc_attr( 'Login' ); ?>" />
  </form>
</div>
