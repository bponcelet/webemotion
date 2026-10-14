WEB eMOTION — WEBSITE PACKAGE
=============================

Contents
--------
index.html        The website (single page, responsive)
thanks.html       Page shown after the contact form is sent
contact.php       Sends the contact form to info@webemotion.be (needs PHP)
favicon.svg       Browser tab icon
assets/           Logo, self-hosted fonts (no Google requests — GDPR-friendly)
robots.txt        Search-engine rules
sitemap.xml       Sitemap for Google Search Console
.htaccess         Apache settings: compression, caching, security headers

Deploying (OVHcloud Web Cloud or any Apache + PHP hosting)
----------------------------------------------------------
1. Unzip this package on your computer.
2. Connect to your hosting by FTP/SFTP (e.g. FileZilla) with the credentials
   from your hosting control panel.
3. Upload EVERYTHING inside "webemotion-site/" (including the hidden
   .htaccess file) into the web root folder — on OVHcloud this is "www/".
4. Open https://www.webemotion.be and check the page.
5. Send a test message through the contact form.

After the first upload
----------------------
- SSL: activate the free SSL certificate in your hosting panel, then remove
  the "#" in front of the HTTPS lines in .htaccess to force https://www.
- Contact form: the form sends from no-reply@webemotion.be. If messages do
  not arrive, check your spam folder and make sure the hosting's mail
  sending is enabled. To change the recipient, edit TO_ADDRESS in contact.php.
- Domain: if the site will live on https://webemotion.be (without www),
  replace "https://www.webemotion.be" in index.html, robots.txt,
  sitemap.xml and .htaccess.
- No PHP on your hosting? In index.html change
  action="contact.php" to action="mailto:info@webemotion.be"
  (visitors' mail app will then open instead), or use a form service.
