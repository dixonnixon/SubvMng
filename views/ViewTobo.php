<?php
echo 
<<<HEAD
<div class="col-xs-12 col-sm-offset-2 col-sm-8">
	<div class="col-sm-12">
	<h1>Управління державного казначейства</h1>
	<table class="table table-striped table-hover text-center table-bordered"
		name="{$res["vars"]["name"]}Table"
		id="{$res["vars"]["name"]}">
	<thead>
		<tr>
			<th></th>
			<th>Назва</th>
			<th>Код</th>
		</tr>
	</thead>
	<tbody>
HEAD;
foreach($res["data"] as $numRow => $tobo) {
	echo 
<<<ROW
	<tr>
		<td>
			<a type="button" data-toggle="tooltip" data-placement="right" title="Редагувати назву"  class="btn btn-info btn-sm" id="{$res["vars"]["name"]}Change" href="index.php?CRUD=Change&entity={$res["vars"]["name"]}&Tobo={$tobo->getTobo()}">
			<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
			</a>
		</td>
		<td>{$tobo->getName()}</td>
		<td>
			{$tobo->getTobo()}
			<a type="button" data-toggle="tooltip" title="Переглянути бюджети для {$tobo->getTobo()}"  class="btn btn-info btn-sm" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity=Budgets&Tobo={$tobo->getTobo()}">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</td>
	</tr>
ROW;
			}
echo
<<<FOOT
	</tbody>
	</table><br \>
	</div>
	
</div>
FOOT;



?>

