<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $words = Word::sortable()->paginate(10);
        return view('words.index', compact('words'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $themes = Theme::all(); // Retrieve all themes
        return view('words.create', compact('themes')); // Pass to the view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWordRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        // Create the new word
        $word = Word::create([
            'name' => $validated['name'],
        ]);

        // Check if themes are selected
        if ($request->has('themes')) {
            // Attach selected themes to the word (many-to-many relationship)
            $word->themes()->attach($request->themes);
        }

        return redirect()->route('words.index')->with('success', 'Word created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Word $word)
    {
        $word->load('themes'); // Load associated themes
        return view('words.show', compact('word'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Word $word)
    {
        $themes = Theme::all();
        return view('words.edit', compact('word', 'themes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWordRequest $request, Word $word)
    {

        $word->update([
            'name' => $request->name,
        ]);

        $word->themes()->sync($request->themes);
        return redirect()->route('words.index')->with('success', 'Word updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word)
    {
        $word->delete();
        return back()->with('success', 'Word deleted successfully.');
    }
}
