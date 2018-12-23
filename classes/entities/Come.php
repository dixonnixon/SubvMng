<?php
Class Come extends AbstractEntity implements ICome
{
    protected  $_id;
    protected  $_objId;
    protected  $_date;
    protected  $_sum;
	
	public static function fromState(array $state) 
	{
		$entity = new static();
		
		$entity	->	setId($state["id"]);
		$entity	->	setDate($state["date"]);
		$entity	->	setSum($state["sum"]);
		$entity	->	setObjId($state["ObjId"]);

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

	public function setDate($date)
    {
        $this->_date = $date;
    }

    public function getDate()
    {
        return $this->_date;
    }
	
	
    public function setSum($sum)
    {
        $this->_sum = $sum;
    }

    public function getSum()
    {
        return $this->_sum;
    }
	
	
    public function setObjId($objId)
    {
        $this->_objId = $objId;
    }

    public function getObjId()
    {
        return $this->_objId;
    }
	
}

?>