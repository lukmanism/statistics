<?php
	error_reporting(0);
?>

<!doctype html>
<html>
	<head>
		<title>Line Chart</title>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
		<script src="js/Chart.min.js"></script>
		<link rel="stylesheet" href="css/jquery-ui.min.css">
    	<link href="css/kendo.dataviz.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script src="js/jquery.ui.touch-punch.min.js"></script>
    	<script src="js/kendo.dataviz.min.js"></script>
		<script src='js/include.js'></script>
	</head>
	
<body style="background-color: transparent;">

<div class="container">

<div class="header">
	<span class="bookmark"></span><h1 class="title"></h1>
</div>

	<div class="clear"></div>

	<div class="content">
		<div class="widget_title_s margin15">Graf Belia vs. Penduduk</div>
		<canvas id="linechart" height="200" width="688"></canvas>
		<div class="clear"></div>
		<div id="slider"></div>
		<div class="clear"></div>

		<div class="col2 legend margin15">
			<dl class="col2">
				<dt class="grey50 left">Belia</dt>
				<dd class="belia_total small left">198,060</dd>
			</dl>
			<dl class="col2">
				<dt class="grey50 left">Penduduk</dt>
				<dd class="pop_total small left">198,060</dd>
			</dl>
		</div>

	</div>



	<div class="clear"></div>

	<div class="comparison">
		<div class="widget_title top15">Perbandingan Antara Daerah</div>
		<div class="widget_title_s">Untuk Tahun <span class="widget_tahun">2013</span></div>
		<div class="bar top15" id="compare" ></div>


	<div class="clear"></div>

	<div class="widget_title_s margin15">Perbandingan di antara <span class="thisdistrict">Batu Pahat</span> dengan <span class="thatdistrict">Batu Pahat</span></div>
	<div class="bar_summary">
		<div class="widget_title bottom15"><span class="thisdistrict">Batu Pahat</span> vs. <span class="thatdistrict">Batu Pahat</span></div>
	
			<div class="col2 vseparator">
				<canvas id="pie" height="100px" width="100px"></canvas>
				<div class="clear"></div>
			    <dl class="col2">
			        <dt class="grey50">Perbezaan Belia</dt>
			        <dd class="belia_pcnt large">48%</dd>
			        <dd class="belia_total small"></dd>
			    </dl>
			    <dl class="col2">
			        <dt class="grey50">Perbezaan Penduduk</dt>
			        <dd class="pop_pcnt large">48%</dd>
			        <dd class="pop_total small"></dd>
			    </dl>
			</div>
			<div class="col2">
				<canvas id="cpie" height="100px" width="100px"></canvas>
				<div class="clear"></div>
			    <dl class="col2">
			        <dt class="grey50">Perbezaan Belia</dt>
			        <dd class="Bbelia_pcnt large">48%</dd>
			        <dd class="Bbelia_total small"></dd>
			    </dl>
			    <dl class="col2">
			        <dt class="grey50">Perbezaan Penduduk</dt>
			        <dd class="Bpop_pcnt large">48%</dd>
			        <dd class="Bpop_total small"></dd>
			    </dl>
			</div>

		<div class="clear"></div>

		<div class="widget_title_s margin15">Perbezaan belia sebelum dan selepas tahun <span class="widget_tahun">2013</span></div>
			<div class="clear splitter1 vseparator"></div>

			<div class="col2 home">
			    <dl class="row right15 year_aft">
			        <dd class="belia_diff_aft_pcnt med up">0%</dd>
			        <dd class="hline right"></dd>
			        <dd class="belia_diff_aft small">0</dd>
					<div class="getYearAft hide hover">getYearAft Test</div>
			    </dl>
			    <dl class="row right15 year_now">
			        <dd class="med" style="color: rgb(77, 163, 213);">100%</dd>
			        <dd class="hline right"></dd>
			        <dd class="belia_total small">176,900</dd>
			    </dl>
			    <dl class="row right15 year_bfr">
			        <dd class="belia_diff_bfr_pcnt med up">40%</dd>
			        <dd class="hline right"></dd>
			        <dd class="belia_diff_bfr small">198,060</dd>
					<div class="getYearBfr hide hover">getYearBfr Test</div>
			    </dl>
			</div>
			<div class="year_timeline">
			        <span class="grey50 med widget_tahun_aft">2014</span>
			        <span class="grey50 large widget_tahun">2013</span>
			        <span class="grey50 med widget_tahun_prev">2012</span>
			</div>
			<div class="col2 away">
			    <dl class="row left15 year_aft">
			        <dd class="Bbelia_diff_aft_pcnt med up">0%</dd>
			        <dd class="hline left"></dd>
			        <dd class="Bbelia_diff_aft small">0</dd>
			    </dl>
			    <dl class="row left15 year_now">
			        <dd class="med" style="color: rgb(77, 163, 213);">100%</dd>
			        <dd class="hline left"></dd>
			        <dd class="Bbelia_total small">176,900</dd>
			    </dl>
			    <dl class="row left15 year_bfr">
			        <dd class="Bbelia_diff_bfr_pcnt med up">40%</dd>
			        <dd class="hline left"></dd>
			        <dd class="Bbelia_diff_bfr small">198,060</dd>
			    </dl>
			</div>

	<div class="clear"></div>
			<div class="clear splitter1 vseparator"></div>

		<div class="widget_title_s margin15">Perbezaan belia di antara <span class="thisdistrict">Batu Pahat</span> dengan <span class="thatdistrict">Batu Pahat</span> tahun <span class="widget_tahun">2013</span></div>

			<div class="clear splitter1 vseparator margin15"></div>
			<div style="text-align:center;"><canvas id="Dpie" height="100px" width="100px"></canvas></div>
			<div class="clear"></div>

			<div class="clear splitter1 vseparator top15"></div>
			<div class="clear splitter2 bottom15"></div>

			<div class="col2 home_diff">
			    <dl class="">
			        <dt class="grey50"><span class="thisdistrict">Batu Pahat</span></dt>
			        <dd class="Dbelia_diff_pcnt large">40%</dd>
			        <dd class="Dbelia_diff_total small">198,060</dd>
			    </dl>
			</div>
			<div class="col2 away_diff">
			    <dl class="">
			        <dt class="grey50"><span class="thatdistrict">Batu Pahat</span></dt>
			        <dd class="Dbelia_diff_pcnt large">60%</dd>
			        <dd class="Dbelia_diff_total small">198,060</dd>
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
	$getYear = ($_GET['y'])? $_GET['y']: '';
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


	var getYear = [<?php echo $getYear; ?>];

	window.year = 2013;
	window.min_year = 2008;
	var step = 1;

	// Load Page
	linechart(datas); //draw line chart
	calculate(min_year, year, window.slideval); // render summary
	summary(stats_set,datas);

	var slider = $( "#slider" ).slider({
		value: year, //slider default value
		min: min_year,
		max: year,
		step: step,
		slide: function( event, ui ) {
			window.selected_year = ui.value;
			calculate(min_year, ui.value, window.slideval);
			summary(stats_set,datas,ui.value);
			// console.log(selected_year);
		}
	});

	// $('.year_bfr').hover(function() {
	// 		$('.getYearBfr').show();
	// 	}, function() {
	// 		$('.getYearBfr').hide();
	// });
	// $('.year_aft').hover(function() {
	// 		$('.getYearAft').show();
	// 	}, function() {
	// 		$('.getYearAft').hide();
	// });


});


</script>
	</body>
</html>
