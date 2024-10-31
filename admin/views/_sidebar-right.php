<?php
/**
 * Render options right sidebar
 *
 * @package   S3_Secure_URL
 * @author    Max Kostinevich <hello@maxkostinevich.com>
 * @license   GPL-2.0+
 * @link      http://maxkostinevich.com
 * @copyright 2015 Max Kostinevich
 *
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
?>


<div id="postbox-container-1" class="postbox-container s3-secure-url-right-sidebar">
	<div class="meta-box-sortables">
		<div class="postbox">
			<h3><span><?php esc_attr_e('Get help','s3-secure-url');?></span></h3>
			<div class="inside">
				<div>
					<ul>
						<li><a class="no-underline" target="_blank" href="https://maxkostinevich.com/projects/s3-secure-url/"><span class="dashicons dashicons-admin-home"></span> <?php esc_attr_e('Plugin homepage','s3-secure-url');?></a></li>
						<li><a class="no-underline" target="_blank" href="https://maxkostinevich.com/support"><span class="dashicons dashicons-sos"></span> <?php esc_attr_e('Get support','s3-secure-url');?></a></li>
						<li><a class="no-underline" href="http://twitter.com/maxkostinevich" target="_blank" title="@MaxKostinevich"><span class="dashicons dashicons-twitter"></span> <?php esc_attr_e('Follow me on Twitter','s3-secure-url');?></a></li>
					</ul>
				</div>
				<div class="s3-secure-url-sidebar-footer">
					<div class="vstyler-copyright">
						<?php echo date ('Y');?> &copy; <a class="no-underline text-highlighted" href="https://maxkostinevich.com/" title="Max Kostinevich" target="_blank">Max Kostinevich</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>