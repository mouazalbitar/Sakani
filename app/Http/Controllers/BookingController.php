<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookingRequest;
use App\Models\Apartment;
use App\Models\Booking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return response()->json([
            'message' => 'Completed Successfully.',
            'data' => $bookings
        ], 200);
    }

    public function addBooking(AddBookingRequest $request)
    {
        $userId = Auth::user()->id;
        $valid = $request->validated();
        try {
            return DB::transaction(function () use ($request, $userId, $valid) {
                $isBooked = Booking::where('apartment_id', $valid['apartment_id'])
                    ->where(function ($query) use ($request, $valid) {
                        $query->where('start_date', '<=', $valid['end_date'])
                            ->where('end_date', '>=', $valid['start_date']);
                    })->lockForUpdate()->exists();
                if ($isBooked) {
                    throw new Exception('The Apartment is already Booked for the selected dates.', 422);
                }
                $booking = Booking::create(['tenant_id' => $userId] + $valid);
                return response()->json([
                    'message' => 'Booking Added Successfully.',
                    'data' => $booking
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while adding booking.',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function showBookings()
    {
        $userId = Auth::user()->id;
        $bookings = Booking::where('tenant_id', $userId)->get();
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $bookings
        ], 200);
    }

    public function showApartmentsBookings()
    {
        $userId = Auth::user()->id;
        $apartmentIds = Apartment::where('owner_id', $userId)->pluck('id')->toArray();
        $bookings = Booking::whereIn('apartment_id', $apartmentIds)->get(); //->with(['tenant:id,name,phone', 'apartment:id,title'])
        // $bookings->makeHidden(['owner_id', 'owner']);
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $bookings
        ], 200);
    }

    public function update(Request $request, Booking $booking)
    {
        //
    }

    public function destroy(Booking $booking)
    {
        //
    }
}
