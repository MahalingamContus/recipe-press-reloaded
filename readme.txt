=== RecipePress ===
Contributors: grandslambert
Donate link: http://recipepress.net/donate.html
Tags: recipes, cooking, food, recipe share
Requires at least: 3.0
Tested up to: 3.1
Stable tag: trunk

Turn your Wordpress site into a full fledged recipe sharing system with user contributions.

== Description ==

Turn your <strong>Wordpress 3.0</strong> site into a full fledged recipe sharing system. Allow users to submit recipes, organize recipes in hierarchal categories, make comments, and embed recipes in posts and pages.

= Features =

* My Recipe Box
* Import RecipeML and MealMaster formatted recipes!
* Uses the new Custom Post Type feature of Wordpress 3.0
* Two taxonomies built in (Categories and Cuisines) - option to add your own custom taxonomies.
* Options to also include categories and tags used from standard posts.
* User Comments and Pingbacks
* Recipe photo using featured thumbnail tools.
* Custom Fields and Trackbacks
* Featured recipes (optional)
* User Submission Form with recipe image and optional reCaptcha validation.

= Languages =

This plugin includes the following translations. Translations listed with no translator were created by the plugin developer using Google Translate. If you can improve these, you can get your name listed here!

* Spanish
* French (outdated)
* Norwegian (outdated)
* Portuguese (outdated)

= Future Features =

* Share Recipes
* Recipe Photo Galleries
* Your ideas welcome!

== Installation ==

1. Upload `recipe-press` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin on the Recipes menu screen.

== Changelog ==

= 2.2 - March 7th, 2011 =

* <strong>New Feature</strong>: My Recipe Box - check your settings to make sure this works.
* Added a new widget for displaying recipe taxonomies.
* Fixed the settings page that would not accept changes to the ingredient taxonomy recipe slug.
* Added option in 'the_recipe_print_link()' to specify an image to use by setting 'print-link'image' to the URL of the image.
* Fixed an issue where the next and previous recipe links did not work in the shortcode.
* Fixed the titles on the taxonomy list pages when using template files.
* Added some screen shots to the "Screen Shots" page here.
* Added option to disable all content filters if using custom template files.
* Addressed issue #24 to provide Ready Time as only minutes in a new custom field labled '_ready_time_raw_value'.
* Fixed issue #32 where dividers were not saving on from the front end form.
* Fixed a pluralization issue in the dashboard code.
* Fixed several lanaguage errors.
* Added a Spanish translation.
* Removed empty German Translation file (new file is in the wors).

= 2.1.2 - February 25th, 2011 =

* Fixed an issue with the auto-lookup of ingredients.
* Fixed issue #22 where dividers were not saving or displaying correctly.
* Fixed issue #28 that prevented users from turning off the plugin CSS.
* Fixed issue #29 that was not saving images from the front end form.
* Fixed issues #30 and #31 to work with both types of permalinks.
* Fixed an issue where the default permalink structure was not created properly if default permalinks are used on the site.
* Fixed an issue where ingredients were not properly linked to recipes when saved in the admin area.
* Fixed an issue where the category widget displayed empty categories.

= 2.1.1 - February 21st, 2011 =

* Fixed an issue that could break the front end form if no image was attached.
* Changed how image uploads are handled so that all the image sizes are created on upload.
* Added an option to change the built in image sizes and add additional sizes.
* Added an option to allow you to choose where the Recipes menu is displayed.
* Changed the template tag names to avoid conflicts with other plugins.
* Added checks around all tag functions to allow overriding.
* Fixed an issue where extra columns on recipe list page in the backend were blank.
* Added importer for MealMaster files.
* Added options on administration page to clear recipes and taxonomies.
* Changed the selection method for ingredients - now uses an autocomplete feature.
* Fixed an issue where the CSS for the admin side was not loading.
* Added code to list only categories with published recipes in taxonomy lists.
* Added a rewrite to list ingredients on a taxonomy type page.
* Fixed an issue where an empty ingredient line would display errors on recipe page.
* Fixed an issue that caused some installations not to update properly.
* Added pagination to the taxonomy list pages.
* Fixed an issue where plugin required pretty permalinks.

= 2.1 - February 15th, 2011 =

* Fixed an issue where fresh install required an update.
* Add an option to import RecipeML files.
* Added rewrite rules to load taxonomy lists using either a template file or rediredt to a display page.
* Added options to set the sort field and order for recipe listings.
* Added page attributes to the edit screen.
* Removed option to turn on content filter as it is on by default but is bypassed when theme template files exist.

= 2.0.6 - February 14th, 2011 =

