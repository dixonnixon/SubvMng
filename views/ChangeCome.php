<?php 
// print_r($res["data"]["Come"]);

echo 
<<<FORM
<div class="col-xs-12 col-sm-10">
	<form class="form-horizontal" role="form" name="{$res["vars"]["name"]}" action="{$res["vars"]["action"]}" method="POST">
		<div class="row row-content">
			<div class="form-group">
				<label class="col-sm-4 control-label" id="{$res["vars"]["name"]}sumLabel" for="{$res["vars"]["name"]}sum">
					Сума 
				</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="{$res["vars"]["name"]}sum" name="{$res["vars"]["name"]}sum" value="{$res["data"]["Come"][0]->getSum()}"> 
				</div>
				<div class="col-sm-12">
					&nbsp;
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label" id="{$res["vars"]["name"]}dateLabel" for="{$res["vars"]["name"]}date">
					Дата 
				</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="{$res["vars"]["name"]}date" name="{$res["vars"]["name"]}date" value="{$res["data"]["Come"][0]->getDate()}" disabled> 
				</div>
				<div class="col-sm-12">
					&nbsp;
				</div>
			</div>
		</div>
		
		<div class="col-sm-3 col-md-offset-7" id="submit">
			<div class="form-group input-group" role="group">
				<input name="submit" type="submit" class="btn btn-success form-control" value="Змінити">
				<span class="input-group-addon btn-success disabled active">
				<span class="glyphicon glyphicon-ok-sign"></span>
				</span>
			</div>
		</div>		
	</form>
</div>
<div class="col-xs-12 col-sm-6">
	&nbsp;
</div>
FORM;
?>