import $ from 'jquery';
import Chart from 'chart.js';


class UPChart {
    // 1. describe and create/initiate our object
    constructor() {
     this.profileReporting = $(".profile-rep") ;  
     this.views = this.profileReporting.find("#rep-views");
     this.like =this.profileReporting.find("#rep-like");
     this.id =this.profileReporting.data("user");

     $.getJSON(jsData.root_url + '/wp-json/profile/v1/report/' + this.id, results => {
         var key_views = [];
         var value_views = [];
            key_views = Object.keys(results['views']);
            value_views = Object.values(results['views']);

            var myChart = new Chart(this.views, {
                    type: 'line',
                    data: {
                        labels: key_views,
                        datasets: [{
                            label: 'Number of Views',
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
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });

         
     

    //  var myChart = new Chart(this.views, {
    //     type: 'line',
    //     data: {
    //         labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    //         datasets: [{
    //             label: 'Number of Views',
    //             data: [12, 19, 3, 5, 2, 3],
    //             backgroundColor: 'rgba(255, 99, 132, 0.2)',
    //             borderColor: 'rgba(255,99,132,1)', 
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             yAxes: [{
    //                 ticks: {
    //                     beginAtZero:true
    //                 }
    //             }]
    //         }
    //     }
    // });

    // var myChart2 = new Chart(this.like, {
    //     type: 'line',
    //     data: {
    //         labels: ["eeee", "Blue", "Yellow", "Green", "Purple", "Orange"],
    //         datasets: [{
    //             label: 'Number of Likes',
    //             data: [12, 19, 3, 5, 2, 3],
    //             backgroundColor: 'rgba(255, 99, 132, 0.2)',
    //             borderColor: 'rgba(255,99,132,1)', 
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             yAxes: [{
    //                 ticks: {
    //                     beginAtZero:true
    //                 }
    //             }]
    //         }
    //     }
     });
     }
}

export default UPChart;