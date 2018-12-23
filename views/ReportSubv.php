<?php 
$date = date("Y.m.d");

echo 
<<<MAIN
<div class="col-xs-12 col-sm-12">
	<form class="form-inline" id="SummaryForm" role="form" name="{$res["vars"]["name"]}" action="{$res["vars"]["action"]}"  method="POST">
		<div class="row">
			<div class="col">
				<div class="form-group">
					<label class="control-label" id="dateReportLabel" for="monthReport">
							На дату
					</label>
					<input type="text" id="dateReport" class="form-control" name="dateReport" value="">
					<div class="form-group input-group" role="group">
						<input name="updateView" id="updateView" type="button" class="btn btn-success form-control" value="Оновити">
						<span class="input-group-addon btn-success disabled active">
						<span class="glyphicon glyphicon-refresh"></span>
						</span>
					</div>
					<div class="form-group input-group" role="group">
						<input name="submitReport" type="submit" class="btn btn-success form-control" value="Вивантажити">
						<span class="input-group-addon btn-success disabled active">
						<span class="glyphicon glyphicon-download-alt"></span>
						</span>
					</div>
				</div>		
			</div>		
		</div>		
	</form>
</div>
<div class="col-xs-12">&nbsp;</div>
<div class="col-xs-12  col-sm-12">
	<div class="row row-content">
			<div class="panel panel-default">
				<div class="panel-heading"></div>
				<div class="table-responsive">
				<table class="table table-striped table-hover text-center table-bordered" name="{$res["vars"]["name"]}Table" id="{$res["vars"]["name"]}Table" style="table-layout: fixed;">
					
					<thead>
						
						<tr>
							<th style="width: 10%;" rowspan="2">Код бюджету</th>
							<th style="width: 12%;" rowspan="2">Одержувач субвенції, адміністративно-територіальна одиниця</th>
							<th style="width: 30%;" rowspan="2">Назва об'єкту (заходу)</th>
							<th colspan="2">Передбачено розписом</th>
							<th colspan="2">Фактично перераховано</th>
							
							<th >Касові видатки місцевого бюджету</th>
						</tr>
						<tr>
							<th>на рік</th>
							<th>на вказану дату</th>
							<th>всього</th>
							<th>за місяць</th>
							<th></th>
							
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				</div>
				</div>
				<br \>
			</div>
		
	
</div>		
MAIN;

?>