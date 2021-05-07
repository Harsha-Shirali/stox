<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	 public $components = array(
         'Api' => array(),
         'Email' => array(),
         'Session' ,
         /*'DebugKit.Toolbar',*/
         'RequestHandler' => array(),

        'Auth' => array(
            'loginAction' => array(
                'admin' => false,
                'controller' => 'users',
                'action' => 'login'
            ),
            'authError' => 'Your session has ended due to inactivity.  Please login to continue.',
            'loginError' => 'Login Error..!',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'username','password'=>'password')
                ),
                'all' => array(
                    'userModel' => 'User',
                //    'scope' => array('User.status' => array('1')                )
                )
            ),'authorize' => 'Controller'
        )
    );


    public $helpers = array('Html', 'Form');



    function beforeRender() {
        parent::beforeRender();
        if($this->request->is('mobile'))
		{
			$this->layout = "";
		}
        
        
    }
	
	  /**
     * Called before the controller action.
     *
     * @access public
     * @category core
     * @see http://book.cakephp.org/2.0/en/controllers.html#controller-life-cycle
     * @author Annamalai
     */
    function beforeFilter() {
        sleep(1);
        parent::beforeFilter();

        //disable security
        //$this->Security->enabled = false;
        //tell Auth to call the isAuthorized function before allowing access 
        $this->Auth->authorize = array('Controller');

        //allow all non-logged in users access to items without a prefix 

        if (!isset($this->params['prefix']))
            $this->Auth->allow('');
			$this->_checkAuth();
 
    }

    /**
     * Auth function  
     *
     * Check if the user is logged in or not and perform acl action
     * 
     * @return void
     * @category core
     * @author Annamalai
     */
    function isAuthorized($user) {

        return true;
    }

    /**
     * Function to allow the non login pages
     * * @access 	Private
     * @author 		Annamalai
     */
    function _checkAuth() {

        $exception_array = array(
            'apis/index',
            'users/login',
            'users/logout',
            '/users/admin_logout',
            'users/admin_login',
            'users/setnewpassword',
            'shares/update_stocks',
            
        );

        $cur_page = $this->params['controller'] . '/' . $this->params['action'];


        if (!in_array($cur_page, $exception_array)) {
            if (!$this->Auth->user('id')) {


                $this->redirect(array(
                    'admin'=>true,
                    'controller' => 'users',
                    'action' => 'login',
                    'f' => base64_encode($this->params->url)
                ));
            }
        } else {

            $this->Auth->allow();
        }
    }
    
  /*function sendMail($template = null, $to_email = null, $from_email = null, $subject = null, $contents = array()) {
        $from_email = Configure::read('site.support_email');
        $email = new CakeEmail();
        $result = $email->template($template, 'default')
                ->emailFormat('html')
                ->to($to_email)
                ->from($from_email)
                ->subject($subject)
                ->viewVars($contents);
        if ($email->send('default')) {
            return true;
        }
        return false;
    }
	*/
}
