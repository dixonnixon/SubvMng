$.datepicker.setDefaults({
		showOn: "both",
		buttonImageOnly: true,
		buttonImage: "img/calendar.png"
	});
	
$.datepicker.setDefaults(
		$.extend($.datepicker.regional['ru'] = { 
			closeText: 'Зачинити', 
			prevText: '&#x3c;Попередній', 
			nextText: 'Наступний&#x3e;', 
			currentText: 'Сьогодні', 
			monthNames: ['Січень','Лютий','Березень','Квітень','Травень','Червень', 'Липень','Серпень','Вересень','Жовтень','Листопад','Грудень'], 
			monthNamesShort: ['Січ','Лют','Бер','Квіт','Трав','Черв', 
			'Лип','Серп','Вер','Жовт','Лист','Груд'], 
			dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'], 
			dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'], 
			dayNamesMin: ['Нд','Пн','Вт','Ср','Чт','Пт','Сб'], 
			dateFormat: 'dd/mm/yy', 
			firstDay: 1, 
			isRTL: false
		})
);

function makeTwoDigit(num) {
	num = num.toString();
	if(num.length == 1) {
		return "0" + num;
	}
	return num;
}

function currentSlashDate() {
	var currentYear = new Date().getFullYear();
	var currentMonth = makeTwoDigit(new Date().getMonth() + 1);
	var currentDay = makeTwoDigit(new Date().getDate());
		
	return currentDay + '/' + currentMonth + '/' +  currentYear;
}

