<?php

echo <<<THEADER
<div class="col-xs-12 col-sm-offset-2 col-sm-8">
	<div class="col-sm-12">
		<div class=well well-lg">
			 {$res["data"]["Budgets"][0]->getTobo()->getName()}
		 </div>
	<h1>Бюджети </h1>
	<table class="table table-striped table-hover text-center table-bordered"
		name="{$res["name"]}Table" 
		id="{$res["name"]}">
	<thead>
		<tr>
			<th></th>
			<th>Назва бюджету</th>
			<th>Код бюджету</th>
		</tr>
	</thead>
	<tbody>
THEADER;
		
foreach($res["data"]["Budgets"] as $numRow => $budget) {
	//echo "index.php?CRUD=Change&entity=".$res["name"]."&BudgetCode=".$budget->getCode();
	echo <<<ROW
<tr>
	<td>
		<a type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Редагувати" id="{$res["name"]}Change" href="index.php?CRUD=Change&entity=Budget&Tobo={$budget->getTobo()->getTobo()}&BudgetCode={$budget->getCode()}">
    	<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
		</a>
	</td>
	<td>{$budget->getName()}</td>
	<td>
		{$budget->getCode()}
		<a type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="right" title="Перегляд об'єктів по бюджету {$budget->getCode()}" id="{$res["name"]}List" href="index.php?CRUD=View&entity=Objects&Tobo={$budget->getTobo()->getTobo()}&BudgetCode={$budget->getCode()}">
			<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
		</a>
	</td>
</tr>
ROW;
}

echo <<<TFOOTER
</tbody>
	</table><br \>
	</div>
</div>
TFOOTER;
?>
	

