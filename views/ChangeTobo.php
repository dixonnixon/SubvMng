<?php
echo 
<<<FORM
<div class="col-xs-12 col-sm-6">
	<form class="formHorizontal" role="form" name="{$res["vars"]["name"]}" action="{$res["vars"]["action"]}" method="POST">
		<div class="row row-content">
			<div class="form-group">
				<label class="col-sm-1 control-label" id="{$res["vars"]["name"]}Label" for="{$res["vars"]["name"]}">
					Код
				</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="{$res["vars"]["name"]}" name="{$res["vars"]["name"]}" value="{$res["data"]->getTobo()}"> 
				</div>
				<div class="col-sm-12">
					&nbsp;
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 control-label" id="{$res["vars"]["name"]}NameLabel" for="{$res["vars"]["name"]}Name">
					Назва
				</label>
				<div class="col-sm-11">
					<textarea cols="20" rows="3" class="form-control" id="{$res["vars"]["name"]}Name" name="{$res["vars"]["name"]}Name">{$res["data"]->getName()}</textarea>\n
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			&nbsp;
		</div>
		<div class="col-sm-3 col-md-offset-8" id="submit">
			<div class="form-group input-group" role="group">
				<input name="submit" type="submit" class="btn btn-success form-control" value="Змінити Назву">
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