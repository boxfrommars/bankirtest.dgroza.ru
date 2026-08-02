<?php

namespace App\Http\Controllers;

use App\Models\Beverage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $searchString = null;
        $searchResult = new Collection;

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'searchstring' => ['required', 'string', 'max:255'],
            ]);
            $searchString = trim($validated['searchstring']);
            $terms = preg_split('/\s+/u', mb_strtolower($searchString), -1, PREG_SPLIT_NO_EMPTY);

            $searchResult = Beverage::query()
                ->orderBy('id')
                ->get()
                ->filter(function (Beverage $beverage) use ($terms): bool {
                    $haystack = mb_strtolower($beverage->name.' '.$beverage->description);

                    foreach ($terms as $term) {
                        if (mb_stripos($haystack, $term) === false) {
                            return false;
                        }
                    }

                    return true;
                })
                ->values();
        }

        return view('search.index', compact('searchString', 'searchResult'));
    }
}
