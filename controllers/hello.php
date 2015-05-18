<?php

Class Hello extends Controller {
  static function index() {
    echo Hello::view('hello_view',
      array('message' => 'Hail Hyrdra!',
      	    'link' => '/hello/say/hello',
      	    'link_text' => 'Say Hello'));
  }

  static function say($message='') {
    echo Hello::view('hello_view',
      array('message' => $message,
            'link' => '/hello',
            'link_text' => 'Go Back'));
  }
}
