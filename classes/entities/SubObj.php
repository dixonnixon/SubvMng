<?php
Class SubObj extends AbstractEntity implements ISubObj
{
    protected  $_id;
    protected  $_name;
    protected  $_budget;
    protected  $_perm;
    protected  $_year;
    protected  $_sum;
	
	
	public static function fromState(array $state) 
	{
		$entity = new static();
		
		$entity	->	setId($state["id"]);
		$entity	->	setName($state["name"]);
		$entity	->	setBudget($state["budg"]);
		$entity	->	setPerm($state["perm"]);
		$entity	->	setYear($state["year"]);
		$entity	->	setSum($state["sum"]);

		return $entity;
	}
	
	public function setPerm($perm) {
		$this->_perm = $perm;
	}
	
	public function getPerm() {
		return $this->_perm;
	}

    public function setId($id) 
    {
		// print_r($this->_id);
        // if ($this->_id !== null) {
            // throw new BadMethodCallException(
                // "The ID has been set already.");
        // }
     
        // // var_dump($id);
        // // if (!is_int($id) || $id < 1) {
        // //     throw new InvalidArgumentException("The user ID is invalid.");
        // // }
 
        $this->_id = $id;
        return $this;
    }
    
    public function getId() 
    {
        return $this->_id;
    }

    public function setName($name)
    {
		if(!is_string($name)
			|| strlen($name) < 2
			|| strlen($name) > 1500) 
		{
			throw new InvalidArgumentException(
			'Назва не вірна! Надто довга або короткувата');	
		}
        $this->_name = htmlspecialchars(trim($name),
		ENT_QUOTES);
    }

    public function getName()
    {
        return $this->_name;
    }
	
	public function setBudget(IBudget $budg) {
		$this->_budget = $budg;
	}
    public function getBudget() {
		return $this->_budget;
	}
	
	public function setYear($year) {
		$this->_year = $year;
	}
    public function getYear() {
		return $this->_year;
	}
	
	public function setSum($sum) {
		$this->_sum = $sum;
	}
    public function getSum() {
		return $this->_sum;
	}
	
	
}

?>