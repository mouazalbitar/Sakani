<?php

namespace App\Policies;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Review $review): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Apartment $apartment)
    {
        $hasBooked = Booking::where('apartment_id', $apartment->id)
            ->where('tenant_id', $user->id)
            ->where('status', 'approved')
            ->where('end_date', '<', now())
            ->exists();

        if (!$hasBooked) {
            return false;
        }
        $alreadyReviewed = Review::where('apartment_id', $apartment->id)
            ->where('user_id', $user->id)
            ->exists();
        if ($alreadyReviewed) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Review $review): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Review $review): bool
    {
        return false;
    }
}
