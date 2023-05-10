function drawHistogram(div_id, competenceMoyenneMap) {
    /* [['competence': 'moyenne']] */
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart)

    var CMList = [["Element", "Density", { role: "style" } ]];

    competenceMoyenneMap.forEach(competenceMoyenne => {
        CMList.push([competenceMoyenne[0], competenceMoyenne[1], "#000000"]);
    });

    function drawChart() {

        var data = google.visualization.arrayToDataTable(CMList);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

        var options = {
            title: "Moyenne en fonction des compétences",
            width: 600,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById(div_id));
        chart.draw(view, options);
    }
}