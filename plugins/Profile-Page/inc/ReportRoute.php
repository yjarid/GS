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

  function reportingProfileResults(\WP_REST_Request $request){
    $user_args = array(
        //'role__not_in' => 'Administrator',
        'number' => '6',
        'include' => array($request["id"]),
    );

    $PopularChefs = new \WP_User_Query($user_args);

    foreach($PopularChefs->get_results() as $chef) {
      $id=  esc_attr( $chef->ID );   
    }
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
      'likes' => []
    ];
    foreach($t as $date) {
        $month = date("M",strtotime($date));
        $year = date("Y",strtotime($date));
        $month_key = 'user_count_'.$month.'_'.$year;
        $metaValue =  get_user_meta($id, $month_key  , true) ;

        $results['views'][ $month] = $metaValue ;

      }

      return $results;
 
}



}