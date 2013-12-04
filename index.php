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
    	<link href="css/kendo.dataviz.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script src="js/jquery.ui.touch-punch.min.js"></script>
		<script src='js/include.js'></script>
    	<script src="js/kendo.dataviz.min.js"></script>
	</head>
	
<body style="background-color: transparent;">

<div class="container">

<div class="header">
	<span class="bookmark"></span><h1 class="title"></h1>
</div>

<div class="clear"></div>

<div class="content">
	<canvas id="linechart" height="200" width="688"></canvas>

<div class="clear"></div>

	<div id="slider"></div>

<div class="clear"></div>

</div>

	<div class="clear"></div>

	<div class="comparison">
		<div class="widget_title">Perbandingan Antara Daerah</div>
		<div class="widget_title_s">Untuk Tahun <span class="widget_tahun">2013</span></div>
		<div class="bar" id="compare" ></div>


	<div class="clear"></div>

	<div class="bar_summary">
		<div class="widget_title"><span class="thisdistrict">Batu Pahat</span> vs. <span class="thatdistrict">Batu Pahat</span></div>
	
			<div class="col2 vseparator summ">
				<canvas id="pie" height="100px" width="100px"></canvas>
				<div class="clear"></div>
			    <dl class="">
			        <dt class="">Perbezaan Belia</dt>
			        <h3 class="belia_pcnt">48%</h3>
			        <div class="widget_title_s belia_total"></div>
			        <dd class=""></dd>
			    </dl>
			    <dl class="">
			        <dt class="">Perbezaan Penduduk</dt>
			        <h3 class="pop_pcnt">48%</h3>
			        <div class="widget_title_s pop_total"></div>
			        <dd class=""></dd>
			    </dl>
			</div>
			<div class="col2 summ">
				<canvas id="cpie" height="100px" width="100px"></canvas>
				<div class="clear"></div>
			    <dl class="">
			        <dt class="">Perbezaan Belia</dt>
			        <h3 class="Bbelia_pcnt">48%</h3>
			        <div class="widget_title_s Bbelia_total"></div>
			        <dd class=""></dd>
			    </dl>
			    <dl class="">
			        <dt class="">Perbezaan Penduduk</dt>
			        <h3 class="Bpop_pcnt">48%</h3>
			        <div class="widget_title_s Bpop_total"></div>
			        <dd class=""></dd>
			    </dl>
			</div>


	</div>

	</div>
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
	// $param = '?'.$push.'='.$get;
	$param = '?d=batu pahat,kluang,perlis,muar,tangkak,Pasir Mas,Kota Setar';
?>

<script>
$(function() {
	window.scaleSteps = <?php echo $scaleSteps; ?>;
	window.scaleStepWidth = <?php echo $scaleStepWidth; ?>;
	window.scaleStartValue = <?php echo $scaleStartValue; ?>;
	var loaddata;
	var datas = [];

	$.ajax({
			async: false,
			url: "getjson.php<?php echo $param; ?>",
			beforeSend: function(xhr) {}
		}).done(function(data) {
			loaddata = data;
	});

	window.stats_set = loaddata.length; // check data set

	// construct data from json
	$.each(loaddata, function(key, val){
		datas[key]= [{data: val.penduduk}, {data: val.belia}, {district: val.district}, {state: val.state}];
	});

	var district = (datas[0][2]['district'])? datas[0][2]['district']: '';
	$('.title').text(district + ', ' + datas[0][3]['state']);

	$('.thisdistrict').text(district);
	$('.thatdistrict').text(district);

	window.year = 2013;
	window.min_year = 2008;

	// Load Page
	linechart(datas); //draw line chart
	summary(stats_set,datas);
	calculate(min_year, year, window.slideval); // render summary

	var slider = $( "#slider" ).slider({
		value: year, //slider default value
		min: min_year,
		max: year,
		step: 1,
		slide: function( event, ui ) {
			// console.log(event, ui);
			window.selected_year = ui.value;
			calculate(min_year, ui.value, window.slideval);
			summary(stats_set,datas,ui.value);
		}
	});


});


</script>
	</body>
</html>
