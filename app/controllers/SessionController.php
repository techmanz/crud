<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
	public function startAction()
	{
		if ($this->request->isPost())
		{
			$email = $this->request->getPost('email');
			$password = $this->request->getPost('password');
			
			$user = User::findFirst(array(
                "email = :email: OR login = :email:",
                'bind' => array('email' => $email, 'password' => $password)
            ));
			
			if ($user != false && $this->security->checkHash($password, $user->password)) {
                $user->sessionStart();
                $this->flash->success('Welcome ' . $user->getName());//
                return $this->response->redirect();
            }
			
            $this->flash->error('Wrong email/password ');
		}
		
		return $this->response->redirect();
	}
	
	public function endAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
		return $this->response->redirect();
        // return $this->dispatcher->forward(array(
                // "controller" => "index",
                // "action"     => "index"
            // )
        // );
    }
}
