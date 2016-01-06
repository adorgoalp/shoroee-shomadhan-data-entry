var authorNumber = 1;
function addRow(tableID)
{
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    var row = table.insertRow(rowCount);
    row.innerHTML = '<p class="lead">Co-author ' + authorNumber + '</p>';
    authorNumber++;
    rowCount = table.rows.length;
    row = table.insertRow(rowCount);
    row.innerHTML = "<td colspan=\"2\">" +
            "<div class=\"form-group\">" +
            "<label>Name</label>" +
            "<input name=\"NAME[]\" type=\"text\" class=\"form-control\" id=\"authorName\" placeholder=\"Firstname Lastname\" required>" +
            "</div>" +
            "</td>" +
            "<td>" +
            "<div class=\"form-group\">" +
            "<label>Address</label>" +
            "<input name=\"ADDRESS[]\" type=\"text\" class=\"form-control\" id=\"authorAddress\" placeholder=\"Address\" required>" +
            "</div>" +
            "</td>" +
            "<td>" +
            "<div class=\"form-group\">" +
            "<label>Country</label>" +
            "<input name=\"COUNTRY[]\" type=\"text\" class=\"form-control\" id=\"authorCountry\" placeholder=\"Bangladesh\" required>" +
            "</div>" +
            "</td>";
    rowCount = table.rows.length;
    row = table.insertRow(rowCount);
    row.innerHTML = "<td>" +
            "<div class=\"form-group\">" +
            "<label>Email</label>" +
            "<input name=\"EMAIL[]\" type=\"email\" class=\"form-control\" id=\"authorEmail\" placeholder=\"albert@gmail.com\" required>" +
            "</div>" +
            "</td>" +
            "<div class=\"form-group\">" +
            "<label>Telephone</label>" +
            "<input name=\"TELEPHONE[]\" type=\"tel\" class=\"form-control\" id=\"authorTel\" placeholder=\"+8802924578\" required>" +
            "</div>" +
            "</td>" +
            "<td>" +
            "<div class=\"form-group\">" +
            "<label>Mobile</label>" +
            "<input name=\"MOBILE[]\"  type=\"tel\" class=\"form-control\" id=\"authorTel\" placeholder=\"+8801234567891\" required>" +
            "</div>" +
            "</td>" +
            "<td>" +
            "<div class=\"form-group\">" +
            "<label>Orcid</label>" +
            "<input name=\"ORCID[]\" type=\"text\" class=\"form-control\" id=\"authorOrcid\" required>" +
            "</div>" +
            "</td>";
}
function drawChart(values, title, xLabel, yLabel, chartType, place) {
    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', xLabel);
    data.addColumn('number', yLabel);
    var rows = new Array();
    for (var key in values)
    {
        var value = values[key];
        rows.push(new Array(key, value))
    }
    data.addRows(rows);
    // Instantiate and draw our chart, passing in some options.
    if (chartType === 'BarChart')
    {
        var options = {'title': title,
            'width': 800,
            'height': 600};
        var chart = new google.visualization.BarChart(document.getElementById(place));
        chart.draw(data, options);
    } else if (chartType === 'ColumnChart')
    {
        var options = {'title': title,
            'width': 800,
            'height': 600};
        var chart = new google.visualization.ColumnChart(document.getElementById(place));
        chart.draw(data, options);
    } else {
        var options = {'title': title,
            'width': 800,
            'height': 600,
            'is3D': true};
        var chart = new google.visualization.PieChart(document.getElementById(place));
        chart.draw(data, options);
    }
}