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
		<script src='js/include2.js'></script>
	</head>
	
<body style="background-color: transparent;">

<div class="container">

	<div class="header">
		<span class="bookmark"></span><h1 class="title"></h1>
	</div>
	<div class="clear"></div>

	<div class="content">
		<div class="widget_title top15">Graf Belia di <span class="title">Batu Pahat</span></div>
		<div class="widget_title_s bottom15">Untuk Tahun <span class="widget_tahun">2013</span></div>
		<canvas id="linechart" height="200" width="688"></canvas>
		<div class="clear"></div>

		<div class="slider_outer">
			<div class="slider_inner">
				<ul class="marker">
					<li>2008</li>
					<li>2009</li>
					<li>2010</li>
					<li>2011</li>
					<li>2012</li>
					<li>2013</li>
				</ul>
				<div id="slider"></div>
			</div>
		</div>


		<div class="clear"></div>

		<div class="col1 legend margin15">
			<dl class="col3">
				<dt class="grey50 left">Belia</dt>
				<dd class="a_total small left">198,060</dd>
			</dl>
			<dl id="penduduk" class="col3 active tab">
				<dt class="grey50 left">Penduduk</dt>
				<dd class="b_total small left">198,060</dd>
			</dl>
			<dl id="health" class="col3 inactive tab">
				<dt class="grey50 left">Belia Sihat</dt>
				<dd class="data_total small left">198,060</dd>
			</dl>
		</div>

	</div>
	<div class="clear"></div>

<div class="summary"> <!-- START SUMMARY  -->
	<div class="comparison">
		<div class="widget_title top15">Belia Vs. Penduduk</div>
		<div class="widget_title_s">Perbandingan Antara Daerah Untuk Tahun <span class="widget_tahun">2013</span></div>
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
			        <dd class="a_pcnt large">48%</dd>
			        <dd class="a_total small"></dd>
			    </dl>
			    <dl class="col2">
			        <dt class="grey50">Perbezaan Penduduk</dt>
			        <dd class="b_pcnt large">48%</dd>
			        <dd class="b_total small"></dd>
			    </dl>
			</div>
			<div class="col2">
				<canvas id="cpie" height="100px" width="100px"></canvas>
				<div class="clear"></div>
			    <dl class="col2">
			        <dt class="grey50">Perbezaan Belia</dt>
			        <dd class="Ba_pcnt large">48%</dd>
			        <dd class="Ba_total small"></dd>
			    </dl>
			    <dl class="col2">
			        <dt class="grey50">Perbezaan Penduduk</dt>
			        <dd class="Bb_pcnt large">48%</dd>
			        <dd class="Bb_total small"></dd>
			    </dl>
			</div>

		<div class="clear"></div>

		<div class="widget_title_s margin15">Perbezaan belia sebelum dan selepas tahun <span class="widget_tahun">2013</span></div>
			<div class="clear splitter1 vseparator"></div>

			<div class="col2 home">
			    <dl class="row right15 year_aft">
			        <dd class="a_diff_aft_pcnt med up">0%</dd>
			        <dd class="hline right"></dd>
			        <dd class="a_diff_aft small">0</dd>
					<div class="getYearAft hide hover">getYearAft Test</div>
			    </dl>
			    <dl class="row right15 year_now">
			        <dd class="med" style="color: rgb(77, 163, 213);">100%</dd>
			        <dd class="hline right"></dd>
			        <dd class="a_total small">176,900</dd>
			    </dl>
			    <dl class="row right15 year_bfr">
			        <dd class="a_diff_bfr_pcnt med up">40%</dd>
			        <dd class="hline right"></dd>
			        <dd class="a_diff_bfr small">198,060</dd>
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
			        <dd class="Ba_diff_aft_pcnt med up">0%</dd>
			        <dd class="hline left"></dd>
			        <dd class="Ba_diff_aft small">0</dd>
			    </dl>
			    <dl class="row left15 year_now">
			        <dd class="med" style="color: rgb(77, 163, 213);">100%</dd>
			        <dd class="hline left"></dd>
			        <dd class="Ba_total small">176,900</dd>
			    </dl>
			    <dl class="row left15 year_bfr">
			        <dd class="Ba_diff_bfr_pcnt med up">40%</dd>
			        <dd class="hline left"></dd>
			        <dd class="Ba_diff_bfr small">198,060</dd>
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
			        <dd class="Da_diff_pcnt large">40%</dd>
			        <dd class="Da_diff_total small">198,060</dd>
			    </dl>
			</div>
			<div class="col2 away_diff">
			    <dl class="">
			        <dt class="grey50"><span class="thatdistrict">Batu Pahat</span></dt>
			        <dd class="Da_diff_pcnt large">60%</dd>
			        <dd class="Da_diff_total small">198,060</dd>
			    </dl>
			</div>
	</div>
	</div>
</div> <!-- END SUMMARY  -->


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
	$Dt = ($_GET['Dt'])? '&Dt='.$_GET['Dt']: '';
	$url = 'getjson.php?'.$push.'=';
	$uri = $get.$Dt;
	// $param = '?d=batu pahat,kluang,perlis,muar,tangkak,Pasir Mas,Kota Setar';
	// $getYear = ($_GET['y'])? $_GET['y']: '';
?>

<script>
$(function() {
	window.scaleSteps = <?php echo $scaleSteps; ?>;
	window.scaleStepWidth = <?php echo $scaleStepWidth; ?>;
	window.scaleStartValue = <?php echo $scaleStartValue; ?>;
	var loaddata;
	var datas = [];

	window.url = '<?php echo $url; ?>';

	$.ajax({
			async: false,
			url: window.url+"<?php echo $uri; ?>",
			beforeSend: function(xhr) {}
		}).done(function(data) {
			loaddata = data;
	});

	window.stats_set = loaddata.length; // check data set

	// construct data from json
	$.each(loaddata, function(key, val){
		datas[key]= [{data: val.penduduk}, {data: val.belia}, {district: val.district}, {state: val.state}, {datas: val.datas}];
	});

	var main_title = (datas[0][2]['district'])? datas[0][2]['district'] + ', ' + datas[0][3]['state']: datas[0][3]['state'];
	var title = (datas[0][2]['district'])? datas[0][2]['district'] : datas[0][3]['state'];
	$('.title').text(main_title);
	$('.thisdistrict').text(title);
	$('.thatdistrict').text(title);


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

	$('.tab').click(function(){
		var id = $(this).attr('id');
		var year = (typeof window.selected_year != 'undefined')? window.selected_year: window.year;

		$('.tab').removeClass('active').addClass('inactive');
		$(this).removeClass('inactive').addClass('active');

		switch(id){
			case "penduduk":
				calculate(min_year, year, window.slideval, 0);
				summary(stats_set,datas,year);
			break;
			case "health":
				calculate(min_year, year, window.slideval, 2, '#9FEE00');
				summary(stats_set,datas,year);
			break;
		}



		console.log(id);
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

	$(window).bind('scroll', function() {
		var scrollval = $(window).scrollTop();
		var slider = $('.slider_inner');
		var marker = $('.marker');
         if (scrollval < 289) {
            slider.removeClass('fixed').show();
            marker.hide();
         } else if(scrollval > 289){
            slider.addClass('fixed').show();
            marker.css("display","table");
         } else {
            slider.hide();
            marker.hide();
         }
         // console.log(scrollval);
    });

});


</script>
	</body>
</html>
