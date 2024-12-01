<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThemeResource;
use App\Http\Resources\WordResource;
use App\Models\Theme;
use App\Models\Word;

/**
 * @OA\Info(
 *     title="API Documentatie",
 *     version="1.0.0",
 *     description="Documentatie voor GET endpoints"
 * )
 */
class ApiController extends Controller
{
    /**
     * Get all themes.
     *
     * @OA\Get(
     *     path="/api/themes",
     *     summary="Lijst van thema's ophalen",
     *     @OA\Response(
     *         response=200,
     *         description="Succesvol ophalen van thema's",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Thema naam"),
     *                 @OA\Property(property="description", type="string", example="Beschrijving van het thema")
     *             )
     *         )
     *     )
     * )
     */
    public function getThemes()
    {
        return ThemeResource::collection(Theme::all());
    }

    /**
     * Get all words.
     *
     * @OA\Get(
     *     path="/api/words",
     *     summary="Lijst van woorden ophalen",
     *     @OA\Response(
     *         response=200,
     *         description="Succesvol ophalen van woorden",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="word", type="string", example="Voorbeeldwoord"),
     *                 @OA\Property(property="language", type="string", example="Nederlands")
     *             )
     *         )
     *     )
     * )
     */
    public function getWords()
    {
        return WordResource::collection(Word::all());
    }
}
