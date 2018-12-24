<?php 
// print_r($res["data"]["Objects"][0]->getId());

$tdPerm = array();
$thPerm = "";
foreach($res["data"]["Objects"] as $obj => $val) {
	
	$perm = $val->getPerm();
	
	// echo "<pre>";
	// print_r($perm);
	// // print_r($res["data"]["Tobo"]);
	// // print_r();
	// // $permitted = array_replace($res["data"]["Tobo"], $perm);
	// echo "</pre>";
	$permList = "";
	$opt = "";
	
	foreach($perm as $pTobo => $checked) {
		($checked == "0") 
			? $checked = "" :  
			$checked ="checked";
		($checked == "checked")
			? $gliph= "share" 
			: $gliph= "unchecked";
		$opt .=  
<<<OPT
		<li>
			<label class="dropdown-menu-item checkbox" data-value="{$pTobo}" tabIndex="-1">
				<input type="checkbox" {$checked}/>
				<span class="glyphicon glyphicon-{$gliph}">
				&nbsp;{$pTobo}
			</label>
		</li>
OPT;
	
	}
	unset($checked);
	$permList .=
<<<LIST
<div class="button-group">
	<div class="dropdown">
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" data-tooltip="tooltip" data-placement="right" title="змінити дозволи для ДКУ">
			<span class="glyphicon glyphicon-cog"></span> <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
LIST;
	$permList .= $opt . "</ul></div></div>";
	
	if(ControllerCreator::getTobo() == "1800"
	&& $val->getBudget()->getTobo()->getTobo() == "1800") {
		$tdPerm[$obj] = "<td>" . $permList . "</td>";
		$thPerm = "<th>Дозволи</th>";
	}
}




echo
<<<MAIN
<div class="row row-content">
	
</div>
<div class="row row-content">
	<div class="col-sm-offset-2 col-sm-8">
		<div class="well well-md">
			{$res["data"]["Budget"]->getTobo()->getName()}
		</div>
		<div class="well well-md">
			{$res["data"]["Budget"]->getName()}	 
		</div>
	</div>
	<div class="col-xs-3 col-xs-offset-1 col-sm-offset-2 col-sm-4">
		<h2>Об'єкти розвитку </h2>
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
					<th style="width: 7%;"></th>
					<th style="width: 30%;">Назва</th>
					<th>Передбачено розписом на рік</th>
					<th>Передбачено розписом</th>
					<th>Фактично перерахов.</th>
					<th>Касові видатки по МБ</th>
					{$thPerm}
					<th style="width: 7%;"></th>
				</tr>
			</thead>
			<tbody>
			
CONTENT;
foreach($res["data"]["Objects"] as $obj => $val) {
	$td = "";
	(!empty($tdPerm[$obj])) 
		? $td = $tdPerm[$obj] : "";
	$sum = substr($val->getSum(),0,strlen($val->getSum())-2);
    	
	echo 
<<<TR
	<tr>
		<td>
			<a type="button" class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="right" title="редагувати об'єкт" id="{$res["vars"]["name"]}List" href="index.php?CRUD=Change&entity=Object&Budget={$val->getBudget()->getCode()}&ObjId={$val->getId()}&type=ProvIncomes">
				<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			</a>
		</td>
		<td>{$val->getName()}</td>
		<td>{$sum}</td>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity={$res["vars"]["name"]}&Budget={$val->getBudget()->getCode()}&ObjId={$val->getId()}&type=ProvIncomes">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</td>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity={$res["vars"]["name"]}&Budget={$val->getBudget()->getCode()}&ObjId={$val->getId()}&type=FactIncomes">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</td>
		<td>
			<a type="button" class="btn btn-info btn-sm" data-tooltip="tooltip" data-placement="right" title="нарахування" id="{$res["vars"]["name"]}List" href="index.php?CRUD=View&entity={$res["vars"]["name"]}&Budget={$val->getBudget()->getCode()}&ObjId={$val->getId()}&type=Outcomes">
				<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
			</a>
		</td>
		{$td}
		<td>
			<a type="button" class="btn btn-danger btn-sm" data-tooltip="tooltip" data-placement="right" title="видалити об'єкт" id="{$res["vars"]["name"]}List" href="index.php?CRUD=Delete&entity={$res["vars"]["name"]}&Budget={$val->getBudget()->getCode()}&ObjId={$val->getId()}&type=Outcomes">
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
<div class="modal fade" id="add{$res["vars"]["name"]}Modal" tabindex="-1" role="dialog" aria-labelledby="add{$res["vars"]["name"]}ModalLabel">
	<div class="modal-dialog modal-md" role="document">
      <!-- Modal Content -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-add{$res["vars"]["name"]}-title">Виберіть параметр</h4>
			</div>
			<div class="modal-body">
				<form class="formHorizontal" role="form" name="add{$res["vars"]["name"]}Form" action="{$res["vars"]["action"]}" method="POST">
					<div class="row row-content">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-sm-3 control-label" id="{$res["vars"]["name"]}Label" for="{$res["vars"]["name"]}Name">
									Назва Об'єкту
								</label>
								<div class="col-sm-9">
									<textarea cols="20" rows="10" class="form-control" id="objName" name="objName" placeholder="Введіть  назву"></textarea>\n
								</div>
							</div>
							<div class="col-sm-12">
								&nbsp;
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" id="{$res["vars"]["name"]}Label" for="{$res["vars"]["name"]}Name">
									Розпис на рік
								</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="objSum" name="objSum" placeholder="Введіть суму"></input>\n
								</div>
							</div>
							<div class="col-sm-12">
								&nbsp;
							</div>
							<button type="submit" id="addObjSubmit" name="addObjSubmit"  class="btn btn-success">Створити</button>
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