<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Regex as RegexValidator;
use Phalcon\Mvc\Model\Validator\InclusionIn as InclusionInValidator;

class Product extends Model
{

	/* public function getSource()
	{
		return "products";
	} */
	
	public function initialize()
	{
		$this->setSource("products");
		
		$this->belongsTo("userId", "User", "id");
		$this->belongsTo("typeId", "Type", "id");
	}
	
	public function columnMap()
	{
		return array(
			'id' => 'id',
			'name' => 'name',
			'user_id' => 'userId',
			'type_id' => 'typeId',
			'status' => 'status',
			'price' => 'price',
			'created' => 'created',
		);
	}
	
	public function validation()
    {
		$this->validate(new RegexValidator(array(
            'field' => 'name',
			'pattern' => '/^[A-Za-z0-9_]{3,20}+$/',
			'message' => 'Sorry, The invalid name.'
        )));
		$this->validate(new RegexValidator(array(
            'field' => 'status',
			'pattern' => '/^[a-z0-9]{1,50}+$/',
			'message' => 'Sorry, The invalid status.'
        )));
		$this->validate(new InclusionInValidator(array(
            'field' => 'typeId',
			'domain' => $this->getValidTypes(),
			'message' => 'Sorry, The invalid type.'
        )));
		
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
	
	public function getValidTypes()
	{
		$types = Type::find();
		
		$array = array();
		foreach($types as $type)
			$array[] = $type->id;
		
		return $array;
	}
}
	