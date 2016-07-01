<?php if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');} ?>

<?php if(MeprUtils::is_user_logged_in()): ?>

  <?php if(!isset($_GET['action']) || $_GET['action'] != 'mepr_unauthorized'): ?>
    <?php if(is_page($login_page_id) && isset($redirect_to) && !empty($redirect_to)): ?>
      <script type="text/javascript">
        window.location.href="<?php echo $redirect_to; ?>";
      </script>
    <?php endif; ?>
  <?php else: ?>
    <?php echo $message; ?>
  <?php endif; ?>

<?php else: ?>
  <?php echo $message; ?>
  <!-- mp-login-form-start --> <?php //DON'T GET RID OF THIS HTML COMMENT PLEASE IT'S USEFUL FOR SOME REGEX WE'RE DOING ?>
  <form name="mepr_loginform" id="mepr_loginform" class="mepr-form" action="<?php echo $login_url; ?>" method="post">
    <div class="mp-form-row mepr_username">
      <div class="mp-form-label">
        <?php /* <span class="cc-error"><?php _ex('Username Required', 'ui', 'memberpress'); ?></span> */ ?>
      </div>
      <input type="text" name="log" id="user_login" value="<?php echo (isset($_POST['log'])?$_POST['log']:''); ?>" />
    </div>
    <div class="mp-form-row mepr_password">
      <div class="mp-form-label">
        <?php /* <span class="cc-error"><?php _ex('Password Required', 'ui', 'memberpress'); ?></span> */ ?>
      </div>
      <input type="password" name="pwd" id="user_pass" value="<?php echo (isset($_POST['pwd'])?$_POST['pwd']:''); ?>" />
    </div>
    <div class="mp-spacer">&nbsp;</div>
    <div class="submit">
      <input type="submit" name="wp-submit" id="wp-submit" class="button-primary mepr-share-button " value="<?php _ex('Log In', 'ui', 'memberpress'); ?>" />
      <input type="hidden" name="redirect_to" value="<?php echo esc_html($redirect_to); ?>" />
      <input type="hidden" name="mepr_process_login_form" value="true" />
      <input type="hidden" name="mepr_is_login_page" value="<?php echo ($is_login_page)?'true':'false'; ?>" />
    </div>
  </form>
  <div class="mp-spacer">&nbsp;</div>
  <div class="mepr-login-actions">
    <a href="<?php echo $forgot_password_url; ?>"><?php _ex('Reset Password', 'ui', 'memberpress'); ?></a>
  </div>
  <!-- mp-login-form-end --> <?php //DON'T GET RID OF THIS HTML COMMENT PLEASE IT'S USEFUL FOR SOME REGEX WE'RE DOING ?>

<?php endif; ?>

