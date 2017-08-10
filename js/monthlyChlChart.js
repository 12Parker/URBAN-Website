function displayChart(siteVar) 
{
	siteName = siteVar;
$(document).ready(function() {
	site = siteName;
	$.ajax({
		url : "https://mcmastertreeid.ca/Urban/php/getMonthlyData.php",
		type : "GET",
		data : {
			siteName: site
		},
		success : function(data) {

			var siteID = [];
			var chlorophyllData = [];

			for(var i in data) {
				siteID.push(data[i].Month);
				chlorophyllData.push(data[i].Chlorophyll);
			}
			//console.log(siteID);
			//console.log(chlorophyllData);
			var chartdata = {
				labels: siteID,
				datasets: [
					{
						label: "Chlorophyll",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: chlorophyllData
					}
				]
			};

			var ctx = document.getElementById("myChart").getContext('2d');

			var myChart = new Chart(ctx, {
				type: 'line',
				data: chartdata,
				options: {
				    responsive: false,
				    maintainAspectRatio: true,
    				
					title: {
						display: true,
						fontSize: 12,
						text: 'Average Monthly Chl Values'
					},
					legend: {
						display: false
					},
					scales: {
						xAxes: [{
							display: false
						}]
					}
				}
			});
		},
		error : function(data) {

		}
	});
});
}