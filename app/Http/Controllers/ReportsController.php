<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Volunteer;
use Log;

class ReportsController extends Controller
{
    private function getEventEligibleIds() {
        $idQuery = "SELECT events.id as eventid, shifts.id as shiftid from events left join shifts on events.id=shifts.event_id WHERE events.deleted_at IS NULL AND shifts.id IS NOT NULL ";

        if ( request()->has('event_id') && count(request()->input('event_id')) ) {
            $idQuery .= " AND events.id in (" . implode( ", ", request()->input('event_id') ) . ")";
        }

        if ( request()->has('shift_id') && count(request()->input('shift_id')) ) {
            $idQuery .= " AND shifts.id in (" . implode( ", ", request()->input('shift_id') ) . ")";
        }

        if ( request()->has('artist_id') && count(request()->input('artist_id')) ) {
            $idQuery .= " AND (events.artist_id in (" . implode( ", ", request()->input('artist_id') ) . ") OR shifts.artist_id in (" . implode( ", ", request()->input('artist_id') ) . "))";
        }

        if ( request()->has('venue_id') && count(request()->input('venue_id')) ) {
            $idQuery .= " AND (events.venue_id in (" . implode( ", ", request()->input('venue_id') ) . ") OR shifts.venue_id in (" . implode( ", ", request()->input('venue_id') ) . "))";
        }

        if ( request()->filled('start_date') ) {
            $idQuery .= " AND events.start_date >= '" . request()->input('start_date') . "'";
        }
        if ( request()->filled('end_date') ) {
            $idQuery .= " AND events.start_date <= '" . request()->input('end_date') . "'";
        }

        $idsData = DB::select(DB::raw($idQuery));
        $eventMatchIds = array(0);
        $shiftMatchIds = array(0);
        foreach ($idsData as $item) {
            array_push($eventMatchIds, $item->eventid);
            array_push($shiftMatchIds, $item->shiftid);
        }

        return array("events"=>array_unique($eventMatchIds), "shifts"=>array_unique($shiftMatchIds));
    }

    public function getSelectableStats() {
        $ids = array();
        foreach (request()->input('sel_stats')  as $stat) {
            array_push($ids, $stat['id']);
        }

        return $ids;
    }

    public function generate() {
        $eventIds = null;
        $shiftIds = null;
        $fieldIds = null;
        $filteredSearch = true;

        //get list of stats to return
        if ( request()->has('sel_stats') && count(request()->input('sel_stats')) )
            $fieldIds = $this->getSelectableStats();

        //get shift elible ids's based on filters
        if ( request()->has('shift_id') && count(request()->input('shift_id')) ) {
            $eligibleIds = $this->getEventEligibleIds();
        }

        //get event elible ids's based on filters
        else
        if ( (request()->has('event_id') && count(request()->input('event_id'))) ||
             (request()->has('artist_id') && count(request()->input('artist_id'))) ||
             (request()->has('venue_id') && count(request()->input('venue_id'))) ) {
            $eligibleIds = $this->getEventEligibleIds();
        }
        else {
            $filteredSearch = false;
        }

        //get metric totals
        $query = "SELECT metrics.name as stat, SUM(COALESCE(metric_values.value, 0)) as amount from metrics left join metric_values on metrics.id=metric_values.metric_id";

        if ( isset($eligibleIds['events']) && isset($eligibleIds['shifts']) ) {
            $query .= " WHERE ( (metricable_type = 'Event' AND metricable_id in (" . implode( ", ", $eligibleIds['events'] ) . "))";
            $query .= " OR (metricable_type = 'Shift' AND metricable_id in (" . implode( ", ", $eligibleIds['shifts'] ) . ")) )";
            $query .= " and (metric_id in (" . implode( ", ", $fieldIds ) . "))";
        }
        else {
            if ($filteredSearch == false)
                $query .= " WHERE (metric_id in (" . implode( ", ", $fieldIds ) . "))";
        }

        $query .= " GROUP BY stat";

        $data = DB::select(DB::raw($query));

        return response()->json(['data' => $data], 201);
    }

    public function getDashboardTotals() {
        //get events active total
        $num_active_events = DB::select(DB::raw("SELECT COUNT(id) as cnt from events WHERE (end_date >= now())"));

        //get events to date total
        $num_events = DB::select(DB::raw("SELECT COUNT(id) as cnt from events"));

        //get pending volunteers total
        $num_pending_volunteers = Volunteer::join('volunteer_shifts', 'volunteer_shifts.volunteer_id', 'volunteers.id')
            ->join('shifts', 'shifts.id', 'volunteer_shifts.shift_id')
            ->join('events', 'events.id', 'shifts.event_id')
            ->where("volunteer_shifts.pending",1)
            ->count();

        //get volunteers to date total
        $num_volunteers = DB::select(DB::raw("SELECT COUNT(id) as cnt from volunteers"));

        //get upcoming shifts total
        $num_upcoming_shifts = DB::select(DB::raw("SELECT COUNT(id) as cnt from shifts WHERE start_date > now()"));

        $data = [];
        $data['num_active_events'] = $num_active_events[0]->cnt;
        $data['num_events'] = $num_events[0]->cnt;
        $data['num_pending_volunteers'] = $num_pending_volunteers;
        $data['num_volunteers'] = $num_volunteers[0]->cnt;
        $data['num_upcoming_shifts'] = $num_upcoming_shifts[0]->cnt;

        return response()->json(['data' => $data], 201);
    }
}
