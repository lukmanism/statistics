<?php
	error_reporting(0);
?>

<!doctype html>
<html>
	<head>
		<title>Line Chart</title>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
		<script src="js/Chart.js"></script>
		<link rel="stylesheet" href="css/jquery-ui.css">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery.touchSwipe.min.js"></script>
		<script src="js/jquery.ui.touch-punch.min.js"></script>
		<script src='js/swipe.js'></script>
	</head>
	
<body style="background-color: transparent;">

<div class="container">

<div class="header">
	<span class="bookmark"></span><h1 class="title"></h1>
</div>

<div class="clear"></div>

<div class="content">
	<canvas id="linechart" height="400" width="600"></canvas>

	<div id="slider"></div>

	<div class="legend_container">
		<div class="left legend">
			<canvas class="doughnut" id="jum_belia" height="60px" width="60px"></canvas><span><h3 class="belia_total">163,100</h3>Jumlah Belia</span>
		</div>
		<div class="right legend">
			<canvas class="doughnut" id="jum_penduduk" height="60px" width="60px"></canvas><span><h3 class="pop_total">390,200</h3>Jumlah Penduduk</span>
		</div>
	</div>
</div>

	<div class="clear"></div>


	<div class="pagination">
		<h1>Perbandingan:</h1>
		<ul class="paginationset"></ul>
	</div>

	<div class="clear"></div>

	<div id='tabs' class='swipe'>
	  <div class='swipe-wrap summary_container'>
	    <div class="summary">
			<span class="left details belia_diff"><h3>254,500</h3>Perbezaan Belia-Penduduk</span>
			<span class="right details belia_diff_pcnt pcnt"><h3>41.8%</h3>Peratusan Belia</span>	
			<span class="left details belia_diff_bfr"><h3>17,000</h3>Perbezaan Belia Tahun Sebelum</span>
			<span class="right details belia_diff_bfr_pcnt pcnt"><h3>5%</h3>Peratusan <span class="rating"></span></span>		
			<span class="left details belia_diff_aft"><h3>1000</h3>Perbezaan Belia Tahun Selepas</span>
			<span class="right details belia_diff_aft_pcnt pcnt"><h3>0.03%</h3>Peratusan <span class="rating"></span></span>
	    </div>
	  </div>
	</div>


	<!-- <div style='text-align:center;padding-top:20px;'>  
	  <button onclick='tabs.prev()'>prev</button> 
	  <button onclick='tabs.next()'>next</button>
	</div> -->


</div>

<?php

	if($_GET['d']){
		$get = $_GET['d'] ;
		$push = 'd';
		$scaleSteps = 5;
		$scaleStepWidth = 50000;
		$scaleStartValue = 50000;
	} else {
		$get = $_GET['s'] ;
		$push = 's';
		$scaleSteps = 5;
		$scaleStepWidth = 100000;
		$scaleStartValue = 100000;
	}
	$param = '?'.$push.'='.$get;


?>
<script>

