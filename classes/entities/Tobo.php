<?php
Class Tobo extends AbstractEntity implements ITobo
{
    protected  $_tobo;
    protected  $_name;
	
	public static function fromState(array $state) 
	{
		$entity = new static();
		$entity->setTobo($state["tobo"]);
		$entity->setName($state["name"]);
		return $entity;
	}
	

    public function setTobo($tobo) 
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

    public function setName($name)
    {
		if(!is_string($name)
			|| strlen($name) < 2
			|| strlen($name) > 1500) 
		{
			throw new InvalidArgumentException(
			'Назва не вірна! Надто довга або короткувата ');	
		}
        $this->_name = htmlspecialchars(trim($name),
		ENT_QUOTES);
    }

    public function getName()
    {
        return $this->_name;
    }
	
	
}

?>