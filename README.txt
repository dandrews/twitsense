
This document is currently about resources for building a word-press plugin that will serve up public tweets.

There is the file in Dropbox/Projects/twitter_badge_ads/src/twitsense.php. If you read this file you will see that all
it does it does is return a tweet packaged in some simple html, from a static list of cached tweets. This file is currently
hosted on my server at http://atlatler.com/twitsense/twitsense.php. Feel free to copy it and put it on your own server
for testing purposes. If you need access to the atlatler server, let me know. If you just point your browser at that link
you'll get back a tweet inside a div tag, and that tweet is a link to the twitter person's profile page.

The other file to look at is Dropbox/Projects/twitter_badge_ads/src/mock_pub.html. This file is a simple static webpage
that has the iframe that calls the twitsense.php script. The file mock_pub.html represents a web site owner's page.
If you load mock_pub.html on your localhost, or on your own server, it should also load the iframe that makes the request to
atlatler.com/twitsense/twitsense.php. So, point your browser to atlatler.com/twitsense/mock_pub.html

Now, to make a our iframe html blend in nicely to a web site, and to load fast when requested, we will probably
want to occaisionally crawl the website, get the font styles and color of different parts of the text (Titles, bodies, links),
and then write the style information as css (then cache it in a database), and then have it returned in the html that is
sent back from atlatler. However, the wordpress plug-in library might be able to make our plug-in blend in nicely,
automatically. I don't know so you'll need to find out.



