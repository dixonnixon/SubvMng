<?php
Class Income extends AbstractEntity implements IIncome
{
    protected  $_sum;

    public function setSum($sum)
    {
        $this->sum = $_sum;
    }

    public function getSum()
    {
        return $this->_sum;
    }
}

?>