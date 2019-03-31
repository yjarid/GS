<?php
/**
 * functionality to redirect user 
 */
namespace GS;

// use \Login\BaseController;


class Redirect 
{
    static function urlLoginRedirect(){
        return site_url('login'). '/?redirect_to='. esc_url((is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ;
    }

}