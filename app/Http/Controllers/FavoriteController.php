<?php

namespace App\Http\Controllers;

use App\Http\Requests\Favoritesrequest;
use App\Models\Apartment;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::all();
        return response()->json([
            'message' => 'Completed Successfully.',
            'data' => $favorites
        ], 200);
    }

    public function store(Favoritesrequest $request)
    {
        $valid = $request->validated();
        $apartment = Apartment::findOrFail($valid['apartment_id']);
        $this->authorize('create', [Favorite::class, $apartment]);
        Favorite::create([
            'apartment_id' => $valid['apartment_id'],
            'user_id' => Auth::user()->id
        ]);
        return response()->json([
            'message' => 'Favorite added Successfully',
        ], 200);
    }

    public function userFavorites()
    {
        $this->authorize('viewAny', Favorite::class);
        $favorites = Favorite::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'message' => 'Completed Successfully.',
            'data' => $favorites
        ], 200);
    }

    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    public function destroy(Favorite $favorite)
    {
        $this->authorize('delete', $favorite);
        $favorite->delete();
        return response()->json([
            'message' => 'Favorite removed Successfully.',
        ], 200);
    }
}
