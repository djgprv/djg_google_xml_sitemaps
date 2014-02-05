Djg Google Xml Sitemaps Documentation
----
* Simple plugin to generate xml sitemap SEO compatible
* Sitemap adress is: http://www.mywebsite.com/sitemap.xml
* Read about sitemaps: href="http://en.wikipedia.org/wiki/Sitemap.xml

HISTORY VERSION
----
* 1.0.0    - beta
* 1.0.1	- Added HOME PAGE to xml tree
* 1.0.2	- Added setting page, now You can choose page to display in xml tree. There are three options, show hide HOME PAGE and by status: STATUS_HIDDEN, LOGIN_REQUIRED. Thx Fortron for suggest
* 1.0.3	- Added xml header (thx for andrewmman) and ability to set default Changefreq and Priority for pages
* 1.0.4	- Added "choose header" to settings, changed translation and added nl-message.php (thx for Fortron)
* 1.0.5	- Changed plugin settings view to valid XHTML, some translate changes
* 1.0.6	- Robots.txt
* 1.0.7	- Sitemap cacheing
* 1.0.8	- Wolf CMS ver. 0.7.7
* 1.0.9	- Sitemap frontend function, Wolf CMS 0.8 works
* 1.1.0	- auto clean cache after create, update, remove page;
> changefreq and priority tab to set individual values for page;
> css optimization (for bigger websites there will be a significant improvement in the loading speed of your pages ) gZIP, minifier code on fly from many css files to one. Now you can choose the order of loading the files; djg_select_menu (select menu for mobile version);
* 1.1.1 - removed some bugs (glob search css files, priority and changefreq for homepage, auto_clean)
* 1.1.2 - changed djg_mobile_menu

HOW TO
----

##### Insert below code to page content or layout.
```sh
&lt;?php if (Plugin::isEnabled('djg_google_xml_sitemaps')) djg_sitemap(); ?&gt;
```
```sh
&lt;?php if (Plugin::isEnabled('djg_google_xml_sitemaps')) djg_mobile_menu($this); ?&gt;
```
##### example css for djg_mobile_menu
```sh
.djg_mobile_menu select {
    padding:2px;
    margin: 0;
    color:#888;
    outline:none;
    display: inline-block;
    -webkit-appearance:none;
    -moz-appearance:none;
    appearance:none;
    cursor:pointer;
	font-size: 2em;
	border:1px solid #ddd;
}
.djg_mobile_menu label {position:relative}
.djg_mobile_menu label:after {
    content:'<>';
    color:#aaa;
    -webkit-transform:rotate(90deg);
    -moz-transform:rotate(90deg);
    -ms-transform:rotate(90deg);
    transform:rotate(90deg);
    right:8px; top:-0.5em;
    padding:0 0 2px;
    border-bottom:1px solid #ddd;
    position:absolute;
    pointer-events:none;
}
.djg_mobile_menu label:before {
    content:'';
    right:6px; top:0px;
    position:absolute;
    pointer-events:none;
}
```
ICONS
----
http://www.iconfinder.com/search/?q=iconset%3Afatcow

License
----
MIT