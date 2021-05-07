<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as 
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Plugin' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'Model' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'View' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'Controller' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'Model/Datasource' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'Model/Behavior' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'Controller/Component' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'View/Helper' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'Vendor' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'Console/Command' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

if($_SERVER['SERVER_PORT'] == 443)
    {
        define('ROOTPATH', 'https://' . $_SERVER['HTTP_HOST'] . substr( $_SERVER['SCRIPT_NAME'], 0, -21));
    }
else
    {
        define('ROOTPATH', 'http://' . $_SERVER['HTTP_HOST'] . substr( $_SERVER['SCRIPT_NAME'], 0, -21));
    }

 if(($_SERVER['HTTP_HOST'] == 'hercules.softwaytechnologies.com') || ($_SERVER['HTTP_HOST'] == 'hercules.softwaydev.com'))
    { 
        $storePath = $_SERVER['DOCUMENT_ROOT'].'/common_arrival/app/webroot/files/';
		define('facebook_api_key','452145481488758');
        define('facebook_secret_key','e51fa6d22d02dd5a44c55731bc40b8fb');
        define('APP_URL','apps.facebook.com/common_arrival/');
    }
else
    {
        $storePath = $_SERVER['DOCUMENT_ROOT'].'/common_arrival/trunk/site/app/webroot/files/';
        define('facebook_api_key','173543099448860');
        define('facebook_secret_key','a9a682f23a79b8f5be0f53b3e1cb6147');
        define('APP_URL','apps.facebook.com/common_arrival_local/');

    }
Configure::write('Twitter.consumer_key', 'LWcfEZfoEk8EK1VR4z8bNg');
Configure::write('Twitter.consumer_secret', 'akAhwZkF4yneJmnFM8mzvbWL1xc3EDWmzd8CVFzP4');

define('ADMIN_EMAIL', 'alin@softwaysolutions.net');

/* The below YelpApi constant is to define whether to enable the yelp actual data or yelp test data
 * 1 refers to yelp actual data
 * 2 refers to yelp test data
 * */
Configure::write('YelpApi', '2');

// Api keys for yelp keys
define('CONSUMER_KEY', 'WSg3UR4zXz0LebVZX0pXHA');
define('CONSUMER_SECRET', 'nr-LZ3aFzO5DOF0-zgg8uOxdsMM');
define('TOKEN', 'R-36kegxeEyl1jCF6mgYBmfgoK44TsIR');
define('TOKEN_SECRET', '5yd5WkRLgfCM8YbhaIacMv9sPeI');
define('SITE_SUPPORT_EMAIL', 'rupam.jyoti@softwaysolutions.net');
define('ywsid', 'MHX845CrZi0NUwNoq9BnAQ');

  Configure::load('config');

  
  
  /**
 * Wraps ternary operations. If $condition is a non-empty value, $val1 is returned, otherwise $val2.
 * Don't use for isset() conditions, or wrap your variable with @ operator:
 * Example:
 *
 * `ife(isset($variable), @$variable, 'default');`
 *
 * @param mixed $condition Conditional expression
 * @param mixed $ifNotEmpty Value to return in case condition matches
 * @param mixed $ifEmpty Value to return if condition doesn't match
 * @return mixed $ifNotEmpty or $ifEmpty, depending on whether $condition evaluates to a non-empty expression.
 */

    function ife($condition, $ifNotEmpty, $ifEmpty) 
    {
        if (!empty($condition)) {
            return $ifNotEmpty;
        }
        return $ifEmpty;
    }
	
	
/**
 * Function to get the first element of the array:
 * Example:
 *
 * `array_first_key(@$variable);`
 *
 * @param 	array $array Input array
 * @return 	string returns the array key of the first element
 */

    function array_first_key($array, $last = false) 
    {
        if (!empty($last)) {
            end($array);
        }
		else
		{
			reset($array);
		}
        return key($array);
    }
