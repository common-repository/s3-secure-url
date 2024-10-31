(function() {
    tinymce.create('tinymce.plugins.S3_Secure_URL', {


        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {

            ed.addCommand('s3_secure_url_cmd', function() {
                tb_show( 'Amazon S3 Secure URL', 'admin-ajax.php?action=s3_secure_url_load_popup&nonce='+s3_secure_url.ajax_nonce );
								//add class to thickbox for style scrollbars
								jQuery("#TB_window").addClass("tinymce-plugin-form");

            });


            ed.addButton('s3_secure_url', {
                title : 'Insert secure S3 link',
                cmd : 's3_secure_url_cmd',
                image : url + '/tinymce-plugin-btn.png'
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                    longname : 'S3 Secure URL',
                    author : 'Max Kostinevich',
                    authorurl : 'https://maxkostinevich.com',
                    infourl : 'http://wiki.moxiecode.com/',
                    version : "1.0.0"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('s3_secure_url', tinymce.plugins.S3_Secure_URL);

})();