$(function() {
	var loaddata;
	var datas = [];

	$.ajax({
			async: false,
			url: "getjson.php<?php echo $param; ?>",
			beforeSend: function(xhr) {}
		}).done(function(data) {
			loaddata = data;
	});

	var stats_set = loaddata.length; // check data set

	// construct data from json
	$.each(loaddata, function(key, val){
		datas[key]= [{data: val.penduduk}, {data: val.belia}, {district: val.district}, {state: val.state}];
	});

	var year = 2013;
	var min_year = 2008;

	// Load Page
	linechart(); //draw line chart
	paginationConstruct(stats_set,datas); //construct pagination
	calculate(min_year, year, window.slideval); // render summary

	if(stats_set > 1){
		summary(stats_set-1);
	}

	var slider = $( "#slider" ).slider({
		value: year, //slider default value
		min: min_year,
		max: year,
		step: 1,
		slide: function( event, ui ) {
			window.selected_year = ui.value;
			calculate(min_year, ui.value, window.slideval);
			tabs.slide(0, 500);
		}
	});

	var elem = document.getElementById('tabs');
	window.tabs = Swipe(elem, {
		startSlide: 0,
		auto: 0,
		continuous: false,
		disableScroll: true,
		stopPropagation: true,
		callback: function(index, element) {
			paginationState(index);
	  	},
	  	transitionEnd: function(index, element) {
	  		var tab_year;
			tab_year = (typeof window.selected_year == 'undefined')? year : window.selected_year;
			if(index == 0){ // reset icon
				calculate(min_year, tab_year, datas[index]);
				$('.belia_diff').removeClass('up').removeClass('down');
			} else {
				comparison(min_year, tab_year, datas[index]);
			}
		}
	});

	function summary(n){
		// attach summary window
		var summary = '<div class="summary"><span class="left details belia_diff "><h3></h3>Perbandingan Belia</span><span class="right details belia_diff_pcnt pcnt"><h3></h3>Peratus <span class="rating"></span></span><span class="left details belia_diff_bfr"><h3></h3>Perbandingan Belia Tahun Sebelum</span><span class="right details belia_diff_bfr_pcnt pcnt"><h3></h3>Peratus <span class="rating"></span></span><span class="left details belia_diff_aft"><h3></h3>Perbandingan Belia Tahun Selepas</span><span class="right details belia_diff_aft_pcnt pcnt"><h3></h3>Peratus <span class="rating"></span></span></div>';
		var summaryitem = [];
		for (var i = 0; i < n; i++) {
			summaryitem.push(summary);
		};
		summaryitem.join("");
		$(".summary_container").append(summaryitem);
	}

	function paginationState(index){
		++index;
		$('.pagination li').removeClass('active');
		$('.pagination li:nth-child('+index+')').addClass('active');
	}

	function paginationConstruct(stats_set,datas){
		// console.log(stats_set);
		var thatclass;

		switch(stats_set){
			case(8):
				thatclass = 'eight';
			break;
			case(7):
				thatclass = 'seven';
			break;
			case(6):
				thatclass = 'six';
			break;
			case(5):
				thatclass = 'five';
			break;
			case(4):
			case(3):
			case(2):
			case(1):
				thatclass = 'four';
			break;
			default:
				thatclass = 'large';
			break;
		}

		$('.paginationset').html('');
		for (var i = 0; i < stats_set; i++) {
			var page = (datas[i][2]['district'])? datas[i][2]['district'] : datas[i][3]['state'];
			$('.paginationset').append('<li class="'+thatclass+'"><span>'+page+'</span></li>');
		};
		var district = (datas[0][2]['district'])? datas[0][2]['district'] + ', ': '';
		$('.title').text(district + datas[0][3]['state']);
		paginationState(0);
	}

	function paginationSet(that){
		// apply pagination hotlinking
	}

	function doughnut(penduduk,belia) {
		var options = {			
			segmentShowStroke : true,	//Boolean - Whether we should show a stroke on each segment
			segmentStrokeColor : "#fff",	//String - The colour of each segment stroke
			segmentStrokeWidth : 2,	//Number - The width of each segment stroke
			percentageInnerCutout : 50,	//The percentage of the chart that we cut out of the middle.
			animation : false	//Boolean - Whether we should animate the chart
		}
		var jum_penduduk = new Chart(document.getElementById("jum_penduduk").getContext("2d")).Doughnut(belia, options);
		var jum_belia = new Chart(document.getElementById("jum_belia").getContext("2d")).Doughnut(penduduk, options);	
		$(".doughnut").attr("width","60").attr("height","60"); //forced size
	}

	function linechart(){
		var options = {	
			scaleOverlay : false,
			scaleOverride : false,
			scaleSteps : <?php echo $scaleSteps; ?>,
			scaleStepWidth : <?php echo $scaleStepWidth; ?>,
			scaleStartValue : <?php echo $scaleStartValue; ?>,
			scaleLineColor : "rgba(0,0,0,.5)",			
			scaleLineWidth : 1,
			scaleShowLabels : true,			
			scaleLabel : "<%=value%>",			
			scaleFontFamily : "'Helvetica'",			
			scaleFontSize : 12,			
			scaleFontStyle : "normal",			
			scaleFontColor : "#666",				
			scaleShowGridLines : true,			
			scaleGridLineColor : "rgba(0,0,0,.05)",	
			scaleGridLineWidth : .5,				
			bezierCurve : true,			
			pointDot : true,			
			pointDotRadius : 3,			
			pointDotStrokeWidth : 1,			
			datasetStroke : true,			
			datasetStrokeWidth : 2,			
			datasetFill : true,			
			animation : true,
			animationSteps : 60,			
			animationEasing : "easeOutQuart",
			onAnimationComplete : null			
		}
		var lineChartData = {
			labels : ["2008","2009","2010","2011","2012","2013"],
			datasets : [
				{
					fillColor : "rgba(93,93,93,.7)",
					strokeColor : "#5d5d5d",
					pointColor : "#5d5d5d",
					pointStrokeColor : "#fff",
					data : datas[0][0]['data']
				},
				{
					fillColor : "rgba(198,0,0,.7)",
					strokeColor : "#c60000",
					pointColor : "#c60000",
					pointStrokeColor : "#fff",
					data : datas[0][1]['data']
				}
			]			
		}
		var myLine = new Chart(document.getElementById("linechart").getContext("2d")).Line(lineChartData,options);
		window.slideval = lineChartData.datasets;
	}

	function comparison(min, yearindex, dataset){
		var index = yearindex - min;

		var penduduk, penduduk_bfr, penduduk_aft, belia, belia_bfr, belia_aft, belia_diff, belia_diff_pcnt, belia_diff_bfr, belia_diff_bfr_pcnt, belia_diff_aft, belia_diff_aft_pcnt;

		penduduk = dataset[0]['data'][index];
		penduduk_bfr = dataset[0]['data'][index-1];
		penduduk_aft = dataset[0]['data'][index+1];
		belia = dataset[1]['data'][index];
		belia_bfr = dataset[1]['data'][index-1];
		belia_aft = dataset[1]['data'][index+1];

		belia_diff = window.belia - belia;
		belia_diff_pcnt = ((window.belia/belia) * 100)-100;
		belia_diff_bfr = window.belia_bfr - belia_bfr;
		belia_diff_bfr_pcnt = ((window.belia_bfr/belia_bfr) * 100)-100;
		belia_diff_aft = window.belia_aft - belia_aft;
		belia_diff_aft_pcnt = ((window.belia_aft/belia_aft) * 100)-100;

		$(".belia_diff h3").text(output(belia_diff,0));
		$(".belia_diff_pcnt h3").text(output(belia_diff_pcnt,2)+'%');
		$(".belia_diff_bfr h3").text(output(belia_diff_bfr,0));
		$(".belia_diff_bfr_pcnt h3").text(output(belia_diff_bfr_pcnt,2)+'%');
		$(".belia_diff_aft h3").text(output(belia_diff_aft,0));
		$(".belia_diff_aft_pcnt h3").text(output(belia_diff_aft_pcnt,2)+'%');

		if(window.belia<belia){
			$('.belia_diff').removeClass('up').addClass('down');
			$('.belia_diff_pcnt .rating').text('Kekurangan');
		} else {
			$('.belia_diff').removeClass('down').addClass('up');
			$('.belia_diff_pcnt .rating').text('Kelebihan');
		}
		if(window.belia_bfr<belia_bfr){
			$('.belia_diff_bfr').removeClass('up').addClass('down');
			$('.belia_diff_bfr_pcnt .rating').text('Kekurangan');
		} else {
			$('.belia_diff_bfr').removeClass('down').addClass('up');
			$('.belia_diff_bfr_pcnt .rating').text('Kelebihan');
		}
		if(window.belia_aft<belia_aft){
			$('.belia_diff_aft').removeClass('up').addClass('down');
			$('.belia_diff_aft_pcnt .rating').text('Kekurangan');
		} else {
			$('.belia_diff_aft').removeClass('down').addClass('up');
			$('.belia_diff_aft_pcnt .rating').text('Kelebihan');
		}
	}

	function calculate(min, yearindex, dataset){
		var index = yearindex - min;

		var penduduk, penduduk_bfr, penduduk_aft, belia_diff, belia_diff_pcnt, belia_diff_bfr, belia_diff_bfr_pcnt, belia_diff_aft, belia_diff_aft_pcnt;

		penduduk = dataset[0]['data'][index];
		penduduk_bfr = dataset[0]['data'][index-1];
		penduduk_aft = dataset[0]['data'][index+1];
		window.belia = dataset[1]['data'][index];
		window.belia_bfr = dataset[1]['data'][index-1];
		window.belia_aft = dataset[1]['data'][index+1];

		belia_diff = penduduk - belia;
		belia_diff_pcnt = (belia/penduduk) * 100;
		belia_diff_bfr = belia - belia_bfr;
		belia_diff_bfr_pcnt = ((belia/belia_bfr) * 100)-100;
		belia_diff_aft = belia - belia_aft;
		belia_diff_aft_pcnt = ((belia/belia_aft) * 100)-100;

		$(".belia_diff h3").text(output(belia_diff,0));
		$(".belia_diff_pcnt h3").text(output(belia_diff_pcnt,2)+'%');
		$(".belia_diff_bfr h3").text(output(belia_diff_bfr,0));
		$(".belia_diff_bfr_pcnt h3").text(output(belia_diff_bfr_pcnt,2)+'%');
		$(".belia_diff_aft h3").text(output(belia_diff_aft,0));
		$(".belia_diff_aft_pcnt h3").text(output(belia_diff_aft_pcnt,2)+'%');

		// console.log(belia_diff);

		var Dpenduduk = [
			{value: belia_diff, color: "#5d5d5d"},
			{value: belia, color:"#c60000"}
		];

		var Dbelia = [
			{ value: 0, color: "#c60000"},
			{ value: belia_diff, color:"#5d5d5d"}
		];

		doughnut(Dpenduduk,Dbelia);

		$(".belia_total").text(output(belia,0));
		$(".pop_total").text(output(penduduk,0));


		if(belia<belia_bfr){
			$('.belia_diff_bfr').removeClass('up').addClass('down');
			$('.belia_diff_bfr_pcnt .rating').text('Penurunan');
		} else {
			$('.belia_diff_bfr').removeClass('down').addClass('up');
			$('.belia_diff_bfr_pcnt .rating').text('Kenaikan');
		}
		if(belia<belia_aft){
			$('.belia_diff_aft').removeClass('up').addClass('down');
			$('.belia_diff_aft_pcnt .rating').text('Penurunan');
		} else {
			$('.belia_diff_aft').removeClass('down').addClass('up');
			$('.belia_diff_aft_pcnt .rating').text('Kenaikan');
		}


	}

	function output(number, dec)	{
		number = (isNaN(number))? 0 : number;
	    number = number.toFixed(dec) + '';
	    x = number.split('.');
	    x1 = x[0];
	    x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}


});


</script>
	</body>
</html>
