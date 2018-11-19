<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRedirectUrl($request, $model)
    {
        $route = strtolower(class_basename($model));

        if (isset($request->save_and_close)) {
            return route('admin.' . $route . '.index');
        } else if (isset($request->save_and_new)){
            return route('admin.' . $route . '.create');
        } else {
            $id = isset($model->slug) ? $model->slug : $model->id;
            return route('admin.' . $route . '.edit', $id);
        }        
    }
    
}
