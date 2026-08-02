<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BottleController extends Controller
{
    public function index(): View
    {
        return view('bottles.index', [
            'bottles' => Bottle::query()->orderBy('id')->get(),
        ]);
    }

    public function show(Request $request, Bottle $bottle): View
    {
        $view = $request->ajax() ? 'bottles._detail' : 'bottles.show';

        return view($view, compact('bottle'));
    }
}
