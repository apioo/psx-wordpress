
PSX Wordpress gateway
===

## About

This project is a sample how you could build a REST API around an existing 
application with PSX. In this case we choose Wordpress but this sample is 
applicable to every other application. The project provides an OAuth2 protected 
REST API to retrieve, create, update and delete an post. More informations about 
PSX at http://phpsx.org.

## Installation

At first you need a running installation of Wordpress. Then you have to create
the table wp_access_token.sql in the Wordpress database.

Upload the project to your web server and change the key "psx_url" defined in
the configuration.php to the absolute url of the public/ folder. Alternative you
could also create a vhost pointing to the public folder.

## Usage

The API provides the following endpoints:

* `/posts`  
  * `GET`  
    Returns all available posts
  * `POST`  
    Creates a new post
* `/posts/:id`  
  * `GET`  
    Returns a single post
  * `PUT`  
    Updates a post
  * `DELETE`  
    Removes a post
* `/token`  
  * `POST`  
    OAuth2 endpoint to retrieve an access token
* `/documentation`  
  Automatic generated documentation of the API endpoints

### Example

An example response of an GET request to the `/posts` endpoint:

```json
{
    "entry": [
        {
            "id": "356a192b-7913-504c-9445-574d18c28d46",
            "content": "Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!",
            "title": "Hello world!",
            "excerpt": "",
            "status": "publish",
            "href": "http:\/\/127.0.0.1\/tests\/wordpress\/?p=1",
            "createdAt": "2015-02-24T19:22:43Z",
            "updatedAt": "2015-02-24T19:22:43Z",
            "commentCount": 1,
            "author": {
                "displayName": "test",
                "url": "",
                "createdAt": "2015-02-24T19:22:42Z"
            }
        }
    ]
}
```
