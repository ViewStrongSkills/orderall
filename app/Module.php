<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Route;

class Module extends Model
{

    protected $fillable = ['title', 'route'];
    private static $collations = [
        'index' => ['key' => 'read', 'title' => 'View'],
        'create' => ['key' => 'create', 'title' => 'Create'],
        'store' => ['key' => 'create', 'title' => 'Create'],
        'show' => ['key' => 'read', 'title' => 'View'],
        'edit' => ['key' => 'edit', 'title' => 'Edit'],
        'update' => ['key' => 'edit', 'title' => 'Edit'],
        'destroy' => ['key' => 'delete', 'title' => 'Delete'],
        'logout' => ['key' => 'logout', 'title' => 'Log out'],
        'login' => ['key' => 'login', 'title' => 'Log out'],
        'search' => ['key' => 'search', 'title' => 'Search'],
        'tags' => ['key' => 'tags', 'title' => 'Search by Tag'],
        'transactions' => ['key' => 'transactions', 'title' => 'View Transactions'],
        'transaction' => ['key' => 'transaction', 'title' => 'View Transaction'],
        'toggle-role' => ['key' => 'toggle-role', 'title' => 'Toggle Role'],
        'set-business' => ['key' => 'set-business', 'title' => 'Set Business'],
        'with-selected' => ['key' => 'with-selected', 'title' => 'With Selected'],
        'view-reviews' => ['key' => 'view-reviews', 'title' => 'View Reviews'],
    ];

    public static function resolveRouteToModule($route)
    {
        $pos = strripos($route, '.');
        $routeName = substr($route, 0, $pos);
        $routeMethod = substr($route, $pos+1);
        $routeMethod = self::$collations[$routeMethod]['key'];

        return $routeName . '.' . $routeMethod;
    }

    public static function resolveModuleBase($route)
    {
        $pos = strripos($route, '.');
        return substr($route, 0, $pos);
    }

    public static function getModulesSelectOptions()
    {
        $result = [];
        $exclude = [
            'unisharp.lfm',
        ];

        foreach (self::getModules() as $key => $module) {
            if(in_array($key, $exclude))
                continue;
            $result[$key] = $module['title'];
        }

        return $result;
    }

	public static function getModules()
	{
        $raw = Route::getRoutes();
        $routes = [];
		$modules = self::all();

        foreach ($raw as $route) {

            $pos = strripos($route->getName(), '.');
            $routeName = substr($route->getName(), 0, $pos);

            if(!$routeName)
                continue;

            $routeMethodKey = substr($route->getName(), $pos+1);

            $routeMethod = [
                'key' => $routeMethodKey,
                'title' => $routeMethodKey
            ];

            if (isset(self::$collations[$routeMethodKey])) {
                $routeMethod = [
                    'key' => self::$collations[$routeMethodKey]['key'],
                    'title' => self::$collations[$routeMethodKey]['title']
                ];
            }

            $routeTitle = $routeName;

            if(in_array($routeName, array_keys($routes))){
                if(!in_array($routeMethod, $routes[$routeName]['methods'])){
                    $routes[$routeName]['methods'][] = $routeMethod;
                }
                continue;
            } else {

                foreach ($modules as $module) {
        	        if($module->route == $routeName){
        	        	$routeTitle = $module->title;
        	        }
                }

                $routes[$routeName] = [
                    'title' => $routeTitle,
                    'methods' => [$routeMethod]
                ];

            }

        }

		return $routes;		
	}

}
