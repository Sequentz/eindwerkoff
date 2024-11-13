<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use App\Http\Requests\StoreThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Models\Word;
use Illuminate\Support\Facades\DB;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Theme::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $themes = $query->sortable()->paginate(10);
        return view('themes.index', compact('themes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $words = Word::all(); // All words for checkboxes
        $themes = Theme::all(); // Fetch all themes for the checkbox list (if you need them)
        return view('themes.create', compact('words', 'themes')); // Pass both to the view
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreThemeRequest $request)
    {
        // Retrieve the validated themes data
        $themes = $request->input('themes');

        // Start a transaction to ensure all themes are created successfully
        DB::transaction(function () use ($themes) {
            foreach ($themes as $themeData) {
                Theme::create([
                    'name' => $themeData['name'],
                ]);
            }
        });

        return redirect()->route('themes.index')->with('success', 'Themes added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        $theme->load('words');
        return view('themes.show', compact('theme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
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

        if ($request->has('words_to_add')) {
            foreach ($request->input('words_to_add') as $newWordName) {
                $newWord = Word::firstOrCreate(['name' => $newWordName]);
                $theme->words()->syncWithoutDetaching([$newWord->id]);
            }
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

    /**
     * Remove the specified resources from storage in bulk.
     */
    public function massDelete(Request $request)
    {
        $this->validate($request, [
            'themes' => 'required|array|min:1',
            'themes.*' => 'exists:themes,id',
        ]);

        try {
            Theme::destroy($request->themes);
            return redirect()->route('themes.index')->with('success', 'Themes deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('themes.index')->with('error', 'An error occurred while deleting themes.');
        }
    }
}
