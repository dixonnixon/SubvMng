// function getURLParam(strParamName){
	  // var strReturn = "";
	  // var strHref = window.location.href;
	  // var bFound=false;
	  
	  // var cmpstring = strParamName + "=";
	  // var cmplen = cmpstring.length;

	  // if ( strHref.indexOf("?") > -1 ){
	    // var strQueryString = strHref.substr(strHref.indexOf("?")+1);
	    // var aQueryString = strQueryString.split("&");
	    // for ( var iParam = 0; iParam < aQueryString.length; iParam++ ){
	      // if (aQueryString[iParam].substr(0,cmplen)==cmpstring){
	        // var aParam = aQueryString[iParam].split("=");
	        // strReturn = aParam[1];
	        // bFound=true;
	        // break;
	      // }
	      
	    // }
	  // }
	// if (bFound==false) return null;
	// return strReturn;
// }

// function makeTwoDigit(num) {
	// num = num.toString();
	// if(num.length == 1) {
		// return "0" + num;
	// }
	// return num;
// }

// function ucFirst(field) {
	// return field.substr(0, 1).toUpperCase() + field.substr(1);
// }

// function urlSplit(url) {
	// var mG = {};
	// url.split('&').map(function(m) {
		// var sp = m.split('=');
		
		// Object.defineProperty(mG, sp[0], {value: sp[1]});
		// // console.log(mG);
		
		// return mG;
	// });
		
	// return mG;
// }

// function getYear() {
	
		// var currentYear = new Date().getFullYear();
		// return  getURLParam("year") || currentYear;
	
// }

