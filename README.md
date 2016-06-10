# WP Jump Links

This Wordpress plugin easily allows you to create short trackable redirect urls.

## Installation

There is a zip file in the /dist folder which you can upload to your instance of Wordpress. After you activate this plugin, you'll see a link on the wordpress admin menu to "Jump Links". That page is where you will create your trackable short links.

## Features

### Patternizing URLs

When you create a new trackable short link, the URL generated follows a specific hash pattern:

Key: a = letter; # = number; x = letter or number;

Pattern: yoursiteurl.com/a#xxxxxx

This pattern will be distinguishable between your WP post and page names, as well as post formats so it should never conflict with any asset you've created in wordpress.

Because this is a specific pattern, the plugin only makes calls to the database to determine where to direct the user when it matches this pattern, so it runs without slowing down your web server. AND, thusly, you can only create redirects in this pattern.

### Bot protection

You may or may not know that there are hundreds of bots that follow every link on your website. If you post these short links on your WP site, I have set up a filter to prevent most bots by detecting its user agent. This is not fool proof, but it's better than nothing.
