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
        $words = $request->input('words');

        foreach ($words as $wordData) {
            // Create a new word record
            $word = Word::create([
                'name' => $wordData['name'],
            ]);

            // Attach selected themes if any
            if (isset($wordData['themes'])) {
                $word->themes()->sync($wordData['themes']);
            }
        }

        return redirect()->route('words.index')->with('success', 'Words added successfully!');
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

    public function massDelete(Request $request)
    {
        // Validate the request to ensure 'words' is an array of valid word IDs
        $this->validate($request, [
            'words' => 'required|array|min:1',
            'words.*' => 'exists:words,id', // Ensure each word ID exists
        ]);

        // Get the count of the selected words
        $deletedCount = count($request->words);

        // Delete the selected words
        Word::destroy($request->words);

        // Check if only one word was deleted
        if ($deletedCount === 1) {
            // Redirect to the words index page with a single word success message
            return redirect()->route('words.index')->with('success', 'Word deleted successfully.');
        }

        // Redirect to the words index page with a multiple words success message
        return redirect()->route('words.index')->with('success', 'Selected words deleted successfully.');
    }
}
