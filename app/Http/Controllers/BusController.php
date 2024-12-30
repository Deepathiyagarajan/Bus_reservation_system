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
            'price' => 'required',
        ]);

        DB::table('bus_name')->insert([
            'bus_name' => $request->bus_name,
            'available_seat' => $request->available_seats,
            'total_seat' => $request->available_seats,
            'from' => $request->from,
            'to' => $request->to_address,
            'price'=> $request->price,
        ]);

        return redirect()->route('home')->with('success', 'Bus added successfully!');
    }
    // public function view_booking(Request $request)
    // {
    //     $booking_details = DB::table('user_booking_details')->where('user_id', (Auth::id()))->get();
    //     return view('home',compact('booking_details'));
    // }

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
        if (!$bus) {
            return redirect()->route('bus.view')->with('error', 'Bus not found.');
        }

        return view('bus.edit', compact('bus'));
    }

    public function update_bus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'bus_name' => 'required|string|max:255',
            'total_seat' => 'required|integer|min:1',
            'from' => 'required',
            'to' => 'required',
            'price' => 'required',
        ]);

        try {
            DB::table('bus_name')
                ->where('id', $id)
                ->update([
                    'bus_name' => $validatedData['bus_name'],
                    'total_seat' => $validatedData['total_seat'],
                    'from' => $request->from,
                    'to' => $request->to,
                    'price' => $request->price,
                ]);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            return redirect()->route('bus.view')->with('success', 'Bus details updated successfully!');

    }

    public function showBusList(Request $request)
    {
        $date = $request->journey_date;
        $buses = DB::table('bus_name')->get();
        return view('bus.book', compact('buses','date'));
    }

    public function selectBusForBooking(Request $request ,$id)
    {


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
        $validatedData = $request->validate([
            'ticket_count' => 'required|integer',
            'user_name' => 'required|string',
            'email' => 'required|email',
            'mobile_number' => 'required|string',
            'gender' => 'required|string',

            'id' => 'required',
        ]);

        DB::table('user_booking_details')->insert([
            'bus_name' => $request->bus_name,
            'ticket_count' => $request->ticket_count,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'gender' => $request->gender,

            'bus_id' => $request->id,
            'booking_date' => $request->date,
            'user_id' => Auth::id(),
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ]);

        DB::table('bus_name')
            ->where('id', $validatedData['id'])
            ->decrement('available_seat', $validatedData['ticket_count']);

        return redirect()->route('home')->with('success', 'Booking successful!');
    }


    public function getBookingDetails(Request $request)
    {
        
        $bookingDetails = DB::table('user_booking_details')
            ->join('bus_name', 'user_booking_details.bus_id', '=', 'bus_name.id')
            ->select([
                'user_booking_details.user_name',
                'bus_name.bus_name',
                'user_booking_details.ticket_count',
                'user_booking_details.booking_date',
                'bus_name.price',
                DB::raw('bus_name.price * user_booking_details.ticket_count AS total_price')
            ]);
            // Optionally, filter by user if needed
            // ->where('user_booking_details.user_id', Auth::id());


        return datatables()->of($bookingDetails)
            ->addIndexColumn()
            ->make(true);
    }


}
