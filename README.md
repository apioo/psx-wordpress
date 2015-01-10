
PSX Wordpress gateway
===

## About

This project is only a sample how you could build an REST API around an existing
application with PSX. In this case we choose Wordpress but this sample is 
applicable to every other application. The project provides an REST API to 
retrieve and create an post. Also an documentation with examples is available. 
More informations about PSX at http://phpsx.org.

## Installation

At first you need an running installation of Wordpress. Then you have to create
the table wp_access_token.sql in the Wordpress database.

Upload the project to your web server and change the key "psx_url" defined in
the configuration.php to the absolute url of the public/ folder. Alternative you
could also create an vhost pointing to the public folder.
