<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use App\Http\Requests\StoreThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Models\Word;


class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themes = Theme::sortable()->paginate(10);
        return view('themes.index', compact('themes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $words = Word::all();
        return view('themes.create', compact('words'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreThemeRequest $request)
    {
        $theme = Theme::create($request->validated());

        if ($request->has('word_ids')) {
            $theme->words()->attach($request->input('word_ids'));
        }
        return redirect()->route('themes.index')->with('success', 'Theme created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {

        $theme->load('words');
        return view('themes.show', compact('theme'));
    }

    public function edit(Theme $theme)
    {
        $theme->load('words');
        $words = Word::all();
        return view('themes.edit', compact('theme', 'words'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThemeRequest $request, Theme $theme)
    {
        $theme->update($request->validated());

        if ($request->has('word_ids')) {
            $theme->words()->sync($request->input('word_ids'));
        }

        return redirect()->route('themes.index')->with('success', 'Theme updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();
        return redirect()->route('themes.index')->with('success', 'Theme deleted successfully.');
    }
}
