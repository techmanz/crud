<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
	public function initialize()
    {
        $this->tag->setTitle('Products');
    }
	
	public function indexAction()
	{
		$products = Product::find();
		// $products = Product::query()
			// ->inWhere('status', array('ok', 'good'))
			// ->execute();
		
		$this->view->setVars(array(
			'products' => $products,
		));
	}
	
	public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $product = Product::findFirstById($id);
            if (!$product || User::getAuth()['id'] != $product->userId) {
                $this->flash->error("Product was not found or access deny");
                return $this->response->redirect("products/index");
            }
			
			$this->view->setVars(array(
				'product' => $product,
			));
        }
    }
	
	public function saveAction($id)
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect("products/index");
        }

        $id = $id*1;

        $product = Product::findFirstById($id);
        if (!$product || User::getAuth()['id'] != $product->userId) {
            $this->flash->error("Product does not exist  or access deny");
            return $this->response->redirect("products/index");
        }

		$name = $this->request->getPost('name', array('string', 'alphanum'));
		$status = $this->request->getPost('status', array('alphanum', 'lower'));
		$typeId = $this->request->getPost('typeId', 'int');
		$price = $this->request->getPost('price', 'int');
		
		$product->name = $name;
		$product->status = $status;
		$product->typeId = $typeId;
		$product->price = $price;

		if ($product->save() == false) {
			foreach ($product->getMessages() as $message) {
				$this->flash->error((string) $message);
				return $this->response->redirect("products/edit/{$id}");
			}
		} else {
			$this->flash->success('Product Saved');
		}
		
		return $this->response->redirect('products/index');
    }
	
	public function newAction()
	{
	
	}
	
	public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect("products/index");
        }

        $product = new Product();

		$name = $this->request->getPost('name', array('string', 'alphanum'));
		$status = $this->request->getPost('status', array('alphanum', 'lower'));
		$typeId = $this->request->getPost('typeId', 'int');
		$price = $this->request->getPost('price', 'int');
		
		$product->userId = User::getAuth()['id'];
		$product->name = $name;
		$product->status = $status;
		$product->typeId = $typeId;
		$product->price = $price;
		$product->created = time();

		if ($product->save() == false) {
			foreach ($product->getMessages() as $message) {
				$this->flash->error((string) $message);
				return $this->response->redirect("products/new");
			}
		} else {
			$this->flash->success('Product Saved');
		}
		
		return $this->response->redirect('products/index');
    }
	
	public function deleteAction($id)
    {
        $product = Product::findFirstById($id);
        if (!$product || User::getAuth()['id'] != $product->userId) {
            $this->flash->error("Product was not found");
            return $this->response->redirect("products/index");
        }

        if (!$product->delete()) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("products/index");
        }

        $this->flash->success("Product was deleted");
        return $this->response->redirect("products/index");
    }
}
