<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
        ////////////////////////////////////////////////////////////
        //--------------------- ADMIN ROUTES ---------------------//
        ////////////////////////////////////////////////////////////
        $router->withModule('Admin')
            ->addRoute('admin/<presenter>/<action>[/<id>]', 'Default:default');

		////////////////////////////////////////////////////////////
		//--------------------- FRONT ROUTES ---------------------//
		////////////////////////////////////////////////////////////
		$router->withModule('Front')
			// ARTICLES
			->addRoute('[<locale=en cs|en>/]<presenter>/<action>[/<id>/<htaccess>]', 'Default:default')
			// SITEMAP
			->addRoute('sitemap.xml', 'Sitemap:default')
			->addRoute('sitemap', 'Sitemap:default')

			// MOST GENERAL ROUTE
			->addRoute('[<locale=en cs|en>/]<presenter>/<action>[/<slug>]', 'Default:default');

		return $router;
	}

}
