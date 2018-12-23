<?php
// // print_r($res["data"]["Object"]);
// print_r($res["data"]["Object"]->getName());
// echo "<pre>";

// print_r($res["data"]["Rems"]);
// print_r($res["data"]["Provs"]);
// echo "</pre>";



$remsIncomes = array();



echo
<<<MAIN
<div class="row row-content">
	
</div>
<div class="row row-content">
	<div class="col-sm-offset-2 col-sm-8">
		<div class="well well-md">
			{$res["data"]["Object"]->getName()}
		</div>
	</div>
	<div class="col-xs-3 col-xs-offset-1 col-sm-offset-2 col-sm-4">
		<h2>Дані по об'єкту</h2>
	</div>
	<div class="col-sm-6">	
		<a type="button" id="Add" class="btn btn-info btn-lg" data-tooltip="tooltip" data-placement="right" title="Додати об'єкт"  id="{$res["vars"]["name"]}Add" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#add{$res["vars"]["name"]}Modal">
			<span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span>
		</a>
	</div>
</div>
<div class="container">
MAIN;

if(!empty($res["data"]["Rems"])) {
	echo 
<<<CONTENT

<br \>
<div class="row row-content">
	<div class="col-xs-12 col-md-offset-1 col-sm-12 col-md-10">
		<div class="panel panel-default">
		<div class="panel-heading"></div>
		<div class="table-responsive">
		<table class="table table-striped table-hover text-center table-bordered" name="{$res["vars"]["name"]}Table" id="{$res["vars"]["name"]}Table" style="table-layout: fixed;">
			<thead>
				<tr>
					<th></th>
					<th>Дата</th>
					<th>Сума на рік</th>
					<th>Фонд</th>
					<th>Видатки по МБ</th>
				</tr>
			</thead>
			<tbody>
			
CONTENT;
	foreach($res["data"]["Rems"] as $n => $rem) {
		$year = substr($rem->getDate(), 0, 4);
				
		echo 
<<<TR
	<tr>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=Change&entity={$res["vars"]["name"]}&incId={$rem->getInc()}">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</a>
		</td>
		<td>{$rem->getDate()}</td>
		<td>{$rem->getSum()}</td>
		<td>{$rem->getFond()}</td>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity=OutcomesByMonth&incId={$rem->getInc()}&year={$year}">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</td>
	</tr>
TR;
	}
	echo <<<CONTENTEND

		
			</tbody>
		</table>
		</div>
		</div>
	<br \>
	</div>
</div>	
CONTENTEND;
}

if(!empty($res["data"]["Provs"])) {
	
	
	echo 
<<<CONTENT

<br \>
<div class="row row-content">
	<div class="col-xs-12 col-md-offset-1 col-sm-12 col-md-10">
		<div class="panel panel-default">
		<div class="panel-heading"></div>
		<div class="table-responsive">
		<table class="table table-striped table-hover text-center table-bordered" name="{$res["vars"]["name"]}Table" id="{$res["vars"]["name"]}Table" style="table-layout: fixed;">
			<thead>
				<tr>
					<th></th>
					<th>Дата</th>
					<th>Передбачено розписом на рік</th>
					<th>Передбачено розписом на місяць</th>
					<th>фактично перераховано</th>
					<th>видатки по МБ</th>
				</tr>
			</thead>
			<tbody>
			
CONTENT;
	foreach($res["data"]["Provs"] as $n => $rem) {
		$year = substr($rem->getDate(), 0, 4);
		echo 
<<<TR
	<tr>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=Change&entity={$res["vars"]["name"]}&incId={$rem->getInc()}">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</a>
		</td>
		<td>{$rem->getDate()}</td>
		<td>{$rem->getSum()}</td>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity=ProvidedByMonth&incId={$rem->getInc()}&year={$year}">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</td>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity=FactByMonth&incId={$rem->getInc()}&year={$year}">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</td>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity=OutcomesByMonth&incId={$rem->getInc()}&year={$year}">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</td>
		
	</tr>
TR;
	}
	echo <<<CONTENTEND

		
			</tbody>
		</table>
		</div>
		</div>
	<br \>
	</div>
</div>	
CONTENTEND;
}


?>