(function($) {
	$(document).ready(function() {
		
		
		var options = [];

		$( '.dropdown-menu li' ).on( 'click', function( event ) {
			var $checkbox = $(this).find('.checkbox');
			if(!$checkbox.length) {
				return;
			}
			
			var $inp = $checkbox.find('input');
			var $ic = $checkbox.find('span.glyphicon');
			
			if($inp.is(':checked')) {
				$inp.prop('checked', false);
				$ic.removeClass('glyphicon-share')
					.addClass('glyphicon-unchecked');
			} else {
				$inp.prop('checked', true);
				$ic.removeClass('glyphicon-unchecked')
					.addClass('glyphicon-share');
			}
			
			return false;
		   // var $target = $( event.currentTarget ),
			   // val = $target.attr( 'data-value' ),
			   // $inp = $target.find( 'input' ),
			   // idx;

		   // if ( ( idx = options.indexOf( val ) ) > -1 ) {
			   // console.log(options.indexOf( val ));
			  // options.splice( idx, 1 );
			  // setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
		   // } else {
			  // options.push( val );
			  // setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
		   // }

		   // $( event.target ).blur();
			  
		   // console.log( options );
		   // return false;
		});
		
		// $.each($('table thead  th'), function() {
			// console.log($(this).height());
			// // $(this).css({"height": "20px"});
			// $(this).css({
				// "height": "20px", 
				// "line-height": "15px"
			// });
			// $(this).height("20px");
		// });
		
		// $('td').css({overflow: "hidden"});
		// //контейнер для обробника подій
		// window.broker = $({});
		
		// function checkDeleteButton() {
			// $('table').on('click', 'a#ObjectRemove', function(event) {
				// event.preventDefault();
				// var href = $(this).attr('href').split('?')[1];
				// var obj = urlSplit(href);
				// var message = {ObjID: obj.ObjID};
				
				// broker.year = obj.year;
				// broker.FondType = obj.FondType;
				
				// broker.trigger('deleteObj', [message]);
			// });
		// }
		
		// checkDeleteButton();
		
		// broker.on('triggerDeleteByButton', function(event, message) {
			
		// });
		
		
		
		// $('[data-tooltip="tooltip"]').tooltip();
		
		// var $ObjectsTable = $('table#SubObjTable tbody');
		
		
		// function ajaxSuccess(data) {
			// console.log(data);
			// console.log("INSIDE AJAX!!!!!!!!!!!!!!!");
			// var str = "";
			
			// //обхід об'єктів 
			// $.each(data, function(n, obj) {
				// console.log(obj);
				// // console.log(year);
				// str += "<tr><td><a type='button' class='btn btn-info btn-sm' id='ObjectsChange' href='index.php?CRUD=Change&entity=Object" 
				// + "&Tobo=" + obj.tobo + "&ObjID=" + obj.id 
				// + "'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td>";
				
				// //обхід об'єкту для формування комірок
				// $.each(obj, function(idx, data) {
					// //вставляєм назву
					// if(idx == "name") {
						// str += '<td id="' + idx + '">' + obj[idx] + '</td>'; 
					// }
				// });
					
				// str += "<td><a type='button' class='btn btn-info btn-sm' id='ObjectList' href='index.php?CRUD=Pereglyad&entity=ObjectMonths&Tobo=" 
				// + obj["Tobo"] + "&ObjID=" 
				// + obj["ObjID"] + "'><span class='glyphicon glyphicon-list' aria-hidden='true'></span></a></td>";
				
				// str += "<td><a type='button' class='btn btn-info btn-sm' id='ObjectRemove' href='index.php?CRUD=Vidalennya&entity=Object&Tobo=" + obj["Tobo"] 
				// + "&ObjID=" + obj["ObjID"] 
				// + "'><span class='glyphicon glyphicon-remove-sign' aria-hidden='true'></span></a></td>";
				
				// str += "</tr>";
			
			// });
			
			// $ObjectsTable.html(str);
			
		// }
		
		
		// var getParams =  "?CRUD=View"
			// +  "&entity=SubObj";
		
		// var method;
		// if(getURLParam("Tobo") == '1800') {
			// method = "&method=FindAll";
		// } 
		
		// // $.ajax({
			// // dataType: "json",
			// // url: 'index.php' + getParams + method,
			// // data: {
				// // "budgCode" : getURLParam("BudgetCode")
			// // },
			// // timeout: 15000
		// // }).done(ajaxSuccess)
			// // .pipe()
			// // .fail(function(jqXHR) {
					// // console.log(jqXHR);
					// // $ul = $("<ul></ul");
					// // $ul.insertAfter('.container');
					// // $ul.append($('<li id="ajaxFail"></li>').html('Шкода... Але виникла помилка : \n' + jqXHR.status + ' Відповідь серверу: \n' + jqXHR.responseText));
					
			// // });	
			
		
		
		// broker.on('deleteObj', function(event, message) {
		   // // console.log(mG);
			// // console.log(ObjID);
			// var getParams =  "?CRUD=Vidalennya"
						// +  "&entity=Object";
			// if(confirm("Видалити цей об`єкт?\nОб`єкт буде видалений із касовими видатками!!!")) {
				// var ajaxCall = function(ObjID) {
					// $.ajax({
						// dataType: "json",
						// url: 'index.php' + getParams,
						// data: {
							// "ObjID": 	ObjID,
							// "Tobo" :  	getURLParam("Tobo")
						// },
						// timeout: 15000
					// })
					// .done(ajaxDelete)
					// .fail(function(jqXHR) {
							// console.log(jqXHR);
							// $("<span></span>").appendTo('.container').html('Шкода... Але виникла помилка : ' + jqXHR.status)
					// });	;
				// }
				// ajaxCall(message.ObjID);
				
				
			
				// console.log(message);
				
				// function ajaxDelete(data) {
					// if(data.count >= 1) {
						// var message = {aRows: data.count, year: broker.year};
						// broker.trigger('refreshTable', [message]);
					// }
				// }	
			// }
		// });
		
		
		
		// // console.log($(' thead  '));
		// $.each($('table thead  th'), function() {
			// console.log($(this).height());
			// // $(this).css({"height": "20px"});
			// $(this).css({
				// "height": "20px", 
				// "line-height": "15px"
			// });
			// $(this).height("20px");
		// });
		
		// $('td').css({overflow: "hidden"});
		
		
	// });

});
})(jQuery);