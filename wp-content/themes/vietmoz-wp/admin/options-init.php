<?php

/**
* Moztheme Options Config file.
 * */

if (!class_exists('moztheme_Redux_Framework_config')) {

    class moztheme_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field   set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h3>The compiler hook has run!</h3>';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            
              // Demo of how to use the dynamic CSS and write your own static CSS file
              // $filename = STYLESHEETPATH . '/dynamic' . '.css';
              // global $wp_filesystem;
              // if( empty( $wp_filesystem ) ) {
              //   require_once( ABSPATH .'/wp-admin/includes/file.php' );
              // WP_Filesystem();
              // }

              // if( $wp_filesystem ) {
              //   $wp_filesystem->put_contents(
              //       $filename,
              //       $css,
              //       FS_CHMOD_FILE // predefined mode settings for WP files
              //   );
              // }
             
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'moztheme-redux'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'moztheme-redux'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            $args['dev_mode'] = false;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
            *  Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'moztheme-redux'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                <?php echo STYLESHEETPATH; ?>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'moztheme-redux'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'moztheme-redux'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'moztheme-redux') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'moztheme-redux'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'icon'      => 'el-icon-cogs',
                'title'     => __('Cài đặt chung', 'moztheme-redux'),
                'fields'    => array(
                    array(
                        'id'        => 'opt_genera_enable_fb',
                        'type'      => 'checkbox',
                        'title'     => __('Kích hoạt mã Facebook', 'moztheme-redux'),
                        'subtitle'  => __('Mã này dùng cho facebook like, bình luận facebook.', 'moztheme-redux'),
                        //'desc'      => __('This is the description field, again good for additional info.', 'moztheme-redux'),
                        'default'   => '1'// 1 = on | 0 = off
                    ),
                    array(
                           'id' => 'section_favicon',
                           'type' => 'section',
                           'title' => __('Cài đặt favicon', 'moztheme-redux'),
                            'subtitle'  => __('Favicon là biểu tượng nhỏ được hiện thị cạnh tiêu để của website ở trên tab của trình duyệt.', 'moztheme-redux'),
                           'indent' => true 
                    ),
                    array(
                           'id' => 'opt_general_favicon',
                           'type' => 'media',
                           'title' => __('Tải lên Favicon', 'moztheme-redux'),
                           'subtitle'   => __('Upload favicon của bạn ở đây, ảnh phải là ảnh png có kích thước 128x128px', 'moztheme-redux'),
                    ),
                    array(
                           'id' => 'section_trackcode',
                           'type' => 'section',
                           'title' => __('Tracking Code, Additional JS', 'moztheme-redux'),
                           'indent' => true 
                    ),
                    array(
                        'id'        => 'opt_general_tracking',
                        'type'      => 'textarea',
                        'title'     => __('Tracking Code', 'moztheme-redux'),
                        'subtitle'  => __('Dán code Google Analytics hoặc tracking code khác của bạn vào đây.', 'moztheme-redux'),
                        'desc'      => 'Please put code inside scripts tags. Thank you!',
                    ),
                    array(
                        'id'        => 'opt_general_beforehead',
                        'type'      => 'textarea',
                        'title'     => __('Custom Code before &lt;/head&gt;', 'moztheme-redux'),
                        'subtitle'  => __('Add you code before &lt;/head&gt; tag.', 'moztheme-redux'),
                        'desc'      => 'Please put code inside scripts tags. Thank you!',
                    ),
                    array(
                        'id'        => 'opt_general_beforebody',
                        'type'      => 'textarea',
                        'title'     => __('Custom Code before &lt;/body&gt;', 'moztheme-redux'),
                        'subtitle'  => __('Add you code before &lt;/body&gt; tag.', 'moztheme-redux'),
                        'desc'      => 'Please put code inside scripts tags. Thank you!',
                    ),
                ),
            );

            // $this->sections[] = array(
            //     'icon'      => 'el-icon-user',
            //     'title'     => __('Thông tin liên hệ', 'moztheme-redux'),
            //     'fields'    => array(
            //         array(
            //             'id'       => 'opt_contact_holine',
            //             'type'     => 'multi_text',
            //             'title'    => __('Hotline', 'moztheme-redux'),
            //         ),
            //         array(
            //             'id'       => 'opt_contact_add',
            //             'type'     => 'text',
            //             'title'    => __('Địa chỉ', 'moztheme-redux'),
            //         ),
            //         array(
            //             'id'       => 'opt_contact_email',
            //             'type'     => 'text',
            //             'title'    => __('Email', 'moztheme-redux'),
            //             'validate' => 'email'
            //         ),
            //         array(
            //             'id'       => 'opt_contact_yahoo',
            //             'type'     => 'multi_text',
            //             'title'    => __('Yahoo', 'moztheme-redux'),
            //         ),

            //         array(
            //             'id'       => 'opt_contact_yahoo',
            //             'type'     => 'multi_text',
            //             'title'    => __('Skype', 'moztheme-redux'),
            //         ),

            //     ),
            // );

            $this->sections[] = array(
                'icon'      => 'el-icon-text-width',
                'title'     => __('Typography Settings', 'moztheme-redux'),
                'fields'    => array(
                    array(
                        'id'        => 'opt_font_type',
                        'type'      => 'select',
                        'title'    => __('Select Font Type', 'moztheme-redux'), 
                        'subtitle' => __('Google font/ Standard font or Custom font.', 'moztheme-redux'),
                        // Must provide key => value pairs for select options
                        'options'  => array(
                            '1' => 'Standard Font/ Google Font',
                            '2' => 'Custom Font'
                        ),
                        'default'  => '1',
                    ),
                    array(
                        'id'            => 'opt_typo_body',
                        'type'          => 'typography',
                        'title'         => __('Body', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'body', 'blockquote' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
                        'text-align'    => false,
                        //'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => false,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#444',
                            'font-family'   => 'Arial',
                            'font-size'     => '14px'
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_aside',
                        'type'          => 'typography',
                        'title'         => __('Aside text', 'moztheme-redux'),
                        'subtitle'      => __('Typography settings for sidebar text.', 'moztheme-redux'),
                        'output'      => array( '#secondary', '#territory' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
                        'text-align'    => false,
                        //'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => false,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#333',
                            // 'font-style'    => '400',
                            'font-size'     => '13px',
                            // 'line-height'   => '1'
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_footer',
                        'type'          => 'typography',
                        'title'         => __('Footer text', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( '#colophon' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => true,
                        'text-align'    => true,
                        //'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => false,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#c3c3c3',
                            // 'font-style'    => '400',
                            'font-size'     => '12px',
                            'text-align'    => 'left',
                            'line-height'   => '19px'
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_nav',
                        'type'          => 'typography',
                        'title'         => __('Navigation', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'nav .moztheme-nav a' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => true,
                        'text-align'    => true,
                        //'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'text-decoration'   => true,
                        'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#333',
                            'font-weight'   => '700',
                            'font-size'     => '12px',
                            'text-transform' => 'uppercase',
                            'line-height'   => '20px'
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_nav_sub',
                        'type'          => 'typography',
                        'title'         => __('Sub navigation', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'nav .moztheme-nav ul a' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => true,
                        'text-align'    => true,
                        //'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'text-decoration'   => true,
                        'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#333',
                            'font-weight'   => '700',
                            'font-size'     => '12px',
                            'line-height'   => '30px'
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_footer_nav',
                        'type'          => 'typography',
                        'title'         => __('Footer navigation', 'moztheme-redux'),
                        'subtitle'      => __('This option only works when footer navigation is activated.', 'moztheme-redux'),
                        'output'      => array( 'footer#colophon nav .moztheme-ft-nav a' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => true,
                        'text-align'    => true,
                        //'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'text-decoration'   => true,
                        'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#333',
                            'font-size'     => '14px'
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_heading',
                        'type'          => 'typography',
                        'title'         => __('Heading Font Family', 'moztheme-redux'),
                        'subtitle'      => __('This option let you choose font family for all heading, each heading can be set individually.', 'moztheme-redux'),
                        'output'      => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                        // 'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => false,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_h1',
                        'type'          => 'typography',
                        'title'         => __('Heading 1', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'h1', '.h1', 'h1.h1' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
                        'text-align'    => true,
                        // 'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'font-size'     => '24px',
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_h2',
                        'type'          => 'typography',
                        'title'         => __('Heading 2', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'h2', '.h2', 'h2.h2' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
                        'text-align'    => true,
                        // 'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'font-size'     => '20px',
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_h3',
                        'type'          => 'typography',
                        'title'         => __('Heading 3', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'h3', '.h3', 'h3.h3' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
                        'text-align'    => true,
                        // 'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'font-size'     => '16px',
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_h4',
                        'type'          => 'typography',
                        'title'         => __('Heading 4', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'h4', '.h4', 'h4.h4' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
                        'text-align'    => true,
                        // 'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'font-size'     => '15px',
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_h5',
                        'type'          => 'typography',
                        'title'         => __('Heading 5', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'h5', '.h5', 'h5.h5' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
                        'text-align'    => true,
                        // 'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'text-decoration'   => true,
                        'color'         => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'font-size'     => '14px',
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_h6',
                        'type'          => 'typography',
                        'title'         => __('Heading 6', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'h6', '.h6', 'h6.h6' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => false,
                        'text-align'    => true,
                        // 'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'font-size'     => '12px',
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_wg_title_sidebar',
                        'type'          => 'typography',
                        'title'         => __('Aside widget title', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( '.widget-area .widget-title', '.widget-area .widget-title a', '.entry-content .yarpp-related > *:first-child' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => true,
                        'text-align'    => true,
                        'word-spacing'  => true,  // Defaults to false
                        'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#333',
                            'font-weight'    => '700',
                            'font-size'     => '12px',
                            'text-transform' => 'uppercase'
                            ),
                    ),
                    array(
                        'id'            => 'opt_typo_wg_title_footer',
                        'type'          => 'typography',
                        'title'         => __('Footer widget title', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( 'footer .widget-title' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_font_type', '=', '1'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'line-height'   => true,
                        'text-align'    => true,
                        'word-spacing'  => true,  // Defaults to false
                        'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#fff',
                            'font-weight'    => '700',
                            'font-size'     => '12px',
                            'text-transform' => 'uppercase'
                            ),
                    ),
                    array(
                        'id'        => 'opt_typo_placeholder',
                        'type'      => 'typography',
                        'title'    => __('Form placeholder Typography', 'moztheme-redux'),
                        //'output'  => array( '::-webkit-input-placeholder', ':-moz-placeholder', '::-moz-placeholder', ':-ms-input-placeholder', ),
                        'google'        => false,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-family'   => false,
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
                        // 'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                        'word-spacing'  => false,  // Defaults to false
                        'letter-spacing'=> false,  // Defaults to false
                        'color'         => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => 'px', // Defaults to px
                        'default'       => array(
                            'color'         => '#ccc',
                            'font-style'    => '400',
                            'font-size'     => '14px'
                        ),
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-pause',
                'title'     => __('Layout Settings', 'moztheme-redux'),
                'fields'    => array(
                    array(
                           'id' => 'section_main_layout',
                           'type' => 'section',
                           'title' => __('Main layout Options', 'moztheme-redux'),
                           'indent' => true 
                    ),
                    // array(
                    //     'id'       => 'opt_main_width',
                    //     'type'     => 'dimensions',
                    //     'output' => array( '.container' ),
                    //     'units'    => array('px'),
                    //     'title'    => __('Main Content Width', 'moztheme-redux'),
                    //     'subtitle' => __('Set the specific pixel value for container width.', 'moztheme-redux'),
                    //     'desc'     => __('This field can\'t be set to 0. If you do not want use specific value, use inherit ).', 'moztheme-redux'),
                    //     'height'    => false,
                    //     'default'  => array(
                    //         'width'  => '960px'
                    //     ),
                    // ),
                    array(
                        'id'        => 'opt_main_layout',
                        'type'      => 'image_select',
                        'output'  => true,
                        'title'     => __('Main Layout', 'moztheme-redux'),
                        'subtitle'  => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'moztheme-redux'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle','img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'opt_category_layout',
                        'type'      => 'image_select',
                        'output'  => true,
                        'title'     => __('Category Layout', 'moztheme-redux'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle','img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'opt_single_layout',
                        'type'      => 'image_select',
                        'output'  => true,
                        'title'     => __('Single Post Layout', 'moztheme-redux'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle','img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'opt_product_category_layout',
                        'type'      => 'image_select',
                        'output'  => true,
                        'title'     => __('Product Category Layout', 'moztheme-redux'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle','img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'opt_product_single_layout',
                        'type'      => 'image_select',
                        'output'  => true,
                        'title'     => __('Single Product Layout', 'moztheme-redux'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle','img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'opt_col_width_1',
                        'required'  => array( 'opt_main_layout', '!=', '1' ),
                        'type'      => 'select',
                        'title'     => __('Sidebar 1 Column Width' , 'moztheme-redux'),
                        'subtitle'  => __('Select sidebar 1 width. Your website width is devided to 12 parts, choose width from 1 to 12.', 'moztheme-redux'),
                        'options'   => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9',
                            '10' => '10',
                            '11' => '11',
                            '12' => '12'
                        ),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'opt_col_width_2',
                        'required'  => array( 'opt_main_layout', '>=', '4' ),
                        'type'      => 'select',
                        'title'     => __('Sidebar 2 Column Width' , 'moztheme-redux'),
                        'subtitle'  => __('Select sidebar 2 width.', 'moztheme-redux'),
                        'options'   => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9',
                            '10' => '10',
                            '11' => '11',
                            '12' => '12'
                        ),
                        'default'   => '3'
                    ),
                    array(
                           'id' => 'section_footer_layout',
                           'type' => 'section',
                           'title' => __('Footer layout Options', 'moztheme-redux'),
                           'indent' => true 
                    ),
                    array(
                        'id'        => 'opt_footer_layout',
                        'type'      => 'image_select',
                        'output'  => true,
                        'title'     => __('Footer Layout', 'moztheme-redux'),
                        'subtitle'  => __('Select footer alignment. Choose between 1, 2, 3 or 4 column layout.', 'moztheme-redux'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column', 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column', 'img' => ReduxFramework::$_url . 'assets/img/2-col-ft.png'),
                            '3' => array('alt' => '3 Column', 'img' => ReduxFramework::$_url . 'assets/img/3-col-ft.png'),
                            '4' => array('alt' => '4 Column', 'img' => ReduxFramework::$_url . 'assets/img/4-col-ft.png')
                        ),
                        'default'   => '4'
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-css',
                'title'     => __('Styling options', 'moztheme-redux'),
                'fields'    => array(
                    // array(
                    //     'id'       => 'opt_presets',
                    //     'type'     => 'image_select', 
                    //     'presets'  => true,
                    //     'title'    => __('Preset', 'moztheme-redux'),
                    //     'subtitle' => __('This allows you to set a json string or array to override multiple preferences in your theme.', 'moztheme-redux'),
                    //     'default'  => 0,
                    //     'desc'     => __('This allows you to set a json string or array to override multiple preferences in your theme.', 'moztheme-redux'),
                    //     'options'  => array(
                    //         // Array of preset options
                    //         '1'      => array(
                    //             'alt'   => 'Preset 1', 
                    //             'img'   => ReduxFramework::$_url.'../sample/presets/preset1.png', 
                    //             'presets'   => array(
                    //                 'switch-on'     => 1,
                    //                 'switch-off'    => 1, 
                    //                 'switch-custom' => 1
                    //             )
                    //         ),
                    //         // JSON string of preset options
                    //         '2'       => array(
                    //             'alt'     => 'Preset 2', 
                    //             'img'     => ReduxFramework::$_url.'../sample/presets/preset2.png', 
                    //             'presets' => '{"slider1":"1", "slider2":"0", "switch-on":"0"}'
                    //         ),
                    //     ),
                    // ),
                    array(
                        'id'       => 'opt_style_custom_css',
                        'type'     => 'textarea',
                        'title'    => __('Custom CSS Code', 'redux-framework-demo'),
                        'subtitle' => __('Paste your CSS code here.', 'redux-framework-demo'),
                        'default'  => ".single .entry-content p {\ntext-align: justify;\n}"
                    ),
                    array(
                        'id'        => 'opt_body_bg',
                        'type'      => 'background',
                        'title'    => __('Body background', 'moztheme-redux'),
                        'output'  => array( 'body' ),
                    ),
                    // array(
                    //     'id'        => 'opt_container_bg',
                    //     'type'      => 'background',
                    //     'title'    => __('Container background', 'moztheme-redux'),
                    //     'output'  => array( '.container' ),
                    //     'default'   => array(
                    //         'background-color'  => '#fff'
                    //     ),
                    // ),
                    array(
                        'id'       => 'opt_body_link_color',
                        'type'     => 'link_color',
                        'title'    => __('Body Link Color Option', 'moztheme-redux'),
                        'output' => array('a'),
                        'default'  => array(
                            'regular'  => '#333', // blue
                            'hover'    => '#dd3333', // red
                            'active'   => '#333',  // purple
                            'visited'  => '#333'  // purple
                        ),
                    ),
                    array(
                        'id'       => 'opt_footer_link_color',
                        'type'     => 'link_color',
                        'title'    => __('Footer Link Color Option', 'moztheme-redux'),
                        'output' => array('footer#colophon a'),
                        'default'  => array(
                            'regular'  => '#c3c3c3', // blue
                            'hover'    => '#fff', // red
                            'active'   => '#c3c3c3',  // purple
                            'visited'  => '#c3c3c3'  // purple
                        ),
                    ),
                ),
            );
            $this->sections[] = array(
                'icon'      => 'el-icon-search',
                'title'     => __('Search Form Settings', 'moztheme-redux'),
                'fields'    => array(
                    array(
                        'id'       => 'opt_searchform_placeholder',
                        'type'     => 'text',
                        'title'    => __('Search form placeholder', 'moztheme-redux'),
                        'subtitle' => __('Enter your placeholder/default text form searchform.', 'moztheme-redux'),
                        'validate' => 'text',
                        'default'  => __('Enter your keyword..', 'moztheme-redux'),
                    ),
                    array(
                        'id'       => 'opt_searchform_submit_color',
                        'type'     => 'link_color',
                        'title'    => __('Search form submit icon Color', 'moztheme-redux'),
                        'output'   => array( '.search-form input[type="submit"]' ),
                        'default'  => array(
                            'regular'  => '#222', // blue
                            'hover'    => '#dd3333', // red
                            'active'   => '#222',  // purple
                            'visited'  => '#222'  // purple
                        ),
                    ),
                    array(
                        'id'        => 'opt_searchform_submit_bg',
                        'type'      => 'background',
                        'title'    => __('Searchform submit button background', 'moztheme-redux'),
                        'output'  => array( '.search-form input[type="submit"]' ),
                        'default' => array(
                            'background-color' => 'transparent'
                        ),
                    ),
                ),
            );
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => __('Header', 'moztheme-redux'),
                'fields'    => array(
                    array(
                        'id'        => 'opt_header_layout',
                        'type'      => 'image_select',
                        'output'  => true,
                        'title'     => __('Header Layout', 'moztheme-redux'),
                        'subtitle'  => __('Select your header.', 'moztheme-redux'),
                        'options'   => array(
                            '1' => array('img' => get_template_directory_uri() . '/framework/assets/img/header-v1.png'),
                            '3' => array('img' => get_template_directory_uri() . '/framework/assets/img/header-v3.png'),
                            '4' => array('img' => get_template_directory_uri() . '/framework/assets/img/header-v4.png'),
                        ),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'opt_header_bg_outermost',
                        'type'      => 'background',
                        'title'    => __('Header outermost background', 'moztheme-redux'),
                        'subtitle'  => __('Select background for whole header.', 'moztheme-redux'),
                        'output'  => array( 'header#masthead' ),
                    ),
                    array(
                        'id'        => 'opt_header_bg_inner',
                        'type'      => 'background',
                        'title'    => __('Header inner background', 'moztheme-redux'),
                        'subtitle'  => __('Select background for part of header that is inside the container.', 'moztheme-redux'),
                        'output'  => array( 'header#masthead > .container' ),
                    ),
                    array(
                        'id'        => 'opt_header_inner_padding',
                        'type'      => 'spacing',
                        'title'    => __('Header inner Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'left'      => false,
                        'right'     => false,
                        'output'  => array( 'header#masthead > .container' ),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-bottom'  => '0px', 
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_header_inner_border',
                        'required'  => array( 'opt_header_layout', '=', '3' ),
                        'type'      => 'border',
                        'title'     => __('Header Inner border', 'moztheme-redux'),
                        'output'  => array( '.header-v3 > .container' ), // An array of CSS selectors to apply this font style to
                        'all'       => false,
                        'default'   => array(
                            'border-color'  => '#eee', 
                            'border-style'  => 'solid', 
                            'border-top'    => '0px', 
                            'border-right'  => '0px', 
                            'border-bottom' => '1px', 
                            'border-left'   => '0px'
                        )
                    ),
                    array(
                        'id'        => 'opt_header_v4_banner',
                        'required'  => array( 'opt_header_layout', '=', '4' ),
                        'type'      => 'editor',
                        'title'     => __('Banner', 'moztheme-redux'),
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-tasks',
                'title'     => __('Top navigation', 'moztheme-redux'),
                'fields'    => array(
                    array(
                        'id'        => 'opt_topbar_background',
                        'type'      => 'background',
                        'title'    => __('Select Topbar Background', 'moztheme-redux'),
                        'output'  => array( '.topbar' ),
                    ),
                    array(
                        'id'        => 'opt_topbar_background_inner',
                        'type'      => 'background',
                        'title'    => __('Select Inner Topbar Background', 'moztheme-redux'),
                        'output'  => array( '.topbar .container' ),
                    ),
                    array(
                        'id'        => 'opt_topbar_menu_left',
                        'type'      => 'select',
                        'title'     => __('Topbar left menu', 'moztheme-redux'),
                        'data'      => 'menu'
                    ),
                    array(
                        'id'        => 'opt_topbar_menu_right',
                        'type'      => 'select',
                        'title'     => __('Topbar right menu', 'moztheme-redux'),
                        'data'      => 'menu'
                    ),
                    array(
                        'id'        => 'opt_topbar_margin',
                        'type'      => 'spacing',
                        'title'    => __('Topbar margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( '.topbar' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '0px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_topbar_link_typo',
                        'type'      => 'typography',
                        'title'    => __('Topbar Link Typography', 'moztheme-redux'),
                        'output'  => array( '.topbar .navbar-nav>li>a' ),
                        'google'        => false,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-family'   => false,
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
                        // 'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                        'word-spacing'  => false,  // Defaults to false
                        'letter-spacing'=> false,  // Defaults to false
                        'color'         => true,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => 'px', // Defaults to px
                        'default'       => array(
                            'color'         => '#f1f1f1',
                            'font-style'    => '400',
                            'font-size'     => '12px'),
                    ),
                    array(
                        'id'        => 'opt_topbar_link_padding',
                        'type'      => 'spacing',
                        'title'    => __('Topbar Link Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( '.topbar .navbar-nav>li>a' ),
                        'default'            => array(
                            'padding-top'     => '3px', 
                            'padding-right'   => '5px', 
                            'padding-bottom'  => '3px', 
                            'padding-left'    => '5px',
                            'units'          => 'px', 
                        )
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-picture',
                'title'     => __('Logo Settings', 'moztheme-redux'),
                'fields'    => array(
                    array(
                        'id'        => 'opt_logo_type',
                        'type'      => 'select',
                        'title'    => __('Select Logo Type', 'moztheme-redux'), 
                        'subtitle' => __('Logo can be text or image.', 'moztheme-redux'),
                        // Must provide key => value pairs for select options
                        'options'  => array(
                            '1' => 'Text',
                            '2' => 'Image',
                            '3' => 'Image & Text'
                        ),
                        'default'  => '2',
                    ),
                    array(
                        'id'        => 'opt_logo_img',
                        'type'      => 'media',
                        'required'  => array('opt_logo_type', '!=', '1'),
                        'url'       => true,
                        'title'     => __('Logo image', 'moztheme-redux'),
                        'output'  => true,
                        'subtitle'  => __('Upload your logo here', 'moztheme-redux'),
                        'default'   => array('url' => 'http://vietmoz.com/logo-small.png'),
                    ),
                    array(
                        'id'        => 'opt_logo_text',
                        'type'      => 'text',
                        'required'  => array('opt_logo_type', '!=', '2'),
                        'title'     => __('Logo text', 'moztheme-redux'),
                        'subtitle'  => __('Type your logo text here', 'moztheme-redux'),
                        'default'   => 'VietMoz'
                    ),
                    array(
                        'id'        => 'opt_logo_slogan',
                        'type'      => 'text',
                        'required'  => array('opt_logo_type', '=', '3'),
                        'title'     => __('Logo Slogan', 'moztheme-redux'),
                        'default'   => 'The very Awesome WordPress theme'
                    ),
                    array(
                        'id'            => 'opt_logo_text_typo',
                        'type'          => 'typography',
                        'subtitle'      => __('Style your Logo in your way.', 'moztheme-redux'),
                        'output'      => array( '.logo .text' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_logo_type', '!=', '2'),
                        'title'         => __('Logo text style', 'moztheme-redux'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        //'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                        //'word-spacing'  => true,  // Defaults to false
                        'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => 'px', // Defaults to px
                    ),
                    array(
                        'id'            => 'opt_logo_slogan_typo',
                        'type'          => 'typography',
                        'output'      => array( '.logo .slogan' ), // An array of CSS selectors to apply this font style to dynamically
                        'required'      => array('opt_logo_type', '=', '3'),
                        'title'         => __('Logo Slogan style', 'moztheme-redux'),
                        'google'        => true, //edited    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        //'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                        //'word-spacing'  => true,  // Defaults to false
                        'letter-spacing'=> true,  // Defaults to false
                        //'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => 'px', // Defaults to px
                    ),
                    array(
                        'id'        => 'opt_logo_padding',
                        'type'      => 'spacing',
                        'title'     => __('Logo padding', 'moztheme-redux'),
                        'subtitle'  => __('Adjust logo position in pixel.', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( '.logo', '.header-v3 #site-navigation' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '0px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_logo_brand_padding',
                        'type'      => 'spacing',
                        'required'  => array('opt_logo_type', '=', '3'),
                        'title'     => __('Logo Brand padding', 'moztheme-redux'),
                        'subtitle'  => __('Adjust logo brand position.', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( '.logo .brand' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '0px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                ),
            );

            $this->sections[] = array(
                'title'     => __('Navigation', 'moztheme-redux'),
                'icon'      => 'el-icon-tasks',
                'fields'    => array(
                    array(
                           'id' => 'section_nav_wrap',
                           'type' => 'section',
                           'title' => __('Navigation Wrapper Options', 'moztheme-redux'),
                           'indent' => true 
                    ),
                    array(
                        'id'        => 'opt_nav_bg_outermost',
                        'type'      => 'background',
                        'title'    => __('Navigation outermost background', 'moztheme-redux'),
                        'subtitle'  => __('Select background for whole nav.', 'moztheme-redux'),
                        'output'  => array( 'nav#site-navigation' ),
                    ),
                    array(
                        'id'        => 'opt_nav_outer_border',
                        'type'      => 'border',
                        'title'     => __('Navigation outermost border', 'moztheme-redux'),
                        'output'    => array( 'nav#site-navigation' ), // An array of CSS selectors to apply this font style to
                        'all'       => false,
                        'default'   => array(
                            'border-color'  => '#fff', 
                            'border-style'  => 'solid', 
                            'border-top'    => '0px', 
                            'border-right'  => '0px', 
                            'border-bottom' => '0px', 
                            'border-left'   => '0px'
                        )
                    ),
                    array(
                        'id'        => 'opt_nav_bg_inner',
                        'type'      => 'background',
                        'title'    => __('Navigation inner background', 'moztheme-redux'),
                        'subtitle'  => __('Select background for part of nav that is inside the container.', 'moztheme-redux'),
                        'output'  => array( 'nav#site-navigation > .container .navinside' ),
                    ),
                    array(
                        'id'        => 'opt_nav_inner_border',
                        'type'      => 'border',
                        'title'     => __('Navigation inner border', 'moztheme-redux'),
                        'output'    => array( 'nav#site-navigation > .container #main-nav' ), // An array of CSS selectors to apply this font style to
                        'all'       => false,
                        'default'   => array(
                            'border-color'  => '#B6B6B6', 
                            'border-style'  => 'solid', 
                            'border-top'    => '1px', 
                            'border-right'  => '0px', 
                            'border-bottom' => '1px', 
                            'border-left'   => '0px'
                        )
                    ),
                    array(
                        'id'        => 'opt_nav_margin',
                        'type'      => 'spacing',
                        'title'    => __('Navigation Margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( 'nav#site-navigation' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '0px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_nav_padding',
                        'type'      => 'spacing',
                        'title'    => __('Navigation Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( 'nav#site-navigation > .container > .navinside' ),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-right'   => '0px', 
                            'padding-bottom'  => '0px', 
                            'padding-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                           'id' => 'section_nav_link',
                           'type' => 'section',
                           'title' => __('Navigation Link Options', 'moztheme-redux'),
                           'indent' => true 
                    ),
                    array(
                        'id'        => 'opt_nav_link_bg',
                        'type'      => 'background',
                        'background-size'   => false,
                        'background-position' => false,
                        'background-attachment' => false,
                        'background-repeat' => false,
                        'background-image'  => false,
                        'preview'   => false,
                        'title'    => __('Navigation Link Background', 'moztheme-redux'),
                        'output'  => array( '.moztheme-nav li a' ),
                    ),
                    array(
                        'id'        => 'opt_nav_link_hover_bg',
                        'type'      => 'background',
                        'background-size'   => false,
                        'background-position' => false,
                        'background-attachment' => false,
                        'background-image'  => false,
                        'preview'   => false,
                        'background-repeat' => false,
                        'title'    => __('Navigation Link Hover Background', 'moztheme-redux'),
                        'output'  => array( '.moztheme-nav li a:hover', '.nav> i a:focus', '.nav>li.current-menu-item>a', '.nav .open>a', '.nav .open>a:hover', '.nav .open>a:focus', '.nav>li>a:focus' ),
                        'default'   => array(
                            'background-color'  =>  'transparent'
                        ),
                    ),
                    array(
                        'id'       => 'opt_nav_link_color',
                        'type'     => 'link_color',
                        'title'    => __('Navigation Link Color Option', 'moztheme-redux'),
                        'output' => array('.moztheme-nav a'),
                        'default'  => array(
                            'regular'  => '#333',
                            'hover'    => '#dd3333',
                            'active'   => '#333',
                            'visited'  => '#333'
                        ),
                    ),
                    array(
                        'id'        => 'opt_subnav_link_bg',
                        'type'      => 'background',
                        'background-size'   => false,
                        'background-position' => false,
                        'background-attachment' => false,
                        'background-repeat' => false,
                        'background-image'  => false,
                        'preview'   => false,
                        'title'    => __('Sub Navigation Link Background', 'moztheme-redux'),
                        'output'  => array( '.moztheme-nav ul li a', '.moztheme-nav ul li.current-menu-item>a', '.moztheme-nav ul li.current-menu-item:hover>a', '.dropdown-menu' ),
                    ),
                    array(
                        'id'        => 'opt_subnav_link_hover_bg',
                        'type'      => 'background',
                        'background-size'   => false,
                        'background-position' => false,
                        'background-attachment' => false,
                        'background-repeat' => false,
                        'background-image'  => false,
                        'preview'   => false,
                        'title'    => __('Sub Navigation Link Hover Background', 'moztheme-redux'),
                        'output'  => array( '.moztheme-nav ul li a:hover', '.moztheme-nav ul li a:focus', '.moztheme-nav ul li.current-menu-item:hover>a' ),
                        'default'   => array(
                            'background-color'  =>  'transparent'
                        ),
                    ),
                    array(
                        'id'       => 'opt_nav_sub_link_color',
                        'type'     => 'link_color',
                        'title'    => __('Sub Navigation Link Color Option', 'moztheme-redux'),
                        'output' => array('nav .dropdown-menu a', '.dropdown-menu>.active>a'),
                        'default'  => array(
                            'regular'  => '#333',
                            'hover'    => '#dd3333',
                            'active'   => '#333',
                            'visited'  => '#333'
                        ),
                    ),
                    array(
                        'id'        => 'opt_nav_link_margin',
                        'type'      => 'spacing',
                        'title'    => __('Navigation Link Margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( 'nav#site-navigation .moztheme-nav>li>a' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '0px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_nav_link_li_padding',
                        'type'      => 'spacing',
                        'title'    => __('Navigation Link li Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( 'nav#site-navigation .moztheme-nav>li' ),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-right'   => '0px', 
                            'padding-bottom'  => '0px', 
                            'padding-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_nav_link_padding',
                        'type'      => 'spacing',
                        'title'    => __('Navigation Link Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( 'nav#site-navigation .moztheme-nav>li>a' ),
                        'top'  => false,
                        'bottom' => false,
                        'default'            => array(
                            'padding-top'     => '10px', 
                            'padding-right'   => '25px', 
                            'padding-bottom'  => '10px', 
                            'padding-left'    => '25px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_nav_link_border',
                        'type'      => 'border',
                        'title'     => __('Navigation Link border', 'moztheme-redux'),
                        'subtitle'  => __('Often used for separating nav item', 'moztheme-redux'),
                        'output'    => array( 'nav#site-navigation .moztheme-nav>li>a' ), // An array of CSS selectors to apply this font style to
                        'all'       => false,
                        'default'   => array(
                            'border-color'  => '#1e73be', 
                            'border-style'  => 'solid', 
                            'border-top'    => '0px', 
                            'border-right'  => '0px', 
                            'border-bottom' => '0px', 
                            'border-left'   => '0px'
                        )
                    ),
                ),
            );


            $this->sections[] = array(
                'title'     => __('Cài đặt chuyên mục', 'moztheme-redux'),
                'icon'      => 'el-icon-list',
                'fields'    => array(
                    array(
                        'id'        => 'opt_cat_show_type',
                        'type'      => 'select',
                        'title'     => __('Hiển thị tin', 'moztheme-redux'),
                        'subtitle'  => __('Chọn phong cách hiển thị tin bài ở chuyên mục.', 'moztheme-redux'),
                        'options'  => array(
                            '1' => 'Dạng danh sách',
                            '2' => 'Hai cột',
                        ),
                        'default'  => '1',
                    ),
                ),
            );

            $this->sections[] = array(
                'title'     => __('Sidebar', 'moztheme-redux'),
                'icon'      => 'el-icon-list',
                'fields'    => array(
                    array(
                        'id'        => 'opt_aside_wg_show',
                        'type'      => 'checkbox',
                        'title'     => __('Hiển thị sidebar trên mobile', 'moztheme-redux'),
                        'subtitle'  => __('Tích chọn để hiển thị sidebar trên mobile, mặc định trên mobile sidebar sẽ bị ẩn.', 'moztheme-redux'),
                        'default'   => '0'// 1 = on | 0 = off
                    ),
                    array(
                        'id'        => 'opt_aside_wg_bg',
                        'type'      => 'background',
                        'title'    => __('Aside widget background', 'moztheme-redux'),
                        'output'  => array( '.widget-area aside' ),
                        'default' => array(
                            'background-color' => '#fff'
                        ),
                    ),
                    array(
                        'id'        => 'opt_aside_wg_border',
                        'type'      => 'border',
                        'title'     => __('Aside widget border', 'moztheme-redux'),
                        'output'    => array( '.widget-area aside' ), // An array of CSS selectors to apply this font style to
                        'all'       => false,
                        'default'   => array(
                            'border-color'  => '#fff', 
                            'border-style'  => 'none', 
                            'border-top'    => '0px', 
                            'border-right'  => '0px', 
                            'border-bottom' => '0px', 
                            'border-left'   => '0px'
                        )
                    ),
                    array(
                        'id'        => 'opt_aside_wg_margin',
                        'type'      => 'spacing',
                        'title'    => __('Aside Widget Margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( '.widget-area aside' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '20px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_aside_wg_title_bg',
                        'type'      => 'background',
                        'title'    => __('Aside widget title background', 'moztheme-redux'),
                        'output'  => array( '.widget-area aside .widget-title', '.entry-content .yarpp-related > *:first-child' ),
                    ),
                    array(
                        'id'        => 'opt_aside_wg_title_margin',
                        'type'      => 'spacing',
                        'title'    => __('Aside Widget Title Margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( '.widget-area aside .widget-title' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '10px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_aside_wg_title_padding',
                        'type'      => 'spacing',
                        'title'    => __('Aside Widget Title Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( '.widget-area aside .widget-title' ),
                        'default'            => array(
                            'padding-top'     => '5px', 
                            'padding-right'   => '0px', 
                            'padding-bottom'  => '5px', 
                            'padding-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_aside_wg_title_border',
                        'type'      => 'border',
                        'title'     => __('Aside Widget Title Border', 'moztheme-redux'),
                        'output'  => array( '.widget-area aside .widget-title' ),
                        'all'       => false,
                        'default'   => array(
                            'border-color'  => '#c2c2c2', 
                            'border-style'  => 'solid', 
                            'border-top'    => '0px', 
                            'border-right'  => '0px', 
                            'border-bottom' => '1px', 
                            'border-left'   => '0px'
                        )
                    ),
                ),
            );

            $this->sections[] = array(
                'title'     => __('Footer', 'moztheme-redux'),
                'icon'      => 'el-icon-adjust-alt',
                'fields'    => array(
                    array(
                        'id'        => 'opt_footer_bg',
                        'type'      => 'background',
                        'title'    => __('Footer background', 'moztheme-redux'),
                        'output'  => array( 'footer#colophon' ),
                        'default' => array(
                            'background-color' => '#4f4f4f'
                        ),
                    ),
                    array(
                        'id'        => 'opt_footer_inner_bg',
                        'type'      => 'background',
                        'title'    => __('Footer inner background', 'moztheme-redux'),
                        'output'  => array( 'footer#colophon .container .inside' ),
                        'default' => array(
                            'background-color' => '#4f4f4f'
                        ),
                    ),
                    array(
                        'id'        => 'opt_footer_margin',
                        'type'      => 'spacing',
                        'title'    => __('Footer Margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( 'footer#colophon' ),
                        'left'      => false,
                        'right'     => false,
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-bottom'  => '0px', 
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_footer_padding',
                        'type'      => 'spacing',
                        'title'    => __('Footer Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'left'      => false,
                        'right'     => false,
                        'output'  => array( 'footer#colophon' ),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-bottom'  => '0px', 
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_footer_padding_inner',
                        'type'      => 'spacing',
                        'title'    => __('Footer Inner Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'left'      => false,
                        'right'     => false,
                        'output'  => array( 'footer#colophon > .container .inside' ),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-bottom'  => '0px', 
                            'units'          => 'px', 
                        )
                    ),
                    array(
                       'id'        => 'section_footer_widget',
                       'type' => 'section',
                       'title' => __('Footer Widget Options', 'moztheme-redux'),
                       'indent' => true 
                    ),
                    array(
                        'id'        => 'opt_footer_wg_padding',
                        'type'      => 'spacing',
                        'title'    => __('Footer Widget Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( 'footer#colophon .ft-widget' ),
                    ),
                    array(
                        'id'        => 'opt_footer_wg_bg',
                        'type'      => 'background',
                        'title'    => __('Footer widget background', 'moztheme-redux'),
                        'output'  => array( 'footer .ft-widget' ),
                    ),
                    array(
                        'id'        => 'opt_footer_wg_title_bg',
                        'type'      => 'background',
                        'title'    => __('Footer widget title background', 'moztheme-redux'),
                        'output'  => array( 'footer#colophon .widget-title' ),
                    ),
                    array(
                        'id'        => 'opt_footer_wg_title_margin',
                        'type'      => 'spacing',
                        'title'    => __('Footer Widget Title Margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( 'footer#colophon .widget-title' ),
                        'left'      => false,
                        'right'     => false,
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-bottom'  => '10px', 
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_footer_wg_title_padding',
                        'type'      => 'spacing',
                        'title'    => __('Footer Widget Title Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( 'footer#colophon .widget-title' ),
                        'default'            => array(
                            'padding-top'     => '40px', 
                            'padding-right'   => '0px', 
                            'padding-bottom'  => '10px', 
                            'padding-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    // array(
                    //     'id'        => 'opt_footer_wg_title_border',
                    //     'type'      => 'border',
                    //     'title'     => __('Footer Widget Title Border', 'moztheme-redux'),
                    //     'output'  => array( 'footer#colophon .widget-title' ),
                    //     'all'       => false,
                    //     'default'   => array(
                    //         'border-color'  => '#737373', 
                    //         'border-style'  => 'solid', 
                    //         'border-top'    => '0px', 
                    //         'border-right'  => '0px', 
                    //         'border-bottom' => '1px', 
                    //         'border-left'   => '0px'
                    //     )
                    // ),
                    array(
                       'id'        => 'section_footer_nav',
                       'type' => 'section',
                       'title' => __('Footer Navigation Options', 'moztheme-redux'),
                       'indent' => true 
                    ),
                    array(
                        'id'        => 'opt_footer_nav_check',
                        'type'      => 'checkbox',
                        'title'     => __('Active footer navigation?', 'moztheme-redux'),
                        'subtitle'  => __('Check this box to place a menu at top of Footer section.', 'moztheme-redux'),
                        // 'desc'      => __('This is the description field, again good for additional info.', 'moztheme-redux'),
                        'default'   => '0'// 1 = on | 0 = off
                    ),
                    array(
                        'id'        => 'opt_footer_nav_select',
                        'required'   => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'select',
                        'data'      => 'menus',
                        'title'     => __('Footer Menu select', 'moztheme-redux'),
                    ),
                    array(
                       'id' => 'section_footer_nav_wrap',
                       'required'   => array( 'opt_footer_nav_check', '=', '1' ),
                       'type' => 'section',
                       'title' => __('Navigation Wrapper Options', 'moztheme-redux'),
                       'indent' => true 
                    ),
                    array(
                        'id'        => 'opt_footer_nav_bg_outermost',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'background',
                        'title'    => __('Navigation outermost background', 'moztheme-redux'),
                        'subtitle'  => __('Select background for whole nav.', 'moztheme-redux'),
                        'output'  => array( 'footer#colophon nav#footer-navigation' ),
                    ),
                    array(
                        'id'        => 'opt_footer_nav_bg_inner',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'background',
                        'title'    => __('Navigation inner background', 'moztheme-redux'),
                        'subtitle'  => __('Select background for part of nav that is inside the container.', 'moztheme-redux'),
                        'output'  => array( 'nav#footer-navigation > .container' ),
                    ),
                    array(
                        'id'        => 'opt_footer_nav_margin',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'spacing',
                        'title'    => __('Navigation Margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( 'footer#colophon nav#footer-navigation' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '0px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_footer_nav_padding',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'spacing',
                        'title'    => __('Navigation Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( 'footer#colophon nav#footer-navigation' ),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-right'   => '0px', 
                            'padding-bottom'  => '0px', 
                            'padding-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_footer_nav_padding_inner',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'spacing',
                        'title'    => __('Navigation Inner Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'left'      => false,
                        'right'     => false,
                        'output'  => array( 'footer#colophon nav#footer-navigation > .container' ),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-bottom'  => '0px', 
                            'units'          => 'px', 
                        )
                    ),
                    array(
                           'id' => 'section_footer_nav_link',
                           'required'   => array( 'opt_footer_nav_check', '=', '1' ),
                           'type' => 'section',
                           'title' => __('Navigation Link Options', 'moztheme-redux'),
                           'indent' => true 
                    ),
                    array(
                        'id'        => 'opt_footer_nav_link_bg',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'background',
                        'title'    => __('Navigation Link Background', 'moztheme-redux'),
                        'output'  => array( 'footer#colophon .nav>li>a' ),
                    ),
                    array(
                        'id'        => 'opt_footer_nav_link_hover_bg',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'background',
                        'title'    => __('Navigation Link Hover Background', 'moztheme-redux'),
                        'output'  => array( 'footer#colophon .nav>li>a:hover', 'footer#colophon .nav>li>a:focus' ),
                    ),
                    array(
                        'id'       => 'opt_footer_nav_link_color',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'     => 'link_color',
                        'title'    => __('Navigation Link Color Option', 'moztheme-redux'),
                        'output' => array( 'footer#colophon nav a' ),
                        'default'  => array(
                            'regular'  => '#1e73be', // blue
                            'hover'    => '#dd3333', // red
                            'active'   => '#8224e3',  // purple
                            'visited'  => '#8224e3'  // purple
                        ),
                    ),
                    array(
                        'id'        => 'opt_footer_nav_link_margin',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'spacing',
                        'title'    => __('Navigation Link Margin', 'moztheme-redux'),
                        'mode'      => 'margin',
                        'units'     => 'px',
                        'output'  => array( 'footer#colophon .moztheme-ft-nav>li>a' ),
                        'default'            => array(
                            'margin-top'     => '0px', 
                            'margin-right'   => '0px', 
                            'margin-bottom'  => '0px', 
                            'margin-left'    => '0px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_footer_nav_link_padding',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'spacing',
                        'title'    => __('Navigation Link Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'output'  => array( 'footer#colophon .moztheme-ft-nav>li>a' ),
                        'default'            => array(
                            'padding-top'     => '5px', 
                            'padding-right'   => '5px', 
                            'padding-bottom'  => '5px', 
                            'padding-left'    => '5px',
                            'units'          => 'px', 
                        )
                    ),
                    array(
                        'id'        => 'opt_footer_nav_link_border',
                        'required'  => array( 'opt_footer_nav_check', '=', '1' ),
                        'type'      => 'border',
                        'title'     => __('Navigation Link border', 'moztheme-redux'),
                        'subtitle'  => __('Often used for separating nav item', 'moztheme-redux'),
                        'output'  => array( 'footer#colophon .moztheme-ft-nav>li>a' ), // An array of CSS selectors to apply this font style to
                        'all'       => false,
                        'default'   => array(
                            'border-color'  => '#1e73be', 
                            'border-style'  => 'solid', 
                            'border-top'    => '0px', 
                            'border-right'  => '1px', 
                            'border-bottom' => '0px', 
                            'border-left'   => '0px'
                        )
                    ),
                ),
            );
            $this->sections[] = array(
                'title'     => __('Site Information', 'moztheme-redux'),
                'icon'      => 'el-icon-website',
                'fields'    => array(
                    array(
                        'id'        => 'opt_siteinfo_bg',
                        'type'      => 'background',
                        'title'    => __('Site Info background', 'moztheme-redux'),
                        'output'  => array( '.site-info' ),
                        'default'   => array(
                            'background-color' => '#3B3B3B'
                        ),
                    ),
                    array(
                        'id'        => 'opt_siteinfo_inner_bg',
                        'type'      => 'background',
                        'title'    => __('Site Info inner background', 'moztheme-redux'),
                        'output'  => array( '.site-info .container .inside' ),
                        'default'   => array(
                            'background-color' => '#3B3B3B'
                        ),
                    ),
                    array(
                        'id'            => 'opt_site_info_typo',
                        'type'          => 'typography',
                        'title'         => __('Site Info text', 'moztheme-redux'),
                        // 'subtitle'      => __('General typography setting.', 'moztheme-redux'),
                        'output'      => array( '.site-info', '.site-info a' ), // An array of CSS selectors to apply this font style to dynamically
                        'font-family'   => false,
                        'google'        => false,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                        'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size'     => true,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'line-height'   => false,
                        'text-align'    => true,
                        //'word-spacing'  => true,  // Defaults to false
                        // 'letter-spacing'=> true,  // Defaults to false
                        'color'         => true,
                        'text-decoration'   => false,
                        'preview'       => false, // Disable the previewer
                        'text-transform'    => true,
                        'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
                        // 'units'         => array('em','px'), // Defaults to px
                        'default'       => array(
                            'color'         => '#999',
                            'font-size'     => '12px'
                            ),
                    ),
                    array(
                        'id'        => 'opt_siteinfo_padding',
                        'type'      => 'spacing',
                        'title'    => __('Site Info Padding', 'moztheme-redux'),
                        'mode'      => 'padding',
                        'units'     => 'px',
                        'left'      => false,
                        'right'     => false,
                        'output'  => array( '.site-info .container .inside' ),
                        'default'            => array(
                            'padding-top'     => '10px', 
                            'padding-bottom'  => '10px', 
                            'units'          => 'px', 
                        )
                    ),
                ),
            );

            $this->sections[] = array(
                'title'     => __('Cài đặt Slider', 'moztheme-redux'),
                'icon'      => 'el-icon-camera',
                'fields'    => array(
                    array(
                        'id'        => 'opt_home_slides_check',
                        'type'      => 'checkbox',
                        'title'     => __('Enable Home Slider', 'moztheme-redux'),
                        'default'   => '0',// 1 = on | 0 = off
                    ),
                    array(
                        'id'        => 'opt_home_slides',
                        'required'  => array( 'opt_home_slides_check', '=', '1' ),
                        'type'      => 'slides',
                        'title'     => __('Slides Options', 'moztheme-redux'),
                        'placeholder'   => array(
                            'title'         => __('This is a title', 'moztheme-redux'),
                            'description'   => __('Description Here', 'moztheme-redux'),
                            'url'           => __('Give us a link!', 'moztheme-redux'),
                        ),
                    ),
                    array(
                        'id'        => 'opt_home_brand_slides_check',
                        'type'      => 'checkbox',
                        'title'     => __('Enable Brand Slider', 'moztheme-redux'),
                        'subtitle'  => __('Brand slider is often used for fashion or spa website.', 'moztheme-redux'),
                        'desc'      => __('Please use photos width same size and format, background color..', 'moztheme-redux'),
                        'default'   => '0',// 1 = on | 0 = off
                    ),
                    array(
                        'id'        => 'opt_home_brand_slides_to_show',
                        'required'  => array( 'opt_home_brand_slides_check', '=', '1' ),
                        'type'      => 'select',
                        'title'    => __('Slide to show', 'moztheme-redux'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9',
                            '10' => '10'
                        ),
                        'default'  => '1',
                    ),
                    array(
                        'id'        => 'opt_home_brand_slides',
                        'required'  => array( 'opt_home_brand_slides_check', '=', '1' ),
                        'type'      => 'slides',
                        'title'     => __('Brand Slides Options', 'moztheme-redux'),
                        'subtitle'  => __('Brand slider appears at very top ob footer section.', 'moztheme-redux'),
                        'placeholder'   => array(
                            'title'         => __('This is a title', 'moztheme-redux'),
                            'description'   => __('Description Here', 'moztheme-redux'),
                            'url'           => __('Give us a link!', 'moztheme-redux'),
                        ),
                    ),
                ),
            );

            $this->sections[] = array(
                'title'     => __('Ads Options', 'moztheme-redux'),
                'icon'      => 'el-icon-picture',
                'fields'    => array(
                    array(
                        'id'        => 'opt_ads_floating',
                        'type'      => 'checkbox',
                        'title'     => __('Enable Floating Ads', 'moztheme-redux'),
                        'default'   => '0',// 1 = on | 0 = off
                    ),
                    array(
                        'id'        => 'opt_ads_floating_left_ad',
                        'required'  => array( 'opt_ads_floating', '=', '1' ),
                        'type'      => 'editor',
                        //'url'       => true,
                        'title'     => __('Floating Left Ad', 'moztheme-redux'),
                        'output'  => true,
                    ),
                    array(
                        'id'        => 'opt_ads_floating_right_ad',
                        'required'  => array( 'opt_ads_floating', '=', '1' ),
                        'type'      => 'editor',
                        //'url'       => true,
                        'title'     => __('Floating Right Ad', 'moztheme-redux'),
                        'output'  => true,
                    ),
                ),
            );
            $this->sections[] = array(
                'title' => __('Thiết lập web bán hàng', 'mozchild'),
                'icon' => 'el-icon-shopping-cart-sign',
                'fields' => array(
                    array(
                        'id'        => 'opt_banhang_home_desc',
                        'title'      => __('Mô tả trang chủ', 'moztheme-redux'),
                        'subtitle'  => __('Dùng phần này để thêm nội dung, text, mô tả, hình ảnh bạn muốn vào trước danh sách sản phẩm ở trang chủ.'),
                        'type'      => 'section',
                        'indent'    => true,
                    ),
                    array(
                        'title'     => __('Tiêu đề', 'moztheme-redux'),
                        'id'        => 'opt_banhang_home_desc_title',
                        'type'      => 'text',
                    ),
                    array(
                        'title'     => __('Link cho tiêu đề', 'moztheme-redux'),
                        'id'        => 'opt_banhang_home_desc_url',
                        'type'      => 'text',
                    ),
                    array(
                        'title'     => __('Màu nền tiêu đề', 'moztheme-redux'),
                        'id'        => 'opt_banhang_home_desc_color',
                        'type'      => 'color',
                    ),
                    array(
                        'title'     => __('Mô tả', 'moztheme-redux'),
                        'id'        => 'opt_banhang_home_desc_desc',
                        'type'      => 'editor',
                    ),
                    array(
                        'id'        => 'opt_banhang_home_desc_img',
                        'title'      => __('Ảnh đại diện', 'moztheme-redux'),
                        'type'      => 'media',
                    ),
                    array(
                        'id'        => 'opt_banhang_home_desc_end',
                        'type'      => 'section',
                        'indent'    => false,
                    ),
                    array(
                        'id'        => 'opt_banhang_home_tax',
                        'title'      => __('Cài đặt sản phẩm trang chủ', 'moztheme-redux'),
                        'type'      => 'section',
                        'indent'    => true,
                    ),
                    array(
                        'title' => __('Chọn chuyên mục cho trang chủ', 'moztheme-redux'),

                        'subtitle'  => __('Kéo thả chuyên mục cần hiển thị ra trang chủ, có thể sắp xếp thứ tự các chuyên mục tương ứng.', 'moztheme-redux'),
                        'type'      => 'select',
                        'id'        => 'opt_banhang_home_taxs',
                        'data'      => 'terms',
                        'args'      => array(
                            'taxonomies'    => 'product_cat',
                            'args'          => array(),
                            ),
                        'multi'     => true,
                        'sortable'  => true,
                    ),
                    array(
                        'title' => __('Số sản phẩm một chuyên mục', 'moztheme-redux' ),
                        'type'  => 'text',
                        'id'    => 'opt_banhang_pro_total',
                        'validate'  => 'numeric',
                        'default'   => 10,
                    ),
                    array(
                        'title' => __('Số sản phẩm một hàng', 'moztheme-redux' ),
                        'type'  => 'text',
                        'id'    => 'opt_banhang_column',
                        'validate'  => 'numeric',
                        'default'   => 5,
                    ),
                    array(
                        'title' => __('Thay thế text Mô tả sản phẩm', 'moztheme-redux' ),
                        'subtitle'  => __('Bạn có thể thay đổi cụm từ "Mô tả sản phẩm" bằng từ khách nếu muốn'),
                        'type'  => 'text',
                        'id'    => 'opt_banhang_detail_tab_text',
                        'default'   => 'Mô tả sản phẩm',
                    ),
                    array(
                        'id'        => 'opt_banhang_home_tax_end',
                        'type'      => 'section',
                        'indent'    => false,
                    ),
                    array(
                        'id'        => 'opt_banhang_sku_show',
                        'type'      => 'checkbox',
                        'subtitle'  => __('Chọn để hiển thị mã sản phẩm tại trang chi tiết sản phẩm', 'moztheme-redux'),
                        'title'     => __('Hiển thị mã sản phẩm', 'moztheme-redux'),
                        'default'   => '1'// 1 = on | 0 = off
                    ),
                )
            );
            $this->sections[] = array(
                'title' => __('Thiết lập web giới thiệu', 'mozchild'),
                // 'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'mozchild'),
                // Redux ships with the glyphicons free icon pack, included in the options folder.
                // Feel free to use them, add your own icons, or leave this blank for the default.
                'icon' => 'el-icon-briefcase',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array(
                    array(
                        'title' => __('Chọn phong cách dịch vụ nổi bật', 'mozchild'),
                        'subtitle'  => __('Dịch vụ nổi bật là phần ở dưới slide trang chủ, được chi thành cột, có thể sử dụng để giới thiệu những dịch vụ chính của website, hoặc để giới thiệu những điểm đặc biệt, độc đáo của công ty.', 'mozchild'),
                        'type'      => 'select',
                        'id'        => 'opt_gioithieu_service_style',
                        'options'   => array(
                            'ico'   => 'Biểu tượng',
                            'img'   => 'Ảnh',
                        ),
                    ),
                    array(
                        'title' => __('Số lượng hiện thị', 'mozchild'),
                        'subtitle'  => __('Chọn số lượng dịch vụ/đặc điểm cần hiển thị. tối đa là 4, nếu chọn là 0 thì sẽ tắt chức năng này.', 'mozchild'),
                        'type'      => 'select',
                        'id'        => 'opt_gioithieu_service_num',
                        'options'   => array(
                            '0'   => '0 - Tắt',
                            '1'   => '1',
                            '2'   => '2',
                            '3'   => '3',
                            '4'   => '4',
                        ),
                    ),
                    array(
                        'id'        => 'opt_gioithieu_service_1_div',
                        'title'      => 'Dịch vụ 1',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '0' ),
                        'type'      => 'section',
                        'indent'    => true,
                    ),
                    array(
                        'title' => __('Tiêu đề cho dịch vụ 1', 'mozchild'),
                        'type'      => 'text',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '0' ),
                        'id'        => 'opt_gioithieu_service_1_title',
                    ),
                    array(
                        'title' => __('Link cho dịch vụ 1', 'mozchild'),
                        'type'      => 'text',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '0' ),
                        'id'        => 'opt_gioithieu_service_1_link',
                        'validate'  => 'url',
                    ),
                    array(
                        'title' => __('Biểu tượng cho dịch vụ 1', 'mozchild'),
                        'subtitle'  => __( 'Truy cập <a href="http://kb.vietmoz.info/?p=119">http://kb.vietmoz.info/?p=119</a> để lấy tên biểu tượng cần dùng. Ví dụ: fa-adjust. Điền tên đó vào ô bên cạnh' ),
                        'type'      => 'text',
                        'required'  => array(
                            array( 'opt_gioithieu_service_num', '>', '0' ),
                            array( 'opt_gioithieu_service_style', '=', 'ico' ),
                            ),
                        'id'        => 'opt_gioithieu_service_1_ico',
                    ),
                    array(
                        'title'     => __( 'Ảnh đại diện cho dịch vụ 1', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'media',
                        'required'  => array(
                            array( 'opt_gioithieu_service_num', '>', '0' ),
                            array( 'opt_gioithieu_service_style', '=', 'img' ),
                            ),
                        'id'        => 'opt_gioithieu_service_1_img',
                        'description'   => __( 'Kích thước ảnh:<br />
                            <ul style="padding-left: 30px; list-style: square">
                                <li>Tất cả ảnh phải có kích thước giống nhau.</li>
                                <li>Chiều rộng tối đa nên để: 480px;</li>
                                <li>Chiều cao bạn tự quyết định cho phù hợp</li>
                            </ul>
                            '),
                    ),
                    array(
                        'title'     => __( 'Mô tả dịch vụ 1', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'textarea',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '0' ),
                        'id'        => 'opt_gioithieu_service_1_desc',
                    ),
                    array(
                        'id'        => 'opt_gioithieu_service_1_div_end',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '0' ),
                        'type'      => 'section',
                        'indent'    => false,
                    ),
                    array(
                        'id'        => 'opt_gioithieu_service_2_div',
                        'title'      => 'Dịch vụ 2',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '1' ),
                        'type'      => 'section',
                        'indent'    => true,
                    ),
                    array(
                        'title' => __('Tiêu đề cho dịch vụ 2', 'mozchild'),
                        'type'      => 'text',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '1' ),
                        'id'        => 'opt_gioithieu_service_2_title',
                    ),
                    array(
                        'title' => __('Link cho dịch vụ 2', 'mozchild'),
                        'type'      => 'text',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '1' ),
                        'id'        => 'opt_gioithieu_service_2_link',
                        'validate'  => 'url',
                    ),
                    array(
                        'title' => __('Biểu tượng cho dịch vụ 2', 'mozchild'),
                        'subtitle'  => __( 'Truy cập <a href="http://kb.vietmoz.info/?p=119">http://kb.vietmoz.info/?p=119</a> để lấy tên biểu tượng cần dùng. Ví dụ: fa-adjust. Điền tên đó vào ô bên cạnh' ),
                        'type'      => 'text',
                        'required'  => array(
                            array( 'opt_gioithieu_service_num', '>', '1' ),
                            array( 'opt_gioithieu_service_style', '=', 'ico' ),
                            ),
                        'id'        => 'opt_gioithieu_service_2_ico',
                    ),
                    array(
                        'title'     => __( 'Ảnh đại diện cho dịch vụ 2', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'media',
                        'required'  => array(
                            array( 'opt_gioithieu_service_num', '>', '1' ),
                            array( 'opt_gioithieu_service_style', '=', 'img' ),
                            ),
                        'id'        => 'opt_gioithieu_service_2_img',
                        'description'   => __( 'Kích thước ảnh:<br />
                            <ul style="padding-left: 30px; list-style: square">
                                <li>Tất cả ảnh phải có kích thước giống nhau.</li>
                                <li>Chiều rộng tối đa nên để: 480px;</li>
                                <li>Chiều cao bạn tự quyết định cho phù hợp</li>
                            </ul>
                            '),
                    ),
                    array(
                        'title'     => __( 'Mô tả dịch vụ 2', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'textarea',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '1' ),
                        'id'        => 'opt_gioithieu_service_2_desc',
                    ),
                    array(
                        'id'        => 'opt_gioithieu_service_2_div_end',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '1' ),
                        'type'      => 'section',
                        'indent'    => false,
                    ),
                    array(
                        'id'        => 'Opt_gioithieu_service_3_div',
                        'title'      => 'Dịch vụ 3',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '2' ),
                        'type'      => 'section',
                        'indent'    => true,
                    ),
                    array(
                        'title' => __('Tiêu đề cho dịch vụ 3', 'mozchild'),
                        'type'      => 'text',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '2' ),
                        'id'        => 'opt_gioithieu_service_3_title',
                    ),
                    array(
                        'title' => __('Link cho dịch vụ 3', 'mozchild'),
                        'type'      => 'text',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '2' ),
                        'id'        => 'opt_gioithieu_service_3_link',
                        'validate'  => 'url',
                    ),
                    array(
                        'title' => __('Biểu tượng cho dịch vụ 3', 'mozchild'),
                        'subtitle'  => __( 'Truy cập <a href="http://kb.vietmoz.info/?p=119">http://kb.vietmoz.info/?p=119</a> để lấy tên biểu tượng cần dùng. Ví dụ: fa-adjust. Điền tên đó vào ô bên cạnh' ),
                        'type'      => 'text',
                        'required'  => array(
                            array( 'opt_gioithieu_service_num', '>', '2' ),
                            array( 'opt_gioithieu_service_style', '=', 'ico' ),
                            ),
                        'id'        => 'opt_gioithieu_service_3_ico',
                    ),
                    array(
                        'title'     => __( 'Ảnh đại diện cho dịch vụ 3', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'media',
                        'required'  => array(
                            array( 'opt_gioithieu_service_num', '>', '2' ),
                            array( 'opt_gioithieu_service_style', '=', 'img' ),
                            ),
                        'id'        => 'opt_gioithieu_service_3_img',
                        'description'   => __( 'Kích thước ảnh:<br />
                            <ul style="padding-left: 30px; list-style: square">
                                <li>Tất cả ảnh phải có kích thước giống nhau.</li>
                                <li>Chiều rộng tối đa nên để: 480px;</li>
                                <li>Chiều cao bạn tự quyết định cho phù hợp</li>
                            </ul>
                            '),
                    ),
                    array(
                        'title'     => __( 'Mô tả dịch vụ 3', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'textarea',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '2' ),
                        'id'        => 'opt_gioithieu_service_3_desc',
                    ),
                    array(
                        'id'        => 'Opt_gioithieu_service_3_div_end',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '2' ),
                        'type'      => 'section',
                        'indent'    => false,
                    ),
                    array(
                        'id'        => 'opt_gioithieu_service_4_div',
                        'title'      => __( 'Dịch vụ 4', 'mozchild' ),
                        'required'  => array( 'opt_gioithieu_service_num', '>', '3' ),
                        'type'      => 'section',
                        'indent'    => true,
                    ),
                    array(
                        'title' => __('Tiêu đề cho dịch vụ 4', 'mozchild'),
                        'type'      => 'text',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '3' ),
                        'id'        => 'opt_gioithieu_service_4_title',
                    ),
                    array(
                        'title' => __('Link cho dịch vụ 4', 'mozchild'),
                        'type'      => 'text',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '3' ),
                        'id'        => 'opt_gioithieu_service_4_link',
                        'validate'  => 'url',
                    ),
                    array(
                        'title' => __('Biểu tượng cho dịch vụ 4', 'mozchild'),
                        'subtitle'  => __( 'Truy cập <a href="http://kb.vietmoz.info/?p=119">http://kb.vietmoz.info/?p=119</a> để lấy tên biểu tượng cần dùng. Ví dụ: fa-adjust. Điền tên đó vào ô bên cạnh' ),
                        'type'      => 'text',
                        'required'  => array(
                            array( 'opt_gioithieu_service_num', '>', '3' ),
                            array( 'opt_gioithieu_service_style', '=', 'ico' ),
                            ),
                        'id'        => 'opt_gioithieu_service_4_ico',
                    ),
                    array(
                        'title'     => __( 'Ảnh đại diện cho dịch vụ 4', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'media',
                        'required'  => array(
                            array( 'opt_gioithieu_service_num', '>', '3' ),
                            array( 'opt_gioithieu_service_style', '=', 'img' ),
                            ),
                        'id'        => 'opt_gioithieu_service_4_img',
                        'description'   => __( 'Kích thước ảnh:<br />
                            <ul style="padding-left: 30px; list-style: square">
                                <li>Tất cả ảnh phải có kích thước giống nhau.</li>
                                <li>Chiều rộng tối đa nên để: 480px;</li>
                                <li>Chiều cao bạn tự quyết định cho phù hợp</li>
                            </ul>
                            '),
                    ),
                    array(
                        'title'     => __( 'Mô tả dịch vụ 4', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'textarea',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '3' ),
                        'id'        => 'opt_gioithieu_service_4_desc',
                    ),
                    array(
                        'id'        => 'opt_gioithieu_service_4_div_end',
                        'required'  => array( 'opt_gioithieu_service_num', '>', '3' ),
                        'type'      => 'section',
                        'indent'    => false,
                    ),
                    array(
                        'id'        => 'opt_gioithieu_about_div',
                        'title'      => __( 'Tùy chọn bài viết', 'mozchild' ),
                        'type'      => 'section',
                        'indent'    => true,
                    ),
                    array(
                        'title' => __('Bài viết nổi bật', 'mozchild'),
                        'subtitle'  => __( 'chọn bài viết nối bật/trang bạn muốn hiển thị ra trang chủ. Bài viết này có thể là thư ngỏ, bài giới thiệu cty.', 'mozchild' ),
                        'type'      => 'select',
                        'id'        => 'opt_gioithieu_featured',
                        'data'      => 'post',
                        'args'      => array(
                            'post_type' => array( 'post', 'page' ),
                            'posts_per_page' => -1
                        ),
                    ),
                    array(
                        'title'     => __( 'Ảnh banner', 'mozchild' ),
                        'subtitle'  => __( '', 'mozchild' ),
                        'type'      => 'media',
                        'id'        => 'opt_gioithieu_banner_img',
                    ),
                    array(
                        'title' => __('Link Banner', 'mozchild'),
                        'type'      => 'text',
                        'id'        => 'opt_gioithieu_banner_url',
                        'validate'  => 'url',
                    ),
                    array(
                        'title' => __('Số lượng bài tin tức hiển thị ở trang chủ', 'mozchild'),
                        'type'      => 'text',
                        'id'        => 'opt_gioithieu_home_post_num',
                        'validate'  => 'numeric',
                    ),
                    array(
                        'id'        => 'opt_gioithieu_about_div_end',
                        'type'      => 'section',
                        'indent'    => false,
                    ),
                )
            );

            $this->sections[] = array(
                'title' => __('Thiết lập web tin tức', 'mozchild'),
                // 'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'mozchild'),
                // Redux ships with the glyphicons free icon pack, included in the options folder.
                // Feel free to use them, add your own icons, or leave this blank for the default.
                'icon' => 'el-icon-book',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array(
                    array(
                        'title' => __('Chọn chuyên mục tin cho trang chủ', 'moztheme-redux'),

                        'subtitle'  => __('Kéo thả chuyên mục tin tức cần hiển thị ra trang chủ, có thể sắp xếp thứ tự các chuyên mục tương ứng.', 'moztheme-redux'),
                        'type'      => 'select',
                        'id'        => 'opt_tintuc_home_cats',
                        'data'      => 'categories',
                        'multi'     => true,
                        'sortable'  => true,
                    ),
                    array(
                        'title' => __('Banner trang chủ', 'moztheme-redux'),
                        'type'      => 'section',
                        'id'        => 'opt_tintuc_home_banner',
                        'indent'    => true,
                    ),
                    array(
                        'title' => __('Chọn ảnh banner', 'moztheme-redux'),
                        'type'      => 'media',
                        'id'        => 'opt_tintuc_home_banner_img',
                    ),
                    array(
                        'title' => __('Link banner', 'moztheme-redux'),
                        'type'      => 'text',
                        'id'        => 'opt_tintuc_home_banner_url',
                    ),
                    array(
                        'title' => __('Vị trí', 'moztheme-redux'),
                        'subtitle' => __('Điều chỉnh vị trí banner xuất hiện ở vị trí chuyên mục tương ứng. Chị có thể điền số. Từ 1 đến n, với n là số lượng chuyên mục bạn chọn hiện ra trang chủ.', 'moztheme-redux'),
                        'type'      => 'text',
                        'id'        => 'opt_tintuc_home_banner_order',
                        'validate'  => 'numeric',
                    ),
                    array(
                        'type'      => 'section',
                        'id'        => 'opt_tintuc_home_banner_end',
                        'indent'    => false,
                    ),
                )
            );

            $this->sections[] = array(
                'type' => 'divide',
            );

            // $this->sections[] = array(
            //     'title'     => __('Sample', 'moztheme-redux'),
            //     'icon'      => 'el-icon-refresh',
            //     'fields'    => array(
            //     ),
            // );

            $this->sections[] = array(
                'title'     => __('Import / Export', 'moztheme-redux'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'moztheme-redux'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'moztheme-redux'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'moztheme-redux'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'moztheme-redux'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'moztheme-redux'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'moztheme-redux')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'moztheme-redux'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'moztheme-redux')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'moztheme-redux');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                'opt_name' => '_moz_opts',
                'disable_tracking' => true,
                'page_slug' => 'moz_options',
                'page_title' => 'VietMoz Theme Options',
                'update_notice' => true,
                'intro_text' => '<p>Options for customization your amazing theme.</p>',
                'footer_text' => '<p>This stunning theme is created with passion and love!.</p>',
                'admin_bar' => true,
                'menu_type' => 'menu',
                'menu_title' => 'VietMoz Theme Options',
                'allow_sub_menu' => true,
                //'page_parent' => 'themes.php',
                'page_parent_post_type' => 'your_post_type',
                'default_show' => true,
                'default_mark' => '*',
                'google_api_key' => 'AIzaSyAzWrwJ8FfNXXyO2muBn53AlZ_LGea5n8o',
                'class' => 'moz-container',
                'dev_mode'  => false,
                'footer_credit'    => 'mOztheme v0.1',
                'hints' => 
                array(
                  'icon' => 'el-icon-question-sign',
                  'icon_position' => 'right',
                  'icon_size' => 'normal',
                  'tip_style' => 
                  array(
                    'color' => 'light',
                    'style' => 'youtube',
                  ),
                  'tip_position' => 
                  array(
                    'my' => 'top left',
                    'at' => 'bottom right',
                  ),
                  'tip_effect' => 
                  array(
                    'show' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseover',
                    ),
                    'hide' => 
                    array(
                      'effect' => 'fade',
                      'duration' => '500',
                      'event' => 'mouseleave unfocus',
                    ),
                  ),
                ),
                'output' => true,
                'output_tag' => true,
                'output' => true,
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => true,
                'show_import_export' => true,
                'transient_time' => '3600',
                'network_sites' => true,
              );

            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"] = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.

            $this->args['share_icons'][] = array(
                'url'   => 'https://facebook.com/ctyvietmoz',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.youtube.com/user/vietmoz',
                'title' => 'Find us on Youtube',
                'icon'  => 'el-icon-youtube'
            );

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new moztheme_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('moztheme_my_custom_field')):
    function moztheme_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('moztheme_validate_callback_function')):
    function moztheme_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
