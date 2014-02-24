<?php

require_once 'config.php';

global $cfg;
global $db;

class Controller {
	static function model($name) {
		require_once 'models/'.$name.'.php';
		$model = new $name;
		return $model;
	}

	static function view($name, $params = array()) {
		$template = 'views/'. $name .'.php';
        extract($params);
        ob_start();
        include_once $template;
        return ob_get_clean();
	}
}

class Model {
    protected $pdo;
    function __construct() {
        global $db;
        $this->pdo = new PDO($db['adapter'].':host='.$db['host'].';dbname='.$db['name'],$db['user'],$db['password']);
        $this->pdo->exec("SET NAMES utf8");
    }
    function exec($sql, $params = array()) {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll();
    }
}

$controller = $cfg['controller_main'];
$action = 'index';
$params = array();

$uri = ($_SERVER['REQUEST_URI']);
$segments = explode('/', $uri);

if (isset($segments[1]) && $segments[1] != '') $controller = $segments[1];
if (isset($segments[2]) && $segments[2] != '') $action = $segments[2];
if (isset($segments[3]) && $segments[3] != '') $params = array_slice($segments, 3);

$path = 'controllers/' . $controller . '.php';

if (!file_exists($path)) { echo Controller::view($cfg['view_error']); exit(); }

require_once $path;

if (!method_exists($controller, $action)) { echo Controller::view($cfg['view_error']); exit(); }

call_user_func_array(array($controller, $action), $params);
