<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data = $request->validated();
        $data['tenant_id'] = $userId;
        $booking = Booking::create($data);
        return response()->json([
            'message' => 'Booking added Successfully.',
            'data' => $booking
        ], 201);
    }

    public function show(Booking $booking)
    {
        //
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