* Yes, updates even on Valentine's Day!
* Fixed the issue of not loading index-recipe.php and archive-recipe.php
* Renamed template files so they do not match WordPress Template Hierarchy
* Added more template files and restyled output on the included WordPress theme.
* Added the ability to link ingredients to posts.
* Fixed the size of the ingredient form on the admin side so it does not overlap right column.
* Fixed an issue where recipe taxonomies were not being saved.
* Fixed errors on settings screen when a taxonomy is not active.
* Added a check to not display inactive taxonomies on the public form.
* Added an option to make hierarchical taxonomies allow multiple selections on public form.
* Added the [recipe-tax] short code to list entries in RecipePress taxonomies.
* Changed the category and cuisine tags for the recipe-list shortcode to use '-' insteand of '_'.
* Added filters on the output of most template tags to allow customizing the output.

= 2.0.5 - February 13th, 2011 =

* Fixed an issue with a few template tags that echo when they should return.
* Fixed issues with misnamed function getTemplate in print recipes code.
* Fixed issues where areas of recipes (servings, times, etc) still displayed even if not used.
* Fixed an issue where the WordPress updates page would not load while while RecipePress was active.
* Fixed an issue where images on the front end were no longer saving with the recipe.

= 2.0.4 - February 11th, 2011 =

* Split the code into various classes to cut down on the load for the front end.
* Fixed the "Settings" link in the plugins page.
* Changed how the front end form works - uses nonce field now for security and should work now.
* Renamed the required field entry for the recipe category to 'recipe-category' so it works.
* Fixed an issue that caused front end form to error if no image is uploaded.
* Fixed an issue on the form that created extra ingredients fields when errors occur.
* Fixed an issue where divider names were displaying as numbers instead of text.

= 2.0.3 - February 9th, 2011 =

* Fixed an issue with the list widget where you could not turn off the show icon setting.
* Fixed an issue with recipe servings where if no size is selected it breaks some themes.
* Fixed some language issues, all text should now be able to be translated.
* Fixed an issue with URLs for stylesheets and javascript still not working on Windows servers.

= 2.0.2 - February 4th, 2011 =

* Fixed an issue with sortable ingredients on the front end form.
* Fixed an issue where the wrong size taxonomy was displayed for servings on the front end form.
* Fixed an issue where the CSS and JS files for the plugin did not load on a Windows Server.
* Fixed a code error that prevented the "parent" and "template" fields appearing on page edit screen.
* Fixed an issue where the recipe servings container had the same class as the main container.
* Changed the category taxonomy name to 'recipe-category' - requires reactivation to update data.
* Changed the cuisine taxonomy name to 'recipe-cuisine' - requires reactivation to update data.

= 2.0.1 - January 28th, 2011 =

* Added a missing file that prevented the plugin from activating.

= 2.0 - January 28th, 2011 =

* Version advanced due to the major rewrite and plethora of new ideas.
* Added support for recipe image on the front end form.
* Added custom permalink settings to replace use of pages.
* Added support for theme files.
* Added embedded theme based on Twenty Ten with necessary files.
* Converted ingredients to custom taxonomy for more control and better indexing.
* Converted recipe sizes to custom taxonomy that can be editted by users.
* Added tools to automatically convert sizes to taxonomy when recipe is edited.
* Updated template tags to use new recipe sizes taxonomy - backwards compatible with old data.
* Fixed several spelling errors.
* Add option to select how many recipes to display on the index page.
* Added option to add recipes to author pages.
* Removed the "Measurement Type" option as it was not used.
* Added setting for index slug defaulted to 'recipes' for better control over URL structure.
* Fixed issue of only showing 5 recipes on recipe lists - now has standard Wordpress pagination.

Changes prior to version 2.0 are no longer supported. View the prior changlogs at:

http://recipepress.net/about/changelog-since-version-1-0.html

== Upgrade Notice ==

= 2.2 =
Added the Recipe Box and a new taxonomy widget. Other bug fixes made as well.

= 2.1.1 =
URGENT: Fixes the front end form and handles ingredients better to avoid javascript errors.

= 2.1 =
Fixed some bugs and the front end form.

= 2.0.6 =
Fixed the image and taxonomy functions so they save from the front end form.

= 2.0.4 =
If your front end form is not working, you need this update.

= 2.0.2 =
Required update for anyone running WordPress on a Windows server.

= 2.0 =
You may need to adjust a number of settings and shortcodes for this new version to work.

== Frequently Asked Questions ==

= How do I add recipes to my posts or pages? =

There is one shortcode for placing recipes on your site, recipe-show. Please visit https://sourceforge.net/apps/mediawiki/recipepress/index.php?title=Recipe-show for instructions on how to use these shortcodes.

= What widgets are available =

Currently there are two widgets, one to lest recipes and one to list categories. At this time they are limited to displaying a small set of items, but future development will expand the options for these widgets.

= How can people comment on recipes? =

When viewing a recipe, a comment form will appear just as it does on your posts. Comments are managed in the same place as your post and page comments.

= How can I add a user submit form? =

You will need to create a page and add the [recipe-form] shortcode. Please see the http://wiki.recipepress.net/wiki/Recipe-form for more details on how to use this shortcode.

= Where can I get support? =

http://support.recipepress.net

== Screenshots ==

* Sample recipe list.
* Sample recipe display page.
* Sample list of recipe categories.
* Sample list of recipes in a category.