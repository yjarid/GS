<?php

/**
 * @package  
 */
namespace Profile;


class ReportRoute
{

  public function register() {
    add_action('rest_api_init', array($this , 'reportingProfileRoute'));
  }

 function  reportingProfileRoute(){
    register_rest_route('profile/v1', 'report/(?P<id>\d+)', array(
        'methods' => \WP_REST_SERVER::READABLE  ,
        'callback' => array($this , 'reportingProfileResults')
      ));
  }

  function reportingProfileResults( $request){
    
    $t = [
        date('d-m-Y', strtotime("-5 month")),
        date('d-m-Y', strtotime("-4 month")),
        date('d-m-Y', strtotime("-3 month")),
        date('d-m-Y', strtotime("-2 month")),
        date('d-m-Y', strtotime("-1 month")),
        date('d-m-Y'),         
        ];

    
    $results = [
      'views'=> [],
      'love' => [],
      'made' => []
    ];
    foreach($t as $date) {
        $month = date("M",strtotime($date));
        $year = date("Y",strtotime($date)); 
        $id = $request["id"] ;
        $views =  get_user_meta($id, 'user_views_'.$month.'_'.$year  , true) ;
        $love =  get_user_meta($id, 'user_love_'.$month.'_'.$year  , true) ;
        $made =  get_user_meta($id, 'user_made_'.$month.'_'.$year  , true) ;
        

        $results['views'][ $month] = $views ;
        $results['love'][ $month] = $love ;
        $results['made'][ $month] = $made ;

      }
      $viewsByCountry = get_user_meta($id, 'user_views_byCountry'  , true);
      $viewsByCountry = (!empty($viewsByCountry) ? $viewsByCountry : []);

       arsort($viewsByCountry) ;

      $results['viewsCountry'] = $viewsByCountry;

      return $results;
 
}



}