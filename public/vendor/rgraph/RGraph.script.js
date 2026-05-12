/* Bar Graph */
 /*source_data = [
    ['Excellent',100],
    ['Very Good',5],
    ['Good',3],
    ['Average',1],
    ['Poor',2.5]
]; */
	/* var source_data = [
	"5"=>"Excellent",
	"4"=>"Very Good",
	"3"=>"Good",
	"2"=>"Average",
	"1"=>"Poor"
	]; */
labels = [];
data   = [];


// Create the separate data and labels arrays
for (var i=0; i<sourceData.length; ++i) {
    labels[i] = sourceData[i][0];
      data[i] = [sourceData[i][1]];
}



new RGraph.HBar({
    id: 'cvs',
    data: data,
    options: {
        labels: labels,
        gutterLeftAutosize: true,
        shadow: true,
        vmargin: 19,
        backgroundGridHlines: true,
        backgroundGridBorder: false,
        backgroundGridAutofitNumvlines: 5,
        noaxes: true,
        xlabelsCount: 5,
        xmax: 100,
        scaleDecimals: 0,
        colors: ['#7CB5EC'],
        titleXaxis: 'Contributions / receipts (ebn)',
        titleXaxisY: 910,
        titleXaxisColor: '#aaa',
        title: 'Overall Rating (in %)'
        /*key: ['Overall Rating 89'],
        keyPosition: 'gutter',
        keyTextBold: true*/
    }
}).grow({frames: 60});

node = RGraph.text2.find({
    id: 'cvs',
    text: /ebn/
});

node[0].innerHTML = node[0].innerHTML.replace('ebn', '&euro;bn');

/* Line Graph */
var data = JSON.parse("["+rawData+"]");
//var lineLabels = JSON.parse("["+rawLineLabels+"]");
new RGraph.Line({
	id: 'svc',
	data: data,
	options: {
		linewidth: 2,
		backgroundGridVlines: false,
		backgroundGridBorder: false,
		backgroundGridAutofitNumhlines: 4,
		noaxes: true,
		ymax: 5,
		ymin: 1,
		tickmarks: false,
		shadow: true,
		ylabelsCount: 4,
		gutterLeft: 50,
		gutterRight: 50,
		colors: ['#7CB5EC'],
		title: 'Rating over time',
		titleYaxis: 'Rating',
		titleYaxisPos: 0.23,
		titleYaxisBold: false,
		titleYaxisSize: 10,
		textAccessible: false,
		//tooltips: tooltips,
		labels: lineLabels
	}
}).trace();