=== Online Help Sliding Menu ===
Contributors: fabiandragos
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8VQG8Y8SDZW8E
Tags: online help, menu, sliding menu, jQuery menu, responsive, sliding, hide on pages, custom css
Requires at least: 4.4
Tested up to: 4.9.6
Stable tag: trunk
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Use a widget to transform a normal sidebar menu (custom menu or pages list) into a responsive online help style sliding menu with the possibility of adding your own custom CSS styling.

== Description ==

You can use the Online Help Sliding Menu plugin to transform a normal sidebar menu (custom menu or pages list) into a responsive online help style sliding menu with the possibility of adding your own custom CSS styling.

This is a great plugin to use for documentation websites!

To use Online Help Sliding Menu, all you have to do is to go to the Widgets page of the Wordpress Admin and add OH Sliding Menu widgets on any of the available areas.  
For each widget you can:

* Enter a Title.
* Choose if the widget will display one of your Custom menus or a list of the Pages of your website. 
* If you choose Custom menus, you will be able to select one of the available menus.
* If you choose Pages menu, you will be able to enter the IDs of the pages you want to exclude from the menu!
* Enter the IDs of the pages where you do not want to show the widget!

Note: Before setting up this plugin, you should first create a Custom menu or, set up the order of the pages of your website.

The sliding action is achieved with jQuery. For responsive environments, the menu is automatically hidden and a button labelled SHOW/HIDE MENU is displayed.

You can add custom CSS on the plugin's setup page (with syntax highlighting if WordPress version is 4.9 or higher) in order to style your menus as needed.

For Pages that have child pages the menu will add a folder icon on the left side of the page name. Other Pages will have a file icon on the left side of the page name.

* When you click the folder icon, the menu will slide down, the folder icon opens and the menu slides down showing the child pages.
* When you open a link (anywhere on your website) to a page on the menu, if that page is a child page, the menu opens (slides down) all parent items of that page.
* Every time you navigate to a page on the menu, the current state of the menu (opened and/or closed items) is kept for the current browser session.

If you select the Pages Menu option on this plugin's settings page, you can also enter the ids of pages which you do not want to have on the menu.

Menus with many pages may require an increased value for the MAX_INPUT_VARS PHP variable - on this plugin's settings page, you can check to see the current value.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/Online Help Sliding Menu` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Create a Custom Menu or arrange the Pages of your website in the order you want them to appear on the Online Help Sliding Menu. 
4. Go to the Appearance->Widgets screen and add the OH Sliding Menu widget to a Sidebar area or any available widget area.
6. Set up the widget and then click Save.


== Frequently Asked Questions ==

= How can I change the CSS styles for the OH Sliding Menu widgets? =

Just go to the plugin's settings page and add your custom CSS in the box you will see there. For WordPress version 4.9 or higher syntax highlighting is also available! 

= Can I hide the menu on some pages? =

Yes. You can enter the IDs of the pages where you do not want to show the menu.

= What happens if a Custom menu gets deleted while it is selected within a OH Sliding Menu widget? =

You will be notified that the Custom menu is not found for that widget and the widget will automatically switch to the Pages menu.

= Does this plugin really needs BootstrapCSS to work? =

Not really. But using this CSS library might help with the way the menu is displayed on the sidebar.
You can enable the Enable BootstrapCSS from CDN? check box and see if the menu looks better. However, this might also affect your entire website as well.
Use caution!

= Can I also see Posts on the sidebar menu with this plugin? =

Of course. All you have to do is add Posts to the custom menu you create. However, this is not possible when you select the Pages Menu option on this plugin's settings  
page.

== Screenshots ==

1. Online Help Sliding Menu on a right side sidebar.
2. Online Help Sliding Menu on a mobile device - responsive button label: SHOW/HIDE MENU.
3. The OH Sliding Menu widget.
4. Online Help Sliding Menu widget - Pages menu selected with page IDs 2,3 and 4 excluded.
5. Online Help Sliding Menu widget - Custom menu selected with the name of the menu: Custom Menu 1.
6. Online Help Sliding Menu widget - widget will not be displayed on pages with IDs: 2,3 and 4.
7. How to check the MAX_INPUT_VARS PHP variable value.

== Changelog ==

= 1.3 =
* Added CSS code editor in OHSM settings page with syntax highlighting available for WordPress 4.9 or higher
* OHSM default options are created on plugin activation not on first access of the setup page
* Fixed undefined variable notices
* Updated the display of the current MAX_INPUT_VARS PHP variable value

= 1.2 =
* Fixed widget registration error
* Fixed included files errors
* Fixed invalid argument if no OHSM widget is yet registered

= 1.1 =
* Moved menu setup options to widget
* Added option to not show widget with menu on specific pages based on the page ID
* Updated jQuery code to enable use of multiple sliding menus.

= 1.0 =
* First release

== Upgrade Notice ==

= 1.3 =
Added option to edit css in OHSM settings page, with syntax highlighting available for WordPress 4.9 or higher.

= 1.2 =
Major bug fixes! Plugin functions correctly and includes the right file paths.

= 1.1 =
Moved menu setup options to widget, added option to not show widget with menu on specific pages based on the page ID. Updated jQuery code to enable use of multiple sliding menus.

= 1.0 =
First release