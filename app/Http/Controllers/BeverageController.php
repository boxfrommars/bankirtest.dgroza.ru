<?php

namespace App\Http\Controllers;

use App\Models\Beverage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BeverageController extends Controller
{
    public function index(): View
    {
        return view('beverages.index', [
            'entries' => Beverage::query()->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $beverage = Beverage::query()->create($this->validated($request));

        return redirect()
            ->route('beverages.index')
            ->with('flashmessage', 'Напиток '.$beverage->name.' добавлен');
    }

    public function show(Request $request, Beverage $beverage): View
    {
        $view = $request->ajax() ? 'beverages._detail' : 'beverages.show';

        return view($view, compact('beverage'));
    }

    public function edit(Beverage $beverage): View
    {
        return view('beverages.edit', compact('beverage'));
    }

    public function update(Request $request, Beverage $beverage): RedirectResponse
    {
        $beverage->update($this->validated($request, $beverage));

        return redirect()
            ->route('beverages.show', $beverage)
            ->with('flashmessage', 'Напиток '.$beverage->name.' изменён');
    }

    public function confirmDelete(Beverage $beverage): View
    {
        return view('beverages.delete', compact('beverage'));
    }

    public function destroy(Beverage $beverage): RedirectResponse
    {
        $beverage->delete();

        return redirect()
            ->route('beverages.index')
            ->with('flashmessage', 'Напиток удалён');
    }

    private function validated(Request $request, ?Beverage $beverage = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('beverages', 'name')->ignore($beverage?->id),
            ],
            'description' => ['required', 'string'],
        ]);
    }
}
