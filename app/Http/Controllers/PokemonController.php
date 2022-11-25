<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeHateRequest;
use App\Models\Likers;

class PokemonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function pokemonLike(LikeHateRequest $request){
        $validated = $request->validated();
        $like_pokemon = Likers::where([['user_id', auth()->user()->id],['pokemon_name',$validated['pokemon_name']],['image_link',$validated['image_link']]])->first();
        $liked = Likers::where('user_id', auth()->user()->id)->count();
        if ($like_pokemon === null){
            Likers::create([
                'user_id' => auth()->user()->id,
                'pokemon_name' => $validated['pokemon_name'],
                'image_link' => $validated['image_link'],
            ]);
        }else{
          if ($liked <= 3){
              Likers::create([
                  'user_id' => auth()->user()->id,
                  'pokemon_name' => $validated['pokemon_name'],
                  'image_link' => $validated['image_link'],
              ]);
          }else{
              return response()->json([
                  'message' => 'You have liked 3 Pokemons already.'
              ],500);
          }
            return response()->json([
                'message' => 'You already liked this Pokemon.'
            ],500);
        }



    }

    public function pokemonHate(LikeHateRequest $request){
        $validated = $request->validated();
        $hate_pokemon = Likers::where([['user_id', auth()->user()->id],['pokemon_name',$validated['pokemon_name']],['image_link',$validated['image_link']]])->first();
        $hated = Likers::where('user_id', auth()->user()->id)->count();
        if ($hate_pokemon === null){
            Likers::create([
                'user_id' => auth()->user()->id,
                'pokemon_name' => $validated['pokemon_name'],
                'image_link' => $validated['image_link'],
            ]);
        }else{
            if ($hated <= 3){
                Likers::create([
                    'user_id' => auth()->user()->id,
                    'pokemon_name' => $validated['pokemon_name'],
                    'image_link' => $validated['image_link'],
                ]);
            }else{
                return response()->json([
                    'message' => 'You have hated 3 Pokemons already.'
                ],500);
            }
            return response()->json([
                'message' => 'You already hated this Pokemon.'
            ],500);
        }
    }
}
