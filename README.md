chindogu.php
============

A one file high performance MVC PHP micro framework.

What is it?
-----------

Chindogu is basically [Codeigniter](https://github.com/EllisLab/CodeIgniter) in one file of 50 lines. But much faster.

Fast, how fast?
-----------

Very. It's so lightweight, that is probably the fastest MVC PHP Framework.

## Benchmarks

Running [Phalcon's](https://github.com/phalcon/framework-bench) benchmark suite with AB (Apache Bench), chindogu.php scores the highest in the hello world test.

1. chindogu.php: 1345.88 #Requests/sec (mean)
2. phalcon 1.3.3: 1327.99 #Requests/sec (mean)
3. yii 1.1.13: 530.82 #Requests/sec (mean)
4. codeigniter 2.1: 343.1 #Requests/sec (mean)
5. kohanna 3.2: 271.60 #Requests/sec (mean)

Installation
-----------

1. Download the latest version from [here](https://github.com/imagentleman/chindogu.php/releases/download/1/chindogu.php-master.zip).
2. Unzip and copy the files of the folder.
3. Paste them on Htdocs (for Apache) or your server's folder.

How does it work?
-----------

## File Structure

    /controllers
    /models
    /views
    index.php
    chindogu.php
    config.php

## Routing

The same Convention over Configuration scheme of Codeigniter is used.

Routes match one to one to controllers and actions.

In this url:

    http://example.com/watch/video/id

`watch` is the controller, `video` is the action and `id` is a parameter for the action (you can have multiple parameters like `http://example.com/watch/video/id/param2/param3`).

## Controllers

Controllers are just php files in the `controllers` folder, that define a class with a bunch of functions. Each funtion corresponds to an action.

For the previous examples, we would have a `/controllers/watch.php` file like this:

    Class Watch extends Controller {
      static function video($id) {
        // some php code
      }
    }

or like this:

    Class Watch extends Controller {
      static function video($id, $param2, $param3) {
        // some php code
      }
    }

The route, file name and class name must be the same (in this case `watch`).

## Views

Views are just php files with embedded html.

You could have a view located in `/views/hello_view.php` with something like this:

    <p>Hello World</p>

And you would use it from a controller like this:

    Class Watch extends Controller {
      static function video($id) {
        echo Watch::view('hello_view');
        // echo Controller::view('hello_view') you can also use the parent controller class
      }
    }

You can send variables to the view, so a view like this:

    <p><?= "The video is $video_id";></p>

Would be called from the controller like this:

    Class Watch extends Controller {
      static function video($id) {
        echo Watch::view('hello_view', array('$video_id' => $id));
      }
    }

## Models

Models use PDO with parametrized sql (parameters are optional). Only one function is available, named 'exec'.

A model in `/models/Watch_Model.php` would look like this:

    class Watch_Model extends Model {
    	function get_videos() {
    		return $this->exec('SELECT * FROM videos');
    	}
    	function get_video($id) {
    	  return $this->exec('SELECT * FROM videos WHERE id = :video_id', array(':video_id' => $id));
    	}
    }

And would be called from a controller like this:

    Class Watch extends Controller {
      static function video($id) {
        $watch_model = Watch::model('Watch_Model'); // you can also use Controller instead of Watch
        $video = $watch_model->get_video($id);
        echo Watch::view('hello_view', array('video' => $video));
      }
    }

Again, the file name and the class name have to match.

## index.php

This file just loads chindogu.php. It's structured like this for flexibility (you can do whatever you want before and after the framework is loaded). Alternatively, you can just rename chindogu.php to index.php and have just one file.

## config.php

Here you define you DB credentials and some default values (and everything you want, secret api keys, etc).

## .htaccess

Redirects every request to index.php (except for files, like your css or js) and makes the pretty urls possible (otherwise, every url would be prepended with index.php, like `http://example.com/index.php/watch/video/1`.

Acknowledgements
----------------

This is heavily inspired by [CodeIgniter](https://github.com/bcit-ci/CodeIgniter) and [PIP](https://github.com/gilbitron/PIP).
