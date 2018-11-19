<?php
Class SubObj extends AbstractEntity implements ISubObj
{
    protected  $_id;
    protected  $_name;
    protected  $_income;
    protected  $_outcome;
    protected  $_date;

    public function setId($id) 
    {
        if ($this->_id !== null) {
            throw new BadMethodCallException(
                "The ID for this user has been set already.");
        }
     
        // var_dump($id);
        // if (!is_int($id) || $id < 1) {
        //     throw new InvalidArgumentException("The user ID is invalid.");
        // }
 
        $this->_id = $id;
        return $this;
    }
    
    public function getId() 
    {
        return $this->_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDate($date) 
    {
        if($date instanceof DateTime)
        {
            $this->_date = $date->format("Y-m-d h:i:s");
        }
    } 

    public function getDate() 
    {
        return $this->_date;
    } 
}

?>