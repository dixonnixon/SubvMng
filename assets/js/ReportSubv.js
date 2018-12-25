(function(fn){
    if (!fn.map) fn.map=function(f){var r=[];for(var i=0;i<this.length;i++)if(this[i]!==undefined)r[i]=f(this[i]);return r}
    if (!fn.filter) fn.filter=function(f){var r=[];for(var i=0;i<this.length;i++)if(this[i]!==undefined&&f(this[i]))r[i]=this[i];return r}
})(Array.prototype);

Object.keys = Object.keys || (function () {
    var hasOwnProperty = Object.prototype.hasOwnProperty,
        hasDontEnumBug = !{toString:null}.propertyIsEnumerable("toString"),
        DontEnums = [
            'toString',
            'toLocaleString',
            'valueOf',
            'hasOwnProperty',
            'isPrototypeOf',
            'propertyIsEnumerable',
            'constructor'
        ],
        DontEnumsLength = DontEnums.length;

    return function (o) {
        if (typeof o != "object" && typeof o != "function" || o === null)
            throw new TypeError("Object.keys called on a non-object");

        var result = [];
        for (var name in o) {
            if (hasOwnProperty.call(o, name))
                result.push(name);
        }

        if (hasDontEnumBug) {
            for (var i = 0; i < DontEnumsLength; i++) {
                if (hasOwnProperty.call(o, DontEnums[i]))
                    result.push(DontEnums[i]);
            }
        }

        return result;
    };
})();

function formatDtSql(dt) {
	var dtF = dt.split('/');
	return dtF[2] + "-" + dtF[1] + "-" + dtF[0];
}

function getURLParam(strParamName){
	  var strReturn = "";
	  var strHref = window.location.href;
	  var bFound=false;
	  
	  var cmpstring = strParamName + "=";
	  var cmplen = cmpstring.length;

	  if ( strHref.indexOf("?") > -1 ){
	    var strQueryString = strHref.substr(strHref.indexOf("?")+1);
	    var aQueryString = strQueryString.split("&");
	    for ( var iParam = 0; iParam < aQueryString.length; iParam++ ){
	      if (aQueryString[iParam].substr(0,cmplen)==cmpstring){
	        var aParam = aQueryString[iParam].split("=");
	        strReturn = aParam[1];
	        bFound=true;
	        break;
	      }
	      
	    }
	  }
	if (bFound==false) return null;
	return strReturn;
}

function makeTwoDigit(num) {
	num = num.toString();
	if(num.length == 1) {
		return "0" + num;
	}
	return num;
}

function ucFirst(field) {
	return field.substr(0, 1).toUpperCase() + field.substr(1);
}

var getParams =  
			"?CRUD=Report"
		+  	"&entity=Subv";
// var cache = {};
var ajaxCall = function(date) {
			var chacheKey = date;
			var method = "&method=selectFn";
			var tobo = getURLParam("Tobo");
			
			if(getURLParam("Tobo") === '1800') {
				tobo = '0000';
			}
			
			// console.log(cache);
			// console.log(chacheKey);

			// if(!cache[chacheKey]) {
				// cache[chacheKey] = $.ajax({
			$.ajax({
				dataType: "json",
				url: 'index.php' + getParams + method,
				data: {
					"date" : 	date,
					"Tobo" : 	tobo
				},
				timeout: 15000
			})
				.done(ajaxSuccess)
				.pipe()
				.fail(function(jqXHR) {
						console.log(jqXHR);
						$("<span></span>").appendTo('.container').html('Шкода... Але виникла помилка : ' + jqXHR.status);
				});	
		}

function ajaxSuccess(data) {
	var $ObjectsTable = $('table#SubvTable tbody');
	console.log(data);
	
	if(data && data.length <= 0) {
		$ObjectsTable.html("");
		return;
	}
	
	var str = "";
	
	
	var total = $.map(data, function(obj, n) {
		
		if(obj["budgCode"] == '0' && obj["ObjName"] === 'Total') {
			console.log(obj);
			return obj;
		}
	});
	
	$.each(data, function(n, obj) {
		// console.log(obj);
		//пропускаєм суму по всим тобо
		// для вибору іншихх значень
		if(obj["budgCode"] == '0' && obj["ObjName"] === 'Total') {
			return;
		}
		
		// obj[0]["ToboName"] = obj[1]["ToboName"];
		
		var values = Object.keys(obj).map(function(e) {
			
			if (e == 'ObjName' && obj[e] == 'TotalBudg') {
				return "<b class='bolder'>Всього по бюджету</b>";
			} else if(e == 'budgCode') {
				return "<span class='breaker'>" + obj[e] + "</span>";
			} else {
				return obj[e];				
			}
		});
		
		// console.log(values);
		str+= '<tr><td>' + values.join('</td><td>') + '</td></tr>';
		// }
		
	});
	
	console.log(total);
	
	total[0]["budgCode"] = "";
	total[0]["ObjName"] = "<b>Всього</b>";
	
	
	
	var valuesTotal = Object.keys(total[0]).map(function(e) {
			return total[0][e];
	});
	
	
	
	str+= "<tr><td>" + valuesTotal.join('</td><td>') + "</td></tr>";
	
	// console.log(str);
	// console.log($ObjectsTable);
	$ObjectsTable.html(str);
	
	$($ObjectsTable).find('b.bolder').closest('tr').find('td').css({"font-weight" : "bold"});
	
}



$(document).ready(function() {
	window.broker = $({});
	var $dateReport = $("#dateReport");
	console.log("YABADA");

	$.getScript("assets/js/setup/datePickerSetup.js")
			.done(function(script, status) {
				$dateReport.val(currentSlashDate());
				
				$dateReport.datepicker({
					minDate: new Date(2018, 1, 1),
					maxDate: new Date(2019, 0),
					onSelect: function(d, i) {
						console.log(d);
						ajaxCall(
							formatDtSql(d)
						);
					}
				});

				
				
				$formValues = $('form').serializeArray();
				
				// console.log($formValues);
				
				
				ajaxCall(
					formatDtSql($formValues[0]["value"])
				);
		});
	
	
	
	
	$(' #monthReport ').css({
		width: "1em"
	});
	$(' #yearReport ').css({
		width: "3em"
	});
	
	$(' #dayReport ').css({
		width: "3em",
		height: "3em"
	});
	
	
	
});

