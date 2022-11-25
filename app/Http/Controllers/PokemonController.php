<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeHateRequest;
use App\Models\Haters;
use App\Models\Likers;
use App\Models\User;

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
            return response()->json([
                'message' => 'You like .'.$validated['pokemon_name'].'!'
            ],500);
        }else if ($liked <= 3){
              Likers::create([
                  'user_id' => auth()->user()->id,
                  'pokemon_name' => $validated['pokemon_name'],
                  'image_link' => $validated['image_link'],
              ]);
          }else{
              return response()->json([
                  'message' => 'You already liked this Pokemon or you have more than 3 liked pokemon.'
              ],500);
          }




    }

    public function pokemonHate(LikeHateRequest $request){
        $validated = $request->validated();
        $hate_pokemon = Haters::where([['user_id', auth()->user()->id],['pokemon_name',$validated['pokemon_name']],['image_link',$validated['image_link']]])->first();
        $hated = Haters::where('user_id', auth()->user()->id)->count();
        if ($hate_pokemon === null){
            Haters::create([
                'user_id' => auth()->user()->id,
                'pokemon_name' => $validated['pokemon_name'],
                'image_link' => $validated['image_link'],
            ]);
            return response()->json([
                'message' => 'You hate.'.$validated['pokemon_name'].'!'
            ],500);
        }else if($hated <= 3){
            Haters::create([
                'user_id' => auth()->user()->id,
                'pokemon_name' => $validated['pokemon_name'],
                'image_link' => $validated['image_link'],
            ]);
        }else{
            return response()->json([
                'message' => 'You already hated this Pokemon or you have more than 3 hated pokemon.'
            ],500);
        }
    }

    public function getUserReactions(){
        $user_reactions_like = User::with('likers','haters')
            ->paginate(50);

        return response()->json($user_reactions_like);
    }
}
