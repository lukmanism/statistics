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
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery.touchSwipe.min.js"></script>
		<script src="js/jquery.ui.touch-punch.min.js"></script>
		<script src='js/swipe.js'></script>
		<script src='js/swipe.js'></script>
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

	<div class="legend_container">
		<div class="widget_title">Comparison</div>
		<div class="left legend">
			<span>Jumlah Belia<h3 class="belia_total">163,100</h3></span>
		</div>
		<div class="right legend">
			<canvas class="pie" id="jum_belia" height="100px" width="100px"></canvas>
			<span>Jumlah Penduduk<h3 class="pop_total">390,200</h3></span>
		</div>

<!-- 		<dl class="stat trend-container highest-container">
	        <dt class="example-subtitle">Previous Year</dt>
	        <dd class="highest"></dd>
	        <dd class="sparkline highest-sparkline"></dd>
	    </dl>
	    <dl class="stat trend-container lowest-container">
	        <dt class="example-subtitle">Next Year</dt>
	        <dd class="lowest"></dd>
	        <dd class="sparkline lowest-sparkline"></dd>
	    </dl>
	    <dl class="stat trend-container">
	        <dt class="example-subtitle">YoY change</dt>
	        <dd class="relative-value"></dd>
	        <dd class="sparkline relative-value-sparkline"></dd>
	    </dl>
 -->
</div>


</div>

	<div class="clear"></div>




	<div class="comparison">
		<div class="widget_title">Comparison</div>
		<div class="bar" id="compare" ></div>
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
	$param = '?'.$push.'='.$get;
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

	var stats_set = loaddata.length; // check data set

	// construct data from json
	$.each(loaddata, function(key, val){
		datas[key]= [{data: val.penduduk}, {data: val.belia}, {district: val.district}, {state: val.state}];
	});

	var year = 2013;
	var min_year = 2008;

	// Load Page
	linechart(datas); //draw line chart
	bar(stats_set,datas);
	calculate(min_year, year, window.slideval); // render summary

	// if(stats_set > 1){
	// 	summary(stats_set-1);
	// }

	var slider = $( "#slider" ).slider({
		value: year, //slider default value
		min: min_year,
		max: year,
		step: 1,
		slide: function( event, ui ) {
			// console.log(event, ui);
			window.selected_year = ui.value;
			calculate(min_year, ui.value, window.slideval);
			bar(stats_set,datas,ui.value);
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



	function bar(stats_set,datas,x){
		var cat = Array();
		var Bbelia = Array();
		var Bpenduduk = Array();

		var index = (x)? (stats_set-1): (stats_set-1);

		for (var i = 0; i < stats_set; i++) {
			cat.push((datas[i][2]['district'])? datas[i][2]['district'] : datas[i][3]['state']);
			Bbelia.push(datas[i][1]['data'][index]);
			Bpenduduk.push(datas[i][0]['data'][index]);
		};

		// console.log(Bbelia,cat);

		$("#compare").kendoChart({
        axisDefaults: {
            majorGridLines: { visible: false },
            majorTicks: { visible: false }
        },
		legend: {
		    visible: false
		},
		seriesDefaults: {
		    type: "column",
            stack: true,
            border: {
                width: 0
            },
            overlay: {
                gradient: "none"
            }
		},
		series: [{
		    name: "Belia",
		    data: Bbelia,
            color: "#70B5DD"
		}, {
            name: "Penduduk",
            data: Bpenduduk,
            color: "#1C638D"
        }],
		valueAxis: {
		    max: 140000,
		    line: {
		        visible: false
		    },
		    minorGridLines: {
		        visible: false
		    }
		},
		categoryAxis: {
		    categories: cat,
		    majorGridLines: {
		        visible: false
		    }
		},
        tooltip: {
            visible: true,
			template: function(e){
				console.log(e);
          		return e.series['name'] + ': ' + output(e.value,0); 
			}
        },
        valueAxis: {
            visible: false
        },
        legend: { visible: false }
		});		
	}


});


</script>
	</body>
</html>
