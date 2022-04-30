<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'collections' => $request->user()->collections,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['required', 'image'],
            'color' => ['required', 'string'],
        ]);

        $icon = Storage::put('icons', $request->file('icon'));

        $collection = $request->user()->collections()->create([
            'name' => $request->name,
            'icon' => $icon,
            'color' => $request->color,
        ]);

        return response()->json([
            'collection' => $collection,
        ], Response::HTTP_CREATED);
    }

    public function show(Collection $collection)
    {
        return response()->json([
            'collection' => $collection,
        ]);
    }

    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'image'],
            'color' => ['required', 'string'],
        ]);

        $collection->fill(
            $request->only(
                'name',
                'color'
            )
        );

        if ($request->file('icon')) {
            $icon = Storage::put('icons', $request->file('icon'));
            $collection->icon = $icon;
        }

        $collection->save();

        return response()->noContent();
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();

        return response()->noContent();
    }
}
