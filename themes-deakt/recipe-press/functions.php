<?php

if ( !function_exists('twentyten_setup') ):

     /**
      * Sets up theme defaults and registers support for various WordPress features.
      *
      * Note that this function is hooked into the after_setup_theme hook, which runs
      * before the init hook. The init hook is too late for some features, such as indicating
      * support post thumbnails.
      *
      * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
      * functions.php file.
      *
      * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
      * @uses register_nav_menus() To add support for navigation menus.
      * @uses add_custom_background() To add support for a custom background.
      * @uses add_editor_style() To style the visual editor.
      * @uses load_theme_textdomain() For translation/localization support.
      * @uses add_custom_image_header() To add support for a custom header.
      * @uses register_default_headers() To register the default custom header images provided with the theme.
      * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
      *
      * @since Recipe Press 2.0
      */
     function twentyten_setup() {
          global $RECIPEPRESSOBJ;

          // This theme styles the visual editor with editor-style.css to match the theme style.
          add_editor_style();

          // This theme uses post thumbnails
          add_theme_support('post-thumbnails');

          // Add default posts and comments RSS feed links to head
          add_theme_support('automatic-feed-links');

          // Make theme available for translation
          // Translations can be filed in the /languages/ directory
          load_theme_textdomain('twentyten', TEMPLATEPATH . '/languages');

          $locale = get_locale();
          $locale_file = TEMPLATEPATH . "/languages/$locale.php";
          if ( is_readable($locale_file) )
               require_once( $locale_file );

          // This theme uses wp_nav_menu() in one location.
          register_nav_menus(array(
               'primary' => __('Primary Navigation', 'twentyten'),
                  ));

          // This theme allows users to set a custom background
          add_custom_background();

          // Your changeable header business starts here
          define('HEADER_TEXTCOLOR', '');
          // No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
          define('HEADER_IMAGE', get_bloginfo('stylesheet_directory') . '/images/headers/cookies.jpg');

          // The height and width of your custom header. You can hook into the theme's own filters to change these values.
          // Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
          define('HEADER_IMAGE_WIDTH', apply_filters('twentyten_header_image_width', 940));
          define('HEADER_IMAGE_HEIGHT', apply_filters('twentyten_header_image_height', 198));

          // We'll be using post thumbnails for custom header images on posts and pages.
          // We want them to be 940 pixels wide by 198 pixels tall.
          // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
          set_post_thumbnail_size(HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);

          // Don't support text inside the header image.
          define('NO_HEADER_TEXT', true);

          // Add a way for the custom header to be styled in the admin panel that controls
          // custom headers. See twentyten_admin_header_style(), below.
          add_custom_image_header('', 'twentyten_admin_header_style');

          // ... and thus ends the changeable header business.
          // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
          register_default_headers(array(
               'cake-topper' => array(
                    'url' => get_bloginfo('stylesheet_directory') . '/images/headers/cake-topper.jpg',
                    'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/headers/cake-topper-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __('Cake Topper', 'twentyten')
               ),
               'fine-dining' => array(
                    'url' => get_bloginfo('stylesheet_directory') . '/images/headers/fine-dining.jpg',
                    'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/headers/fine-dining-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __('Fine Dining', 'twentyten')
               ),
               'grilled-chicken' => array(
                    'url' => get_bloginfo('stylesheet_directory') . '/images/headers/grilled-chicken.jpg',
                    'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/headers/grilled-chicken-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __('Grilled Chicken', 'twentyten')
               ),
               'healthy-foods' => array(
                    'url' => get_bloginfo('stylesheet_directory') . '/images/headers/healthy-foods.jpg',
                    'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/headers/healthy-foods-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __('Healthy Foods', 'twentyten')
               ),
               'hot-coals' => array(
                    'url' => get_bloginfo('stylesheet_directory') . '/images/headers/hot-coals.jpg',
                    'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/headers/hot-coals-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __('Hot Coals', 'twentyten')
               ),
               'pizza' => array(
                    'url' => get_bloginfo('stylesheet_directory') . '/images/headers/pizza.jpg',
                    'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/headers/pizza-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __('Pizza', 'twentyten')
               ),
               'steak' => array(
                    'url' => get_bloginfo('stylesheet_directory') . '/images/headers/steak.jpg',
                    'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/headers/steak-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __('Steak', 'twentyten')
               ),
               'stovetop' => array(
                    'url' => get_bloginfo('stylesheet_directory') . '/images/headers/stovetop.jpg',
                    'thumbnail_url' => get_bloginfo('stylesheet_directory') . '/images/headers/stovetop-thumbnail.jpg',
                    /* translators: header image description */
                    'description' => __('Stovetop', 'twentyten')
               ),
                  ));
     }

endif;