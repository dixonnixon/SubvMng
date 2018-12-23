<?php
Class Budget extends AbstractEntity implements IBudget
{
    protected  $_code;
    protected  $_tobo;
    protected  $_name;
	
	public static function fromState(array $state) 
	{
		$entity = new static();
		$entity->setCode($state["budgCode"]);
		$entity->setTobo($state["tobo"]);
		$entity->setName($state["budgName"]);
		return $entity;
	}
	
	public function setCode($id) {
		if(strlen($id) <8) {
			throw new InvalidArgumentException(
			'Код бюджету занадто короткий');	
			return;
		}
		$this->_code = $id;
	}
	
    public function getCode() {
		return $this->_code;
	}
	
	public function setTobo(ITobo $tobo) 
    {
        if ($this->_tobo !== null) {
            throw new BadMethodCallException(
                "ТОБО вже задано");
        }
     
        $this->_tobo = $tobo;
        return $this;
    }
    
    public function getTobo() 
    {
        return $this->_tobo;
    }

    public function setName($budg)
    {
		if(!is_string($budg)
			|| strlen($budg) < 2
			|| strlen($budg) > 500) 
		{
			throw new InvalidArgumentException(
			'Назва не вірна! Надто довга або короткувата ');	
		}
        $this->_name = htmlspecialchars(trim($budg),
		ENT_QUOTES);
    }

    public function getName()
    {
        return $this->_name;
    }
	
	
}

?>