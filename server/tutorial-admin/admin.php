
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Analyse</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery-ui.1.11.2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <style>
        td img {
            float: left;
            width: 18px;
        }
        a.btn.btn-info.pull-right {
            padding: 2px;
            font-size: 13px;
            margin: 3px;
            width: 46px;
        }
        td.tdhead {
            color: #3F51B5;
            background: #f7f7f775;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <input type="hidden" id="ViewBy" value="<?php echo $_GET['viewby']; ?>">
<div class="container">
<a href="/admin.php?viewby=all" class="btn btn-info pull-right">All</a>
<a href="/admin.php?viewby=current" class="btn btn-info pull-right">Today</a>
    <?php 
    include 'conn.php';
    $sql = "SELECT DISTINCT `ip` FROM `visitor`";
    $result = $conn->query($sql);
    $sql = "SELECT SUM(pagevisit) AS pv FROM `visitor`";
    $sum = $conn->query($sql);
    $r = $sum->fetch_assoc();
    $date = new DateTime( gmdate("Y-m-d H:i:s"), new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
    $v = $date->format('d/m/Y h:i:s a');


echo'<table class="table table-striped">
        <thead>
            <tr>
                <th>TVisit:</th>
                <th>MYIP:</th>
                <th>Visitor</th>
                <th>DateTime:</th>
                <th>CVist:</th>
            </tr>
            <tr>    
                <td>'.$r['pv'].'</td>              
                <td>'.$_SERVER["REMOTE_ADDR"].'</td>               
                <td>'.$result->num_rows.'</td>                
                <td>'.$v.'</td>
                <td id="cvist"></td>
            </tr>
            <thead>
    </table>';

    ?>

    <table id="visitor-detail" class="display" style="width:100%">
        <thead>
            <tr>
                <th>IP Address</th>
                <th>Created On</th>
                <th>Updated On</th>
                <th>Visited Page</th>
            </tr>
        </thead>
    </table>
    
    <div id="resizable" style="height: 370px;border:1px solid gray;">
	    <div id="chartContainer1" style="height: 100%; width: 100%;"></div>
    </div>
    
</div>
</body>
</html>


<script>
var ipChart = [];
var TodayTotalVisit = 0;
var options1 = {
	animationEnabled: true,
	title: {
		text: "Today"
	},
	data: [{
		type: "column", //change it to line, area, bar, pie, etc
		legendText: "Try Resizing with the handle to the bottom right",
		showInLegend: true,
		dataPoints: ipChart
		}]
};
var viewby = $("#ViewBy").val();
if(viewby == "" || viewby == "current"){ viewby = "current";}
else{viewby="";}
   table =  $('#visitor-detail').DataTable({
    "destroy": true,
    "initComplete": function(settings, json) {
        debugger;
        json.aaData.forEach(function(x){
            //ipChart.push({x: new Date(x.updatedon), y: parseInt(x.pagevisit), label: x.ip});     
            ipChart.push({ y: parseInt(x.pagevisit), label: x.ip}); 
            TodayTotalVisit += parseInt(x.pagevisit);
            })
            $("#resizable").resizable({
	            create: function (event, ui) {
		        //Create chart.
		        $("#chartContainer1").CanvasJSChart(options1);
	        },
	        resize: function (event, ui) {
		        //Update chart size according to its container size.
		        $("#chartContainer1").CanvasJSChart().render();
            }
        });
            $("#cvist").text(TodayTotalVisit);
    },
    "processing": true,
    "bStateSave": true,
    "info": true,
    "oLanguage": {
        "sEmptyTable": "No Record available."
    },
    "lengthMenu": [
        [10, 20, 50, -1],
        [10, 20, 50, "All"]
    ],
    "order": [
        [0, "asc"]
    ],
    "filter": true,
    "ajax": {
        "url": 'adm.php?viewby='+viewby,
        "type": 'GET',
        "datatype": "json"
    },
    "columns": [
    {
        "data": "ip",
        "name": "0",
        "autoWidth": true,
        "className": 'details-control'
    },
    {
        "data": "createdon",
        "name": "0",
        "autoWidth": true,
         "render": function (data, type, row) {
                  return new Date(data).toLocaleString();
                  //= formatTime(data);
              }
    },
    {
        "data": "updatedon",
        "name": "0",
        "autoWidth": true,   
        "render": function (data, type, row) {
                  return new Date(data).toLocaleString();
                  //= formatTime(data);
              }
    },
    {
        "data": "pagevisit",
        "name": "0",
        "autoWidth": true
    }
    ]
});
    $('#visitor-detail tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            $('div.slider-alter', row.child()).slideUp(function () {
                row.child.hide();
                tr.removeClass('shown');
            });
        }
        else {
            $.ajax({
                type: "GET",            
                url: "http://api.ipstack.com/"+ row.data().ip+"?access_key=e13cc36bdacb7b405882ecccb5ee41f2",
                dataType: "json",
                success: function (response) {
                    debugger;
                    var data = response;

                    // Open this row
                    row.child(format(response), 'no-padding').show();
                    tr.addClass('shown');

                    $('div.slider-alter', row.child()).slideDown();
                },

                error: function (request, status, error) {
                    console.log('oh, errors here. The call to the server is not working.')
                }
            });

        }

    });
    
function formatTime(data) {
    debugger;
    if (typeof (data) != "undefined") {
        var dt = new Date(data);
        var utc = dt.getTime();
        var offset = 5.5;  
        var bombay = utc + (3600000*offset);
        var dt = new Date(bombay); 
        var date = dt.toString();
        date = date.split(' ');
        data = date[1] + " " + " " + date[2] + " " + date[3] + "  " + date[4];
        return data;
    }
}
    function format(d) {
 
    return '<div class="slider-alter">' +
    '<table cellpadding="5" cellspacing="0" border="0" class="new-st">' +

        
        '<td class="tdhead">Ip type:</td>' +
        '<td>' + d.type + '</td>' +
        '<td class="tdhead">continent_code:</td>' +
        '<td>' + d.continent_code + '</td>' +
        '</tr>' +
     '<tr>' +
        '<td class="tdhead"> continent_name:</td>' +
        '<td>' + d.continent_name + '</td>' +
         '<td class="tdhead">country_code :</td>' +
        '<td>' + d.country_code + '</td>' +
        '</tr>' +
                '<tr>' +
        '<td class="tdhead">country_name :</td>' +
        '<td>' + d.country_name + '</td>' +
            '<td class="tdhead">region_code :</td>' +
        '<td>' + d.region_code + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class="tdhead">region_name :</td>' +
        '<td>' + d.region_name + '</td>' +
         '<td class="tdhead">city :</td>' +
        '<td>' + d.city + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class="tdhead">zip:</td>' +
        '<td>' + d.zip + '</td>' +
           '<td class="tdhead">latitude:</td>' +
        '<td>' + d.latitude + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class="tdhead">longitude :</td>' +
        '<td>' + d.longitude + '</td>' +
           '<td class="tdhead">capital :</td>' +
        '<td>' + d.location.capital + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class="tdhead">calling_code :</td>' +
        '<td>' + d.location.calling_code + '</td>' +
             '<td class="tdhead">languages :</td>' +
        '<td>' + d.location.languages.name + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td class="tdhead">country_flag :</td>' +
        '<td><img src="' + d.location.country_flag + '"></td>' +
           '<td class="tdhead">country_flag_emoji :</td>' +
        '<td>' + d.location.country_flag_emoji + '</td>' +
        '</tr>' +
        '</table>' +
        '</div>';
}




</script>