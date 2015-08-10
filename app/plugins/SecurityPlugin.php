<?php

use Phalcon\Mvc\User\Plugin;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
	public function beforeExecuteRoute($event, $dispatcher)
	{
	
		$role = User::getRole($this->getDi());
        // $auth = $this->session->get('auth');
        // if (!$auth) {
            // $role = 'guest';
        // } else {
            // $role = 'user';
        // }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        // ѕолучаем список ACL
        $acl = $this->_getAcl();

        // ѕровер€ем, имеет ли данна€ роль доступ к контроллеру (ресурсу)
        $allowed = $acl->isAllowed($role, $controller, $action);
        if ($allowed != Phalcon\Acl::ALLOW) {

            // ≈сли доступа нет, перенаправл€ем его на контроллер "index".
            $this->flash->error("You don't have access to this module");
            $this->response->redirect();

            // ¬озвраща€ "false" мы приказываем диспетчеру прекратить текущую операцию
            return false;
        }
	}
	
	protected function _getAcl()
	{
		$acl = new Phalcon\Acl\Adapter\Memory();
		$acl->setDefaultAction(Phalcon\Acl::DENY);
		$roles = array(
			'user' => new Phalcon\Acl\Role('user'),
			'guest' => new Phalcon\Acl\Role('guest')
		);
		foreach ($roles as $role) {
			$acl->addRole($role);
		};
		
		$privateResources = array(
			'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
			'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
		);
		foreach ($privateResources as $resource => $actions) {
			$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
		};
		
		$publicResources = array(
			'index' => array('index'),
			'session' => array('index', 'register', 'start', 'end'),
			'products' => array('index',),
			'register' => array('index',),
		);
		foreach ($publicResources as $resource => $actions) {
			$acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
		};
		
		foreach ($roles as $role) {
			foreach ($publicResources as $resource => $actions) {
				$acl->allow($role->getName(), $resource, '*');
			}
		}

		// ƒоступ к приватным ресурсам предоставл€ем только пользовател€м
		foreach ($privateResources as $resource => $actions) {
			foreach ($actions as $action) {
				$acl->allow('user', $resource, $action);
			}
		}
		
		return $acl;
	}
}
