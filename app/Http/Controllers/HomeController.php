<?php

namespace App\Http\Controllers;

use App\Models\FilledBottle;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'filledBottles' => FilledBottle::query()
                ->with(['bottle', 'beverage'])
                ->orderBy('id')
                ->get(),
        ]);
    }
}
