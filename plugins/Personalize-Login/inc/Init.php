<?php
/**
 * @package  AlecadddPlugin
 */
namespace Inc;

final class Init
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services()
	{
		return [
			Login::class,
			Enqueue::class,
			Register::class,
			LostPass::class,
			ResetPass::class,
			Redirect::class,
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
