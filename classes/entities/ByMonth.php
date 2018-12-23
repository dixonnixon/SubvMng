<?php
Class ByMonth extends AbstractEntity implements IIncome
{

    protected  $_id;
    protected  $_month;
    protected  $_sum;
	
	public static function fromState(array $state) 
	{
		$entity = new static();
		
		$entity	->	setId($state["id"]);
		$entity	->	setMonth($state["month"]);
		$entity	->	setSum($state["sum"]);

		return $entity;
	}
	
	public function setId($id) 
    {
        if ($this->_id !== null) {
            throw new BadMethodCallException(
                "The ID has been set already.");
        } 
        $this->_id = $id;
        return $this;
    }
    
    public function getId() 
    {
        return $this->_id;
    }

	public function setMonth($month)
    {
        $this->_month = $month;
    }

    public function getMonth()
    {
        return $this->_month;
    }
	
	
    public function setSum($sum)
    {
        $this->_sum = $sum;
    }

    public function getSum()
    {
        return $this->_sum;
    }

}

?>