# easy WordPress Docs

This documentation theme was developed by Jorsek LLC for use with WordPress sites that contain content published from [easyDITA](http://www.easydita.com). It is best used for displaying documentation that includes User Guides, Tutorials, and FAQs.

Our example site is located at documentation.easydita.com.

### Installation
1. Download the [easy-WordPress-Docs.zip](https://github.com/Jorsek/easy-WordPress-Docs/raw/master/easy-WordPress-Docs.zip) file
2. Navigate to the admin page of your WordPress site (usually of the form www.your-site-here.wordpress.com/wp-admin/)
3. On the left side navigation, hover over "Appearance" and click on "Themes"
4. Click the "Add New" button at the top of the page
5. Click the "Upload Theme" button at the top of the page
6. Click the browse button and select the easy-WordPress-Docs.zip file that you downloaded in Step 1.
7. Click "Install Now"
8. Once the installation is complete, you can click "Activate" to make easy WordPress Docs your current theme.

### Content Types
The easy WordPress Docs theme supports several different content types and displays them differently. Each time you publish content from easyDITA or create new content in WordPress, you will need to specify a page type for the root page so that the theme knows how to render the child pages.
1. Navigate to the admin page of your WordPress site
2. On the left side navigation, hover over "Pages" and click on "All Pages"
3. Any pages listed without any "&mdash;" preceding the title are root pages that will be displayed on the home page. These are the pages that you need to specify page types for.
4. Click on one of the root pages and scroll down to the bottom of the Edit Page
5. You should see a section labeled "Custom Fields." Under "Add New Custom Field" if "page_type" isn't an option in the dropdown menu, click "Enter new" and set the name to "page_type"
6. The allowed values are
    * "content" for a user guide or generic documentation content
    * "faq" for frequently asked questions
        * These will all render on one page and expand and collapse on click
    * "tutorial" for tutorial content
        * This content will displayed similarly to "content" except that in the TOC on the left side, it will list all the sections of a single topic instead of all the topics under a given parent page. This is designed for long pages that contain many different parts of a guide that users can follow all the way through to learn about your product.

### Setup
There are several different aspects of the theme that can be customized. To begin, click the "Customize" button (in the top, admin bar on the homepage, or on the active theme in the Themes page under Appearance settings). There are many different settings you can modify, but we will outline the basic ones below.
##### Header Image
1. In the left-hand customization pane, click "Header Image"
2. Click the "Add New Image" button to upload a file from your computer to be the header image
3. It is recommended to be 500x70 pixels in size

##### Sidebar Widget
In our example site (documentation.easydita.com) we use the sidebar to display the most popular pages and questions. In order to do this for your site, you will need to upload the Custom Popular Pages Widget included in this repository.
1. Download the [custom-popular-pages-widget.zip](https://github.com/Jorsek/easy-WordPress-Docs/raw/master/custom-popular-pages-widget.zip) file
2. Navigate to the admin page of your WordPress site
3. On the left side navigation, hover over "Plugins" and click on "Add New"
5. Click the "Upload Theme" button at the top of the page
6. Click the browse button and select the custom-popular-pages-widget.zip file that you downloaded in Step 1.
7. Click "Install Now"
8. Once the installation is complete, you can click "Activate Plugin" to make the Custom Popular Pages Widget available for use.
9. Now we need to add the widget into our sidebar.
10. On the left side navigation, hover over "Appearance" and click on "Widgets"
11. You should see the "Popular Pages Widget" box on the left side
12. Drag the box into the "Sidebar" box on the right side of the screen
13. It will pop open to display several options. You can set these to whatever you wish, however to set them to look like the widgets on the example site, add a second Popular Pages Widget and use the following settings:
    * Widget 1
        * Title: "Popular Questions"
        * Number of posts to show: "10"
        * Metadata Key: "page_type"
        * Metadata Value: "faq"
    * Widget 2
        * Title: "Popular Pages"
        * Number of posts to show: "10"
        * Metadata Key: "page_type"
        * Metadata Value: "content"
14. The Popular Questions widget will show the top 10 most viewed FAQ items, and the Popular Pages widget will show the top 10 most viewed pages within the User Guide or any other sections you have labeled with "content."

##### Footer Content
1. To edit the footer content, open the "Customization" view again (as described in the top of the Setup section)
1. In the left-hand customization pane, click "Footer Info"
2. In this text box you can enter HTML to display in the black footer bar at the bottom of the page.
    * Note that in the default value, there are two divs with classes "group1" and "group2"
    * .group1 is rendered floating left, and .group2 is rendered on the right.
    * Feel free to add any content you wish, and you may also add <style> elements to add CSS styling to the footer content.
        * However, don't modify the colors of the footer box or the footer text because that is handled in the "Colors" section of the Customization options.

##### Colors
Via the Customization screen, you can modify four different colors:
* Main Accent Color
	* This is the color of the accents within the theme. It is used for the search bar (on the home page and on the subpages), the color of titles and active pages in the TOC.
* Search Header Text Color
	* This is the color of the text above the search input box on the home page. The default text is "How can we help?" This also sets the color of the Search Header Text that appears below the header title (this is blank by default).
* Footer Background Color
	* This sets the background color of the footer area
* Footer Text Color
	* This sets the color of the footer text
