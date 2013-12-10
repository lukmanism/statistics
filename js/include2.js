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
			,{
				fillColor : "#9FEE00",
				strokeColor : "#454447",
				pointColor : "#ffffff",
				pointStrokeColor : "#454447",
				data : datas[0][4]['datas']['data']
			}
		]			
	}
	var myLine = new Chart(document.getElementById("linechart").getContext("2d")).Line(lineChartData,options);
	window.slideval = lineChartData.datasets;
}

function comparison(min, yearindex, dataset){
	var index = yearindex - min;

	var penduduk, b_bfr, b_aft, belia, a_bfr, a_aft, a_diff, a_diff_pcnt, a_diff_bfr, a_diff_bfr_pcnt, a_diff_aft, a_diff_aft_pcnt;

	penduduk = dataset[0]['data'][index];
	b_bfr = dataset[0]['data'][index-1];
	b_aft = dataset[0]['data'][index+1];
	belia = dataset[1]['data'][index];
	a_bfr = dataset[1]['data'][index-1];
	a_aft = dataset[1]['data'][index+1];

	a_diff = window.belia - belia;
	a_diff_pcnt = ((window.belia/belia) * 100)-100;
	a_diff_bfr = window.a_bfr - a_bfr;
	a_diff_bfr_pcnt = ((window.a_bfr/a_bfr) * 100)-100;
	a_diff_aft = window.a_aft - a_aft;
	a_diff_aft_pcnt = ((window.a_aft/a_aft) * 100)-100;

	// console.log('comparison',window.a_bfr,a_bfr);

	loadDiffHome(penduduk,belia,a_diff,a_diff_pcnt,a_diff_bfr,a_diff_bfr_pcnt,a_diff_aft,a_diff_aft_pcnt);
}

function loadDiffHome(penduduk,belia,a_diff,a_diff_pcnt,a_diff_bfr,a_diff_bfr_pcnt,a_diff_aft,a_diff_aft_pcnt,c){
	$(".a_total").text(output(belia,0));
	$(".b_total").text(output(penduduk,0));
	$(".data_total").text(output(c,0));
	$(".a_pcnt").text(output(a_diff_pcnt,0)+'%');
	$(".b_pcnt").text(output((100 - a_diff_pcnt),0)+'%');

	$(".a_diff").text(output(a_diff,0));
	$(".a_diff_pcnt").text(output(a_diff_pcnt,0)+'%');

	$(".a_diff_bfr").text(output(a_diff_bfr,0));
	$(".a_diff_bfr_pcnt").text(output(a_diff_bfr_pcnt,0)+'%');

	$(".a_diff_aft").text(output(a_diff_aft,0));
	$(".a_diff_aft_pcnt").text(output(a_diff_aft_pcnt,0)+'%');

	if(a_diff_bfr < 0){
		$('.home .a_diff_bfr_pcnt').removeClass('up').addClass('down');
	} else {
		$('.home .a_diff_bfr_pcnt').removeClass('down').addClass('up');
	}
	if(a_diff_aft < 0){
		$('.home .a_diff_aft_pcnt').removeClass('up').addClass('down');
	} else {
		$('.home .a_diff_aft_pcnt').removeClass('down').addClass('up');
	}	
}




