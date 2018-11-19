<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Module;
use App\Role;

use Closure;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Auth::user();
        if (Auth::guard()->guest() || $user->hasRole('Developer')) {
            return $next($request);
        }

        $module = Module::resolveRouteToModule(Route::currentRouteName());
        $route = request()->route();

        // basic route based check
        if(!$user->can($module)){
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return response()->view('errors.403');
            }
        }

        switch ($module) {

            // BUSINESSES
            case 'businesses.create':
                if (!$user->canCreateBusiness()) {
                    flash()->error('You are not authorized to create a business');
                    return response()->view('errors.403', [], 403);
                }
                break;
            case 'businesses.edit':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to edit this business');
                    return response()->view('errors.403', [], 403);
                }
                break;
            case 'businesses.delete':
                if (!$user->canDeleteBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to delete this business');
                    return response()->view('errors.403', [], 403);
                }
                break;

            // MENUS
            case 'menus.create':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to create a menu');
                    return response()->view('errors.403', [], 403);
                }
                break;
            case 'menus.edit':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to edit this menu');
                    return response()->view('errors.403', [], 403);
                }
                break;
            case 'menus.delete':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to delete this menu');
                    return response()->view('errors.403', [], 403);
                }
                break;


            // MENUITEMS
            case 'menuitems.create':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to create a menu item');
                    return response()->view('errors.403', [], 403);
                }
                break;
            case 'menuitems.edit':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to edit this menu item');
                    return response()->view('errors.403', [], 403);
                }
                break;
            case 'menuitems.delete':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to delete this menu item');
                    return response()->view('errors.403', [], 403);
                }
                break;

            // MENUEXTRAS
            case 'menuextras.create':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to create an extra');
                    return response()->view('errors.403', [], 403);
                }
                break;
            case 'menuextras.edit':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to edit this extra');
                    return response()->view('errors.403', [], 403);
                }
                break;
            case 'menuextras.delete':
                if (!$user->canEditBusiness($route->parameter('business'))) {
                    flash()->error('You are not authorized to delete this extra');
                    return response()->view('errors.403', [], 403);
                }
                break;

            // REVIEWS
            case 'reviews.create':
                if (!$user->canReviewItem($route->parameter('menuitem'))) {
                    flash()->error('You are not authorized to review this item');
                    return response()->view('errors.403', [], 403);
                }
                break;

            default:
                break;
        }

        return $next($request);
    }
}
