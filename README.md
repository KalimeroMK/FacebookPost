# Laravel Facebook Page Post
![GitHub License](https://img.shields.io/github/license/Nazmul7989/laravel-facebook-post?style=plastic)


This package allow to create, update, delete and get posts from facebook page in laravel application

## Requirements

- PHP >=7.4

## Installation
You can install the package via composer:

```
composer require kalimeromk/facebook-post
```
## Configuration
You can publish the configuration file `config/facebook.php` optionally by using the following command:
``` 
php artisan vendor:publish --tag=config --provider="Kalimeromk\FacebookPost\FacebookPostServiceProvider"
```

Configure `.env` file
```
FACEBOOK_PAGE_ID=your_facebook_page_id
FACEBOOK_ACCESS_TOKEN=your_facebook_access_token
```

## Usage

### Get All posts
``` 
use Kalimeromk\FacebookPost\Facades\FacebookPost;

$response = FacebookPost::getPost();
```

### Create Text post
``` 
use Kalimeromk\FacebookPost\Facades\FacebookPost;

FacebookPost::createPost('Hello, this is a test post!');

```

### Create Text post with photo
``` 
use Kalimeromk\FacebookPost\Facades\FacebookPost;

FacebookPost::createPhotoPost('Check out this photo!', '/path/to/photo.jpg');
```
### Create Text post with video
``` 
use Kalimeromk\FacebookPost\Facades\FacebookPost;

FacebookPost::createVideoPost('Watch this video!', '/path/to/video.mp4');
```
### Update  post
``` 
use Kalimeromk\FacebookPost\Facades\FacebookPost;

FacebookPost::updatePost('post_id_here', 'Updated post message.');
```

### Delete  post
``` 
use Kalimeromk\FacebookPost\Facades\FacebookPost;

FacebookPost::deletePost('post_id_here');
```

### Example Success Response
``` 
array:4 [
  "status" => "success"
  "status_code" => 200
  "message" => "Post created successfully"
  "post_id" => "103408372435470_395802394384938"
]
```

### Example Failure Response
``` 
array:3 [
  "status" => "fail"
  "status_code" => 422
  "message" => "Message is required"
]
```

## Limitations
- You can update only the text of a post. Image is not updatable.
- Multiple image upload is not supported.
- Video upload is not supported

### How to generate access token?
1. At first create a business type facebook app. Create app from [Facebook Deveoper Panel](https://developers.facebook.com/)
2. Go to Facebook [Graph Api Explorer](https://developers.facebook.com/tools/explorer/)
3. Here you will see three select option:
- Meta App
- User or Page
- Permissions
4. `Meta App`: Here you will see all facebook app that you have created. Select your business type app from the dropdown list.
5. `User or Page`: Here you need to select page access token. Then it will redirect you to your facebook page list. Select your preferred page and give necessary permission.
6. `Permissions`: Please select the following permission from this permission list
- `pages_show_list`
- `pages_read_engagement`
- `pages_manage_engagement`
- `pages_manage_posts`
- `pages_read_user_content`

7. Finally click on the Generate Access Token button and it will generate temporary access token for one hour.

8. If you want to make this token as long lived, you need to go [Access Token Debugger](https://developers.facebook.com/tools/debug/accesstoken/). Insert the access  token and click on the `Debug` button. Then it will show token information. Scroll down this page and you will see `Extend Access Token`. Click on this button and it will generate long lived access token.Then copy the access token and use this as `FACEBOOK_ACCESS_TOKEN`

### Note:
If you want to generate never expiry access token, you need to follow this step:

- Please open an api testing tool like Postman and send a get request by using this url `https://graph.facebook.
com/v22.0/{app-scoped-user-id}/accounts?access_token={long-lived-user-access-token}`. If you want to generate user 
  access token instead of page access token, just select user access token from `User or Page` section that i have mentioned in step 5.
- Extend expiry date of this user access token as like as page access token extend method that i have mentioned in step 8.
- Then debug this `long-lived-user-access-token` and you will get `app-scoped-user-id` from this debug information.
- Finally send get request to this url `https://graph.facebook.com/v22.0/{app-scoped-user-id}/accounts?access_token=
{long-lived-user-access-token}`. Now You will get never expiry page access token from this request and use this access token as `FACEBOOK_ACCESS_TOKEN`

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

### See [Facebook Page Api](https://developers.facebook.com/docs/pages-api) for more details

### See [Facebook Long Lived Access Token](https://developers.facebook.com/docs/facebook-login/guides/access-tokens/get-long-lived) for more details