<?php

namespace App\Http\Controllers\Admin;

use App\Module;
use Illuminate\Http\Request;

use Route;

class ModuleController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.module.index')
            ->withModules(Module::getModules());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->modules as $module) {
            $exists = Module::where('route', $module['route'])->first();
            $title = !empty($module['title']) ? $module['title'] : $module['route'];
            
            if($exists) {
                $exists->update([
                    'title' => $title
                ]);
            } else {
                Module::create([
                    'title' => $title,
                    'route' => $module['route']
                ]);
            }
        }

        flash()->success('Modules updated');
        return redirect(route('admin.module.index'));

    }

}
