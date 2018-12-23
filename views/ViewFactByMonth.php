<?php
// print_r($res["data"]["OutcByMo"]);


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
		<h2>Фактично перераховано</h2>
	</div>
	<div class="col-sm-6">	
		<a type="button" id="Add" class="btn btn-info btn-lg" data-tooltip="tooltip" data-placement="right" title="Додати об'єкт"  id="{$res["vars"]["name"]}Add" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#add{$res["vars"]["name"]}Modal">
			<span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span>
		</a>
	</div>
</div>
<div class="container">
MAIN;

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
					<th>Місяць</th>
					<th>Сума по місяцю</th>
					<th>Перегляд</th>
				</tr>
			</thead>
			<tbody>
CONTENT;

foreach($res["data"]["OutcByMo"] as $n => $out) {
	echo 
<<<TR
	<tr>
		<td>{$out->getMonth()}</td>
		<td>{$out->getSum()}</td>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity={$res["vars"]["name"]}&incId={$out->getId()}&month={$out->getMonth()}&type=Fact">
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
?>