function calculate(min, yearindex, dataset, set, color){
	var index = yearindex - min;
	var getset = (typeof set != 'undefined')? set : 0;
	var getcolor = (typeof color != 'undefined')? color : "#1c638d";

	var penduduk, b_bfr, b_aft, a_diff, a_diff_pcnt, a_diff_bfr, a_diff_bfr_pcnt, a_diff_aft, a_diff_aft_pcnt;

	penduduk = dataset[0]['data'][index];
	var c = dataset[2]['data'][index];
	b_bfr = dataset[0]['data'][index-1];
	b_aft = dataset[0]['data'][index+1];
	window.belia = dataset[1]['data'][index];
	window.a_bfr = dataset[1]['data'][index-1];
	window.a_aft = dataset[1]['data'][index+1];

	a_diff = penduduk - belia;
	a_diff_pcnt = (belia/penduduk) * 100;
	a_diff_bfr = belia - a_bfr;
	a_diff_bfr_pcnt = ((belia/a_bfr) * 100)-100;
	a_diff_aft = a_aft - belia;
	a_diff_aft_pcnt = ((a_aft/belia) * 100)-100;

	var piedata = [
		{value: a_diff, color: getcolor},
		{value: belia, color: "#4DA3D5"}
	];
	pie(piedata, 'pie');

	loadDiffHome(penduduk,belia,a_diff,a_diff_pcnt,a_diff_bfr,a_diff_bfr_pcnt,a_diff_aft,a_diff_aft_pcnt,c);
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

function bar(stats_set,datas,year, color){
	var getcolor = (typeof color != 'undefined')? color : "#1c638d";
	var cat = Array();
	var Ba = Array();
	var Bb = Array();
	var index = (year)? ((year-min_year)): (stats_set-1);
	var bardata = Array();

	for (var i = 0; i < stats_set; i++) {
		cat.push((datas[i][2]['district'])? datas[i][2]['district'] : datas[i][3]['state']);
		Ba.push(datas[i][1]['data'][index]);
		Bb.push(datas[i][0]['data'][index]);
		// datas[i][4]['datas']['data'][index]
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
		    data: Ba,
	        color: "#4DA3D5"
		}, {
	        name: "Penduduk",
	        data: Bb,
	        color: getcolor
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
			url: window.url+getData,
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
	var Ba = thisdata[0][1]['data'];
	var Bb = thisdata[0][0]['data'];
	var index = (year)? ((year-min_year)): (stats_set-1);

	sparklines('.PSpark','#1C638D', Ba);
	sparklines('.BSpark','#4DA3D5', Bb);

	var piedata = [
		{value: (Bb[index]-Ba[index]), color: "#1c638d"},
		{value: Ba[index], color:"#4DA3D5"}
	];

	pie(piedata, 'cpie');

	var a_diff_bfr = (Ba[index]-Ba[index-1]);
	var a_diff_aft = (Ba[index+1]-Ba[index]);
	var a_diff_bfr_pcnt = ((Ba[index]/Ba[index-1]) * 100)-100;
	var a_diff_aft_pcnt = ((Ba[index+1]/Ba[index]) * 100)-100;

	var a_diff_pcnt = (Ba[index]/Bb[index]) * 100;


	$(".Ba_total").text(output(Ba[index]));
	$(".Bb_total").text(output(Bb[index]));
	$(".Ba_pcnt").text(output(a_diff_pcnt,0)+'%');
	$(".Bb_pcnt").text(output((100 - a_diff_pcnt),0)+'%');

	$(".Ba_diff_bfr").text(output(a_diff_bfr));
	$(".Ba_diff_aft").text(output(a_diff_aft));
	$(".Ba_diff_bfr_pcnt").text(output(a_diff_bfr_pcnt)+'%');
	$(".Ba_diff_aft_pcnt").text(output(a_diff_aft_pcnt)+'%');


	var home_total = window.belia;
	var away_total = Ba[index];
	var home_pcnt = (home_total/(home_total + away_total)) * 100;
	var away_pcnt = (away_total/(home_total + away_total)) * 100;

	var Dpiedata = [
		{value: away_total, color:"#103636"},
		{value: home_total, color: "#108F97"}
	];

	pie(Dpiedata, 'Dpie');


	// console.log('away:',home_total,away_total,home_pcnt,away_pcnt);

	$(".home_diff .Da_diff_total").text(output(home_total));
	$(".away_diff .Da_diff_total").text(output(away_total));
	$(".home_diff .Da_diff_pcnt").text(output(home_pcnt)+'%');
	$(".away_diff .Da_diff_pcnt").text(output(away_pcnt)+'%');

	if(a_diff_bfr < 0){
		$('.away .Ba_diff_bfr_pcnt').removeClass('up').addClass('down');
	} else {
		$('.away .Ba_diff_bfr_pcnt').removeClass('down').addClass('up');
	}
	if(a_diff_aft < 0){
		$('.away .Ba_diff_aft_pcnt').removeClass('up').addClass('down');
	} else {
		$('.away .Ba_diff_aft_pcnt').removeClass('down').addClass('up');
	}	
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
	bar(stats_set,datas,val,'#9FEE00');
	pushSparklines(window.stats_set, datas, window.min_year, val);

	if(typeof val != 'undefined'){
		$('.widget_tahun').html(val);
		$('.widget_tahun_prev').html(val-1);
		$('.widget_tahun_aft').html(val+1);		
	}
}

function getYearBfr(){
	$('.getYearBfr').tooltip({ content: "Awesome title!" });
}
function getYearAft(){
	$('.getYearAft').tooltip({ content: "Awesome title!" });

}