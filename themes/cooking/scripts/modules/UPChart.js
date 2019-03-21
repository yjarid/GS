import $ from 'jquery';
import Chart from 'chart.js';


class UPChart {
    // 1. describe and create/initiate our object
    constructor() {
     this.profileReporting = $(".reporting-Container") ;  
     this.views = this.profileReporting.find("#rep-views");
     this.love =this.profileReporting.find("#rep-love");
     this.id =this.profileReporting.data("user");

     $.getJSON(jsData.root_url + '/wp-json/profile/v1/report/' + this.id, results => {

        var key_viewsbyCountry = [];
        var value_viewsbyCountry = [];
        key_viewsbyCountry = Object.keys(results['viewsCountry']);
        value_viewsbyCountry = Object.values(results['viewsCountry']);

        var CountryChart = new Chart(this.profileReporting.find(`#rep-country`), {
            type: 'bar',
            data: {
                labels: key_viewsbyCountry,
                datasets: [{
                    label: `views by Country`,
                    data: value_viewsbyCountry ,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255,99,132,1)', 
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            }
        });

        

         delete results['viewsCountry'];
         


         $.each(results , (index , value) => {
            var key_views = [];
            var value_views = [];
               key_views = Object.keys(value);
               value_views = Object.values(value);
   
               var myChart = new Chart(this.profileReporting.find(`#rep-${index}`), {
                       type: 'line',
                       data: {
                           labels: key_views,
                           datasets: [{
                               label: `Count of ${index}`,
                               data: value_views,
                               backgroundColor: 'rgba(255, 99, 132, 0.2)',
                               borderColor: 'rgba(255,99,132,1)', 
                               borderWidth: 1
                           }]
                       },
                       options: {
                           scales: {
                               yAxes: [{
                                   ticks: {
                                       beginAtZero:true,
                                       userCallback: function(label, index, labels) {
                                        // when the floored value is the same as the value we have a whole number
                                        if (Math.floor(label) === label) {
                                            return label;
                                        }
                   
                                    },
                                   }
                               }]
                           }
                       }
                   }); 
         });
 
     });

            // And for a doughnut sexe chart
        var myDoughnutChart = new Chart($('#rep-sexe'), {
            type: 'doughnut',
            data: {
                labels: ['Morocco' , 'Algeria' , 'Tunisia'],
                datasets: [{
                    label: `Viwers by Country`,
                    data: [.5, .2, .3],
                    backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe'],
                    borderColor: 'rgba(255,99,132,1)', 
                   
                }]
            },
            // options: options
        });
     }
}

export default UPChart;