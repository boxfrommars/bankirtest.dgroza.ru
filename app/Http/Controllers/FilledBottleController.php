<?php

namespace App\Http\Controllers;

use App\Models\Beverage;
use App\Models\Bottle;
use App\Models\FilledBottle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FilledBottleController extends Controller
{
    public function index(): View
    {
        return view('filled-bottles.index', [
            'filledBottles' => FilledBottle::query()->with(['bottle', 'beverage'])->orderBy('id')->get(),
            'bottles' => Bottle::query()->orderBy('id')->get(),
            'beverages' => Beverage::query()->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $filledBottle = FilledBottle::query()->create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bottle_id' => ['required', 'integer', 'exists:bottles,id'],
            'beverage_id' => ['required', 'integer', 'exists:beverages,id'],
        ]));

        return redirect()
            ->route('filled-bottles.index')
            ->with('flashmessage', 'Наполненная бутылка '.$filledBottle->name.' добавлена');
    }

    public function confirmDelete(FilledBottle $filledBottle): View
    {
        return view('filled-bottles.delete', compact('filledBottle'));
    }

    public function destroy(FilledBottle $filledBottle): RedirectResponse
    {
        $filledBottle->delete();

        return redirect()
            ->route('filled-bottles.index')
            ->with('flashmessage', 'Наполненная бутылка удалена');
    }
}
