function pie(penduduk,belia) {
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
	var jum_belia = new Chart(document.getElementById("jum_belia").getContext("2d")).Pie(penduduk, options);	
	$(".pie").attr("width","100").attr("height","100"); //forced size
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
				fillColor : "rgba(28,99,141,.7)",
				strokeColor : "#1c638d",
				pointColor : "#1c638d",
				pointStrokeColor : "#fff",
				data : datas[0][0]['data']
			},
			{
				fillColor : "rgba(112,181,221,.7)",
				strokeColor : "#70b5dd",
				pointColor : "#70b5dd",
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

	var Dpenduduk = [
		{value: belia_diff, color: "#1c638d"},
		{value: belia, color:"#70b5dd"}
	];

	var Dbelia = [
		{ value: 0, color: "#70b5dd"},
		{ value: belia_diff, color:"#1c638d"}
	];
	pie(Dpenduduk,Dbelia);

	$(".belia_total").text(output(belia,0));
	$(".pop_total").text(output(penduduk,0));
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