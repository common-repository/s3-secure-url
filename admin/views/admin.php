<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   S3_Secure_URL
 * @author    Max Kostinevich <hello@maxkostinevich.com>
 * @license   GPL-2.0+
 * @link      http://maxkostinevich.com
 * @copyright 2015 Max Kostinevich
 */
?>

<?php
/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
?>

<div class="wrap s3-secure-url-admin-page">

	<h2><?php echo esc_html( get_admin_page_title() ); ?> v <?php echo get_option( 's3_secure_url_plugin_version' );?></h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable1">
					<div class="postbox">
						<div class="inside">
							<form action="options.php" method="POST">
								<?php settings_fields( 's3_secure_url_settings' ); ?>
								<?php do_settings_sections( 's3-secure-url' ); ?>
								<?php submit_button(); ?>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- end main content -->

			<!-- sidebar -->
			<?php  include_once( '_sidebar-right.php' );?>
			<!-- end sidebar -->

		</div>
		<!-- end post-body-->

		<br class="clear">
	</div>
	<!-- end poststuff -->

</div>


