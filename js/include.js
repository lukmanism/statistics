function pie(data, target) {
	var options = {		
		segmentShowStroke : false,	
		segmentStrokeColor : "#fff",	
		segmentStrokeWidth : 20,	
		animation : true,	
		animationSteps : 60,	
		animationEasing : "easeOutBounce",	
		animateRotate : true,
		animateScale : true,	
		onAnimationComplete : null
	}
	new Chart(document.getElementById(target).getContext("2d")).Pie(data, options);	
	$('#'+target).attr("width","100").attr("height","100"); //forced size
}


function linechart(datas){
	var options = {	
		scaleOverlay : false,
		scaleOverride : false,
		scaleSteps : window.scaleSteps,
		scaleStepWidth : window.scaleStepWidth,
		scaleStartValue : window.scaleStartValue,
		scaleLineColor : "rgba(0,0,0,0)",			
		scaleLineWidth : 1,
		scaleShowLabels : true,			
		scaleLabel : "<%=value%>",			
		scaleFontFamily : "'Helvetica'",			
		scaleFontSize : 12,			
		scaleFontStyle : "normal",			
		scaleFontColor : "#666",				
		scaleShowGridLines : false,			
		scaleGridLineColor : "rgba(0,0,0,.05)",	
		scaleGridLineWidth : 1,				
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
				fillColor : "#1c638d",
				strokeColor : "#454447",
				pointColor : "#ffffff",
				pointStrokeColor : "#454447",
				data : datas[0][0]['data']
			},
			{
				fillColor : "#4DA3D5",
				strokeColor : "#454447",
				pointColor : "#ffffff",
				pointStrokeColor : "#454447",
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

	// if(window.belia<belia){
	// 	$('.belia_diff').removeClass('up').addClass('down');
	// 	$('.belia_diff_pcnt .rating').text('Kekurangan');
	// } else {
	// 	$('.belia_diff').removeClass('down').addClass('up');
	// 	$('.belia_diff_pcnt .rating').text('Kelebihan');
	// }
	// if(window.belia_bfr<belia_bfr){
	// 	$('.belia_diff_bfr').removeClass('up').addClass('down');
	// 	$('.belia_diff_bfr_pcnt .rating').text('Kekurangan');
	// } else {
	// 	$('.belia_diff_bfr').removeClass('down').addClass('up');
	// 	$('.belia_diff_bfr_pcnt .rating').text('Kelebihan');
	// }
	// if(window.belia_aft<belia_aft){
	// 	$('.belia_diff_aft').removeClass('up').addClass('down');
	// 	$('.belia_diff_aft_pcnt .rating').text('Kekurangan');
	// } else {
	// 	$('.belia_diff_aft').removeClass('down').addClass('up');
	// 	$('.belia_diff_aft_pcnt .rating').text('Kelebihan');
	// }
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

	var piedata = [
		{value: belia_diff, color: "#1c638d"},
		{value: belia, color:"#4DA3D5"}
	];

	pie(piedata, 'pie');

	$(".belia_total").text(output(belia,0));
	$(".pop_total").text(output(penduduk,0));
	$(".belia_pcnt").text(output(belia_diff_pcnt,0)+'%');
	$(".pop_pcnt").text(output((100 - belia_diff_pcnt),0)+'%');
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

function bar(stats_set,datas,year){
	var cat = Array();
	var Bbelia = Array();
	var Bpenduduk = Array();
	var index = (year)? ((year-min_year)): (stats_set-1);
	var bardata = Array();

	for (var i = 0; i < stats_set; i++) {
		cat.push((datas[i][2]['district'])? datas[i][2]['district'] : datas[i][3]['state']);
		Bbelia.push(datas[i][1]['data'][index]);
		Bpenduduk.push(datas[i][0]['data'][index]);
	};

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
	        color: "#4DA3D5"
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
				setSparklines(e.category);
	      		return e.series['name'] + ': ' + output(e.value,0); 
			}
	    },
	    valueAxis: {
	        visible: false
	    },
	    legend: { visible: false }
	});		
}

function setSparklines(getData){
	var pushdata;
	window.pushdatas = [];
	$.ajax({
			async: false,
			url: "getjson.php?d="+getData,
			beforeSend: function(xhr) {}
		}).done(function(data) {
			pushdata = data;
	});
	// construct data from json
	$.each(pushdata, function(key, val){
		pushdatas[key]= [{data: val.penduduk}, {data: val.belia}, {district: val.district}, {state: val.state}];
	});

	pushSparklines(window.stats_set, window.pushdatas, window.min_year, window.selected_year);
	$('.thatdistrict').text(getData);
}

function pushSparklines(stats_set, getdata, min_year, year){
	var thisdata = (typeof window.pushdatas == 'undefined')? getdata : window.pushdatas;
	var Bbelia = thisdata[0][1]['data'];
	var BPenduduk = thisdata[0][0]['data'];
	var index = (year)? ((year-min_year)): (stats_set-1);

	sparklines('.PSpark','#1C638D', Bbelia);
	sparklines('.BSpark','#4DA3D5', BPenduduk);

	var piedata = [
		{value: (BPenduduk[index]-Bbelia[index]), color: "#1c638d"},
		{value: Bbelia[index], color:"#4DA3D5"}
	];

	pie(piedata, 'cpie');

	var belia_diff_pcnt = (Bbelia[index]/BPenduduk[index]) * 100;
	$(".Bbelia_total").text(output(Bbelia[index]));
	$(".Bpop_total").text(output(BPenduduk[index]));
	$(".Bbelia_pcnt").text(output(belia_diff_pcnt,0)+'%');
	$(".Bpop_pcnt").text(output((100 - belia_diff_pcnt),0)+'%');
}


function sparklines(target, color, data){
	$(target).kendoSparkline({
        type: "line",
        data: data,
        seriesDefaults: {
            type: "line",
			color: color, 
            markers: { visible: false },
            line: { width: 2 }
        },
        axisDefaults: {
            visible: false,
            majorGridLines: { visible: false }
        },
        legend: { visible: false }
    });
}

function summary(stats_set,datas,val){

	bar(stats_set,datas,val);
	pushSparklines(window.stats_set, datas, window.min_year, val);
	$('.widget_tahun').html(val);

}