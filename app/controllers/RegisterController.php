<?php

use Phalcon\Mvc\Controller;

class RegisterController extends Controller
{
    public function initialize()
    {
        $this->tag->setTitle('Sign Up');
    }
	
	public function indexAction()
	{
		//if($this->request->isPost()) H::v($this->request->getPost());
		if ($this->request->isPost())
		{
			$login = $this->request->getPost('login', array('string', 'alphanum'));
			$email = $this->request->getPost('email', 'email');
			$password = $this->request->getPost('password');
			
			$user = new User();
			$user->login = $login;
			$user->email = $email;
			$user->role = 'user';
			$user->password = $password;
			if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
				$user->sessionStart();
                $this->flash->success('Thanks for sign-up, injoy');
                return $this->response->redirect();
            }
		}
	}
}
