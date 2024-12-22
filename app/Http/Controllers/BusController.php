<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BusController extends Controller
{
    public function add_bus()
    {
        return view('bus.add');
    }

    public function store_bus(Request $request)
    {
        $validatedData = $request->validate([
            'bus_name' => 'required|string|max:255',
            'available_seats' => 'required|integer|min:1',
            'from' => 'required',
        ]);
        // dd('haii');

        DB::table('bus_name')->insert([
            'bus_name' => $request->bus_name,
            'available_seat' => $request->available_seats,
            'total_seat' => $request->available_seats,
            'from' => $request->from,
            'to' => $request->to_address,
        ]);

        return redirect()->route('home')->with('success', 'Bus added successfully!');
    }
    public function view_booking(Request $request)
    {
        $booking_details = DB::table('user_booking_details')->where('user_id', (Auth::id()))->get();
        return view('home',compact('booking_details'));
    }

    public function view_buses(Request $request)
    {
        $buses = DB::table('bus_name')->get();

        return view('bus.view', compact('buses'));
    }

    public function show_bus(Request $request,$id)
    {

        $bus = DB::table('bus_name')->where('id', $id)->first();

        if (!$bus) {
            return redirect()->route('bus.view')->with('error', 'Bus not found.');
        }

        return view('bus.show', compact('bus'));
    }

    public function edit_bus($id)
    {
        $bus = DB::table('bus_name')->where('id', $id)->first();
        // dd($bus);
        if (!$bus) {
            return redirect()->route('bus.view')->with('error', 'Bus not found.');
        }

        return view('bus.edit', compact('bus'));
    }

    public function update_bus(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'bus_name' => 'required|string|max:255',
            'total_seat' => 'required|integer|min:1',
            'from' => 'required',
            'to' => 'required',
        ]);

        try {
            DB::table('bus_name')
                ->where('id', $id)
                ->update([
                    'bus_name' => $validatedData['bus_name'],
                    'total_seat' => $validatedData['total_seat'],
                    'from' => $request->from,
                    'to' => $request->to,
                ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


        return redirect()->route('bus.view')->with('success', 'Bus details updated successfully!');
    }

    public function showBusList(Request $request)
    {
        // dd($request->all());
        $date = $request->journey_date;
        $buses = DB::table('bus_name')->get();
        return view('bus.book', compact('buses','date'));
    }

    public function selectBusForBooking(Request $request ,$id)
    {
        // Fetch bus data from the database
        // dd($request->all());

        $date = $request->journey_date;
        $bus = DB::table('bus_name')->where('id', $id)->first();
        $available_seat = DB::table('user_booking_details')->where('bus_id', $id)->where('booking_date',$date)->sum('ticket_count');
        $available_seat =(($bus->total_seat)- $available_seat);

        if (!$bus) {
            return redirect()->route('bus.list')->with('error', 'Bus not found.');
        }

        return view('bus.ticket_booking', compact('bus','date','available_seat'));
    }

    public function submitBooking(Request $request)
{
    // Validate request data
    $validatedData = $request->validate([
        'ticket_count' => 'required|integer',
        'user_name' => 'required|string',
        'email' => 'required|email',
        'mobile_number' => 'required|string',
        'gender' => 'required|string',
        'bus_id' => 'required|integer', // Ensure bus_id is required and validated
        'date' => 'required|date'  // Validate booking date
    ]);

    // Get the bus_id from the request
    $busId = $validatedData['bus_id'];

    // Get bus information
    $bus = DB::table('bus_name')->where('id', $busId)->first();

    if (!$bus) {
        return response()->json([
            'success' => false,
            'message' => 'Bus not found!'
        ]);
    }

    // Calculate available seats
    $availableSeats = DB::table('user_booking_details')
        ->where('bus_id', $busId)
        ->where('booking_date', $validatedData['date'])
        ->sum('ticket_count');

    $availableSeats = $bus->total_seat - $availableSeats;

    // Check if enough seats are available
    if ($availableSeats < $validatedData['ticket_count']) {
        return response()->json([
            'success' => false,
            'message' => 'Not enough available seats.'
        ]);
    }

    // Store booking details
    $booking = DB::table('user_booking_details')->insertGetId([
        'bus_name' => $request->bus_name,
        'ticket_count' => $validatedData['ticket_count'],
        'user_name' => $validatedData['user_name'],
        'email' => $validatedData['email'],
        'mobile_number' => $validatedData['mobile_number'],
        'gender' => $validatedData['gender'],
        'bus_id' => $busId,
        'booking_date' => $validatedData['date'],
        'user_id' => Auth::id(),
    ]);

    // Update available seats in bus table
    DB::table('bus_name')
        ->where('id', $busId)
        ->decrement('available_seat', $validatedData['ticket_count']);

    // Get the newly added booking detailss
    $newBooking = DB::table('user_booking_details')
        ->where('id', $booking)
        ->first();

    // Return the new booking as JSON for DataTable update
    return response()->json([
        'success' => true,
        'message' => 'Booking successful!',
        'booking' => $newBooking
    ]);
}


}
