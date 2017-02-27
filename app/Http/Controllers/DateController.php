<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;

class DateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $day = ["Søndag", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag"];
        $month = ["Januar", "Februar", "Mars", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Desember"];
        $date = Carbon::now();
        $date->setTimezone("Europe/Oslo");
        return json_encode($day[$date->dayOfWeek] . " " . $date->day . " " . $month[$date->month - 1] . " " . $date->year . ", " . ($date->hour < 10 ? "0" : "") . $date->hour . ":" . ($date->minute < 10 ? "0" : "") . $date->minute);
    }
}
