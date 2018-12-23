var sortKeys = {
		alpha: function($cell) {
			var key = $cell.find('span.sort-key').text() + ' ';
			key += $.trim($cell.text()).toUpperCase();
			return key;
		},
		numeric: function($cell) {
			var num = $cell.text().replace(/^[^\d.]*/, '');
			var key = parseFloat(num);
			if(isNaN(key)) {
				key = 0;
			}
			return key;
		},
		date: function($cell) {
			var key = Date.parse('1 ' + $cell.text());
			// console.log(key);
			return key;
		},
		time: function($cell) {
			var key = $cell.text();
			return key;
		},
		edrpou: function($cell) {
			var num = $cell.text().match(/\d{8}/)[0];
			var key = parseInt(num);
			return key;
		}
	};	