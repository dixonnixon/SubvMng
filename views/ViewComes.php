<?php
$s = $_GET["type"];
	switch ($s){
			case "FactIncomes":
			 $s1 = "Фактично перераховано";
			 break;
			case "ProvIncomes":
			 $s1 = "Передбачено розписом";
			 break;
			case "Outcomes":
			 $s1 = "Касові видатки МБ";
			 break;
        	default:
             $s1 = "";		
	
	}

// // print_r($res["data"]["Object"]);
// print_r($res["data"]["Object"]->getName());
// echo "<pre>";

// print_r($res["data"]["Rems"]);
// print_r($res["data"]["Provs"]);
// echo "</pre>";

// print_r($res["data"]["Comes"]);

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
		<h2>{$s1}</h2>
	</div>
	<div class="col-sm-6">	
		<a type="button" id="Add" class="btn btn-info btn-lg" data-tooltip="tooltip" data-placement="right" title="Додати об'єкт"  id="{$res["vars"]["name"]}Add" aria-haspopup="true" aria-expanded="false" data-toggle="modal" data-target="#addComesModal">
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
					<th></th>
					<th>Дата внесення</th>
					<th>Сума</th>
				</tr>
			</thead>
			<tbody>
CONTENT;


foreach($res["data"]["Comes"] as $n => $out) {
	$sum = substr($out->getSum(),0,strlen($out->getSum())-2);
	$dat = substr($out->getDate(),0,10);
	
	echo 
<<<TR
	<tr>
		<td>
			<a type="button" class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="right" title="Редагувати" id="{$res["vars"]["name"]}List" href="index.php?CRUD=Change&entity={$res["vars"]["name"]}&type={$_GET["type"]}&id={$out->getId()}">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</a>
		</td>
		<td>{$dat}</td>
		<td>{$sum}</td>
		<td>
			<a type="button" class="btn btn-danger btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=Delete&entity={$res["vars"]["name"]}&type={$_GET["type"]}&id={$out->getId()}">
				<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
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

echo 
<<<MODAL
<div class="modal fade" id="addComesModal" tabindex="-1" role="dialog" aria-labelledby="add{$res["vars"]["name"]}ModalLabel">
	<div class="modal-dialog modal-sm" role="document">
      <!-- Modal Content -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-add{$res["vars"]["name"]}-title">Введіть значення</h4>
			</div>
			<div class="modal-body">
				<form class="formHorizontal" role="form" name="add{$res["vars"]["name"]}Form" action="{$res["vars"]["action"]}" method="POST">
					<div class="row row-content">
						<div class="col-sm-12">
							
							<div class="form-group">
								<label class="col-sm-4 control-label" id="{$res["vars"]["name"]}ObjRegDtLabel" for="date">
									Дата
								</label>
								<div class="col-sm-8">
									<input type="text" class="form-control mod" id="date" name="date" value="">
								</div>
							</div>
							<div class="col-sm-12">
								&nbsp;
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" id="{$res["vars"]["name"]}SumLabel" for="{$res["vars"]["name"]}Sum">
									Сума
								</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="Sum" name="Sum" value="" placeholder="Введіть суму">
								</div>
							<div class="col-sm-12">
								&nbsp;
							</div>
							
							<button type="submit" id="addComes" name="addComes"  class="btn btn-success">Створити</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Відмінити</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

MODAL;
?>