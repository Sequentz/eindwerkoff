<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThemeResource;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ThemeResource::collection(Theme::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        //
    }
    public function getWordsForTheme($themeId)
    {
        $theme = Theme::with('words')->find($themeId);

        if (!$theme) {
            return response()->json(['error' => 'Theme not found'], 404);
        }

        // Transform words to only include id, name, and theme_id
        $words = $theme->words->map(function ($word) {
            return [
                'id' => $word->id,
                'name' => $word->name,
                'theme_id' => $word->pivot->theme_id,
            ];
        });

        return response()->json([
            'theme' => $theme->name,
            'words' => $words,
        ]);
    }
}
