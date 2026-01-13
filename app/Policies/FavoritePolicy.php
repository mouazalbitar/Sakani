<?php

namespace App\Policies;

use App\Models\Apartment;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class FavoritePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function create(User $user, Apartment $apartment)
    {
        if ($apartment->owner_id === $user->id) {
            return false;
        }
        // if ($apartment->is_approved !== 'approved') {
        //     return Response::deny('This apartment isn\'t approved yet.');
        // }
        // return ! Favorite::where('apartment_id', $apartment->id)
        //     ->where('user_id', $user->id)
        //     ->exists(); // لا ترجع بيانات، بس روح اسأل
        return true;    
    }
    public function delete(User $user, Favorite $favorite)
    {
        if ($favorite->user_id !== $user->id) {
            return Response::deny('You don\'t own this Favorite.');
        }
        return true;
    }
}
