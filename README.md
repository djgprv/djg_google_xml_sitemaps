=== Djg Google Xml Sitemaps Documentation ===
Simple plugin to generate xml sitemap SEO compatible
Sitemap adress is: http://www.mywebsite.com/sitemap.xml
Read about sitemaps: href="http://en.wikipedia.org/wiki/Sitemap.xml

=== HISTORY VERSION ===
1.0.0 - beta
1.0.1 - Added HOME PAGE to xml tree
1.0.2 - Added setting page, now You can choose page to display in xml tree. There are three options, show hide HOME PAGE and by status: STATUS_HIDDEN, LOGIN_REQUIRED. Thx Fortron for suggest
1.0.3 - Added xml header (thx for andrewmman) and ability to set default Changefreq and Priority for pages
1.0.4 - Added "choose header" to settings, changed translation and added nl-message.php (thx for Fortron)
1.0.5 - Changed plugin settings view to valid XHTML, some translate changes
1.0.6 - Robots.txt
1.0.7 - Sitemap cacheing
1.0.8 - Wolf CMS ver. 0.7.7
1.0.9 - Sitemap frontend function, Wolf CMS 0.8 works

=== TO DO ===
Changefreq and Priority tab to set individual values for page.

== HOW TO ===
Insert below code to sitemap page content.
&lt;?php if (Plugin::isEnabled('djg_google_xml_sitemaps')) djg_sitemap(); ?&gt;

=== ICONS ===
http://www.iconfinder.com/search/?q=iconset%3Afatcow
