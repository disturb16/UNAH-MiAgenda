
<html>
    <head>
        <title>Google Charts Tutorial</title>
 
 		<script src='javascript/jquery-1.11.2.min.js'></script>
        <!-- load Google AJAX API -->
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            //load the Google Visualization API and the chart
            google.load('visualization', '1', {'packages': ['columnchart']});
 
            //set callback
            google.setOnLoadCallback (createChart);
 
            //callback function
            function createChart() {
            	var jsonData = $.ajax({
		          url: "getScoresData.php",
		          dataType: "json",
		          async: false
		          }).responseText;
 
 				var jdata = jQuery.parseJSON(jsonData);
                //create data table object
                var dataTable = new google.visualization.DataTable();
 
                //define columns
                dataTable.addColumn('string','Numeros de cuenta');
                dataTable.addColumn('number', 'Nota');

 				var size = Object.keys(jdata.Scores).length;
                //define rows of data
				for (var i = 1; i < size; i++) {
					dataTable.addRow([jdata.Scores[i].cuenta,parseInt(jdata.Scores[i].score)]);
				    console.log(i);
				}
                
                //dataTable.addRows([['Q1',308], ['Q2',257],['Q3',375],['Q4', 123]]);
 
                //instantiate our chart object
                var chart = new google.visualization.LineChart (document.getElementById('chart'));
 
                //define options for visualization
                var options = {
                	 hAxis: {
			          title: 'Time'
			        },
			        vAxis: {
			          title: 'Popularity'
			        },
                	width: 400, 
                	height: 240, 
                	chart: {
          			title: 'Box Office Earnings in First Two Weeks of Opening',
         			subtitle: 'in millions of dollars (USD)'
        			}};
 
                //draw our chart
                chart.draw(dataTable, options);

                console.log(Object.keys(jsonData).length);
 
            }
        </script>
 
    </head>
 
    <body>
 
        <!--Div for our chart -->
        <div id="chart"></div>
 
    </body>
</html>