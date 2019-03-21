<?php
/**
 * @package  
 */
namespace GS;

final class Init
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services()
	{
		return [
			Enqueue::class,
			Media::class,
			Comment::class,
			RestApi\SearchRoute::class,
			Ajax\FilterPost::class,
			Ajax\FollowChef::class,
			Ajax\SortPost::class,
			Ajax\LoadMore::class,
			Data\UserData::class,
			Data\PostData::class,
			GSRating::class
		
		];
	}

	/**
	 * Loop through the classes, initialize them,
	 * and call the register() method if it exists
	 * @return
	 */
	public static function register_services()
	{
		foreach ( self::get_services() as $class ) {
			$service = new $class ;
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}


}
