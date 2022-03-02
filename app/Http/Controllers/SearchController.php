<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Shift;
use App\Models\Volunteer;
use App\Models\ContactMaster;
use App\Models\NonProfit;
use App\Models\Artist;
use Log;

class SearchController extends Controller
{
    public function index() {
        $search = request()->input("search");

        $events = Event::where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('contact_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('contact_email', 'LIKE', '%'.$search.'%')
                    ->orWhere('contact_phone', 'LIKE', '%'.$search.'%')
                    ->paginate(20);

        $shifts = Shift::where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('item', 'LIKE', '%'.$search.'%')
                    ->paginate(20);

        $volunteers = Volunteer::where('first_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$search.'%')
                    ->orWhere('address_line_1', 'LIKE', '%'.$search.'%')
                    ->orWhere('address_line_2', 'LIKE', '%'.$search.'%')
                    ->orWhere('city', 'LIKE', '%'.$search.'%')
                    ->orWhere('country_text', 'LIKE', '%'.$search.'%')
                    ->orWhere('state_text', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orWhere('phone', 'LIKE', '%'.$search.'%')
                    ->orWhere('gender', 'LIKE', '%'.$search.'%')
                    ->orWhere('tshirt_size', 'LIKE', '%'.$search.'%')
                    ->paginate(20);

        $contacts = ContactMaster::where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orWhere('phone', 'LIKE', '%'.$search.'%')
                    ->paginate(20);

        $nonprofits = NonProfit::where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('address_line_1', 'LIKE', '%'.$search.'%')
                    ->orWhere('address_line_2', 'LIKE', '%'.$search.'%')
                    ->orWhere('city', 'LIKE', '%'.$search.'%')
                    ->orWhere('website', 'LIKE', '%'.$search.'%')
                    ->paginate(20);

        $artists = Artist::where('name', 'LIKE', '%'.$search.'%')
                    ->paginate(20);

        $result['events'] = $events;

        $result['shifts'] = $shifts;

        $result['contacts'] = $contacts;
        $result['nonprofits'] = $nonprofits;
        $result['volunteers'] = $volunteers;
        $result['artists'] = $artists;
        return response()->json(['data' => $result], 200);
    }

}
