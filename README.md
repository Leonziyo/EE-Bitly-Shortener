# EE-Bitly-Shortener
Transforms URL to bitly short form through bitly API.

# Installation

All you need to do to set it up is to edit this file:

bitlys/pi.bitlys.php

look for $access_token and set it to your bitly access token.

You can obtain your bitly access token by going to this page and type in your bitly password:

https://bitly.com/a/oauth_apps

After that just move the bitlys directory into the thrid_party directory in your 
Expression engine installation.

# Usage

Just pass a URL parameter to the template like shown below and it
will return the bitly shortened version.

{exp:bitlys:transform url="http://example.com"}

After running this in a template you will get a bitly url:

http://bit.ly/1LKKKyz

