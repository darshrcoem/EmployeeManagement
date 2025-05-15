<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'username', 'password' => 'password'],
                    'userModel' => 'admin',
                ]
            ],
            'loginAction' => [
                'controller' => 'Admin',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'EmpData',
                'action' => 'display',
                $this->request->getSession()->read('Auth.admin.username'),
            ],
            'logoutRedirect' => [
                'controller' => 'Admin',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Admin',
                'action' => 'login',
            ]
        ]);
    }

   
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // Allow these actions without authentication
        $this->Auth->allow([
            'login',
            'signup',
            'display',
            'dashboard' // if you want to allow public display page
        ]);
    }
}
