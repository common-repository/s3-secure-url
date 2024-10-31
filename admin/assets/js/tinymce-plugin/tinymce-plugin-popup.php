<?php
/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");
?>


<?php
$awsAccessKey=get_option( 's3_secure_url_aws_access_key' );
$awsSecretKey=get_option( 's3_secure_url_aws_secret_key' );

if(!$awsAccessKey || !$awsSecretKey){
	die('Please enter your Amazon S3 credentials on the <a href="'.admin_url( 'options-general.php?page=' . $this->plugin_slug ).'">options page</a>');
}else {
	require dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/includes/S3.php';

	$s3Files=array(); // Store bucket names and bucket files in array

	$AwsS3Client = new S3( $awsAccessKey, $awsSecretKey );

	// Get all buckets
	$buckets = @$AwsS3Client->listBuckets();
	if(is_array($buckets)){
		foreach ($buckets as $bucket) {
			// Get all objects in bucket
			$bucketFiles=$AwsS3Client->getBucket($bucket);
			if(is_array($bucketFiles)){
				foreach($bucketFiles as $filename=>$fileinfo){
					// Get detailed info about object
					$info = $AwsS3Client->getObjectInfo($bucket, $filename);
					if(is_array($info)){
						//If object is not a folder and have a size>0 then add it to $s3Files array
						if($info['size'] > 0 && $info['type'] != 'binary/octet-stream') {
							$s3Files[$bucket][]=$filename;
						}
					}
				}
			}
		}
	}
}

if(empty ($s3Files)){
	die('It seems that your Amazon S3 doesn\'t have any files or check your Amazon S3 credentials on the <a href="'.admin_url( 'options-general.php?page=' . $this->plugin_slug ).'">options page</a>');
}

?>

<script type="text/javascript">
	// executes this when the DOM is ready
	jQuery(function(){

		function popup_insert_shortcode(){

			//default shortocode options
			var default_options = {
				'bucket' : '',
				'target' : '',
				'expires' : ''
			};

			// get form id
			var form_id = jQuery('#tinymce-plugin-popup-form');


			var shortcode = '[s3secureurl';
			var shortcode_close = '[/s3secureurl]';

			for(var key in default_options) {
				//get default value
				var val_default=default_options[key];
				//get value for same option from form
				var val_new = jQuery("[name='sc_attr_"+key+"']", form_id).val();
				if(key!='expires' && val_new==''){
					alert ('Please, fill in all required options');
					return false;
				}

				//if new value from form isn't the same as default value - insert it into shortcode
				if((val_new!='')&&(val_new!=val_default)){
					shortcode += ' ' + key + '="' + val_new + '"';
				}
			}

			var selected = tinyMCE.activeEditor.selection.getContent();
			var content = selected;

			if( selected ){
				//If text is selected when button is clicked
				//Wrap shortcode around it.
				shortcode += ']'; // close shortcode and add closing shortcode after content
				content = shortcode+content+shortcode_close;
			}else{
				shortcode += '/]';
				content =  shortcode;
			}



			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, content);

			// closes Thickbox
			tb_remove();
		}

		jQuery('#tinymce-plugin-popup-form-submit').bind('click',popup_insert_shortcode);


		var s3Files=<?php echo json_encode($s3Files);?>;
		jQuery('#sc_attr_bucket').on('change',function(){
			var bucketFiles='';
			var currentBucket=jQuery('#sc_attr_bucket').val();
			if(currentBucket==''){
				bucketFiles='Please select bucket name first';
			}else {
				jQuery.each(s3Files[currentBucket], function (index, filename) {
					bucketFiles += '<div class="radio-element-wrapper"><label><input type="radio" name="sc_attr_target" value="/' + filename + '"> /' + filename + '</label></div>';
				});
			}
			jQuery('#sc_attr_target_wrapper').html(bucketFiles);
		});
	});

</script>

<style>
	.tinymce-plugin-form{overflow:hidden!important;}
	.tinymce-plugin-form #TB_ajaxContent{overflow-y:scroll!important;width:100%!important;padding: 0px!important;}
	.tinymce-plugin-popup-inner{padding:0px 10px;}
	.tinymce-plugin-popup-form-wrapper{}
	.tinymce-plugin-popup-form-wrapper .fieldset-wrapper{margin-bottom:10px;}
	.tinymce-plugin-popup-form-wrapper label{line-height: 23px;}
	.tinymce-plugin-popup-form-wrapper label.simple{display:inline;float:none;}
	.tinymce-plugin-popup-form-wrapper textarea{resize:none;width:135px;height:80px;}
	.tinymce-plugin-popup-form-wrapper a{color:#3498DB !important;}
	.tinymce-plugin-popup-form-wrapper a:hover{color:#2980B9 !important;text-decoration: none !important;}
	.tinymce-plugin-popup-form-wrapper fieldset{padding:4px 9px 7px 9px;border:1px solid #BDC3C7;}
	.tinymce-plugin-popup-form-wrapper .field-row{margin:7px 0px;}
	.tinymce-plugin-popup-form-wrapper .field-help{font-size:0.8em}
	.tinymce-plugin-popup-form-wrapper .field-required{color:#E74C3C;}
	.tinymce-plugin-popup-form-wrapper .field-descr{font-size:0.9em}
	.tinymce-plugin-popup-form-wrapper .radio-group-wrapper{max-height: 200px;overflow: auto;padding:10px;background: #ECF0F1;}
	.tinymce-plugin-popup-form-wrapper .radio-group-wrapper .radio-element-wrapper{margin-bottom:5px;color: #34495E}
	.tinymce-plugin-popup-form-wrapper .radio-group-wrapper .radio-element-wrapper:hover{color: #7F8C8D}
</style>


<div id="tinymce-plugin-popup-wrapper">
	<div class="tinymce-plugin-popup-inner">
	  <h2>Insert Amazon S3 Secure URL</h2>
	  <div class="tinymce-plugin-popup-form-wrapper">
	    <form id="tinymce-plugin-popup-form">
	      <div class="fieldset-wrapper">
	          <fieldset>
	            <legend>Shortocde Options</legend>
		            <div class="field-row">
			            <label><span class="field-required">*</span> Bucket Name:<br>
				            <select id="sc_attr_bucket" name="sc_attr_bucket">
					            <option value="">Please select..</option>
					            <?php
					            $buckets = array_keys($s3Files);
					            foreach ($buckets as $bucket) {
						            ?><option value="<?php echo $bucket;?>"><?php echo $bucket;?></option>
					            <?php
					            }
					            ?>
				            </select>
			            </label>
			            <span class="field-help">Amazon S3 Bucket Name</span>
		            </div>
					<div class="field-row">
						<label><span class="field-required">*</span> Target File:</label><br>
						<div id="sc_attr_target_wrapper" class="radio-group-wrapper">
							Please select bucket name first
						</div>
					</div>
					<div class="field-row">
						<label>Expires in:<br>
						  <input name="sc_attr_expires" type="text" />
						</label>
						<span class="field-help">Time to expire in minutes, 5 minutes by default </span>
					</div>
	          </fieldset>
	      </div>
	      <div class="submit">
	        <input type="button" id="tinymce-plugin-popup-form-submit" class="button-primary" value="Insert Shortcode" name="submit" />
	      </div>
	    </form>
	  </div>
	</div>
</div>