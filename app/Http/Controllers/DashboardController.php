<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deceased;
use DB;

class DashboardController extends Controller
{
    public function manager_index()
    {

        // Retrieve the most recent deceased person
$recent_deceased = Deceased::where('approvalStatus', 1)
->where('burriedStatus', 1)
->orderBy('created_at', 'desc')
->first();
        // Count of deceased for today
        $no_ofdeceaseds_today = Deceased::whereDate('created_at', today())
            ->where('approvalStatus', 1)
            ->where('burriedStatus', 1)
            ->count();

        // Count of deceased for the week
        $no_ofdeceaseds_week = Deceased::whereYear('created_at', today()->year)
            ->where('approvalStatus', 1)
            ->where('burriedStatus', 1)
            ->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])
            ->count();

        // Count of deceased for the month
        $no_ofdeceaseds_month = Deceased::whereYear('created_at', today()->year)
            ->whereMonth('created_at', today()->month)
            ->where('approvalStatus', 1)
            ->where('burriedStatus', 1)
            ->count();

        // Count of deceased for the year
        $no_ofdeceaseds_year = Deceased::whereYear('created_at', today()->year)
            ->where('approvalStatus', 1)
            ->where('burriedStatus', 1)
            ->count();

            // Reset count if the time period has ended
$currentHour = now()->hour;
if ($currentHour == 0) {
    $no_ofdeceaseds_today = 0; // Reset count for today at midnight
}

$currentDayOfWeek = now()->dayOfWeek;
if ($currentDayOfWeek == 0) {
    $no_ofdeceaseds_week = 0; // Reset count for the week on Sunday
}

$currentDayOfMonth = now()->day;
if ($currentDayOfMonth == 1) {
    $no_ofdeceaseds_month = 0; // Reset count for the month on the 1st day
}

$currentMonth = now()->month;
if ($currentMonth == 1) {
    $no_ofdeceaseds_year = 0; // Reset count for the year in January
}


        $years = DB::select('select distinct YEAR(dateof_death) as year from deceaseds where approvalStatus = 1 order by YEAR(dateof_death) asc');

        $deceased_byDateOfBirth = DB::select('select distinct year(curdate())-year(deceaseds.dateofbirth) as age, count(year(curdate())-year(deceaseds.dateofbirth)) as value
                                              from deceaseds 
                                              where year(deceaseds.dateofbirth) >= 1920 and year(deceaseds.dateofbirth) <= year(curdate())   
                                              and deceaseds.approvalStatus = 1
                                              and deceaseds.burriedStatus = 1
                                              group by age
                                              order by age asc');

        $deaths_label = [];
        $deaths_values = [];
        $no_ofdeceaseds = Deceased::where([
            'approvalStatus' => 1,
            'burriedStatus' => 1
        ])->count();

        // Fetching the number of deceaseds by year
        foreach ($years as $year) {
            $deaths_label[] = $year->year;
            $deceased = DB::select('select count(id) as y from deceaseds where approvalStatus = 1 and burriedStatus = 1 and YEAR(dateof_death) = ' . $year->year . ' ');
            $deaths_values[] = $deceased[0]->y;
        }

        $dateofbirth_label = [];
        $dateofbirth_values = [];

        foreach ($deceased_byDateOfBirth as $dob) {
            $dateofbirth_label[] = $dob->age;
            $dateofbirth_values[] = $dob->value;
        }

        $schedules_data = array();
        $schedules = DB::select("SELECT firstname, middlename, lastname, dateof_burial, burial_time FROM deceaseds where deceaseds.approvalStatus = 0");
        foreach ($schedules as $sched) {
            $schedules_data[] = [
                'title' => $sched->firstname . " " . $sched->middlename . " " . $sched->lastname,
                'start' => $sched->dateof_burial . " " . $sched->burial_time,
                'end' => $sched->dateof_burial . " " . $sched->burial_time,
                'backgroundColor' => '#f39c12',
                'borderColor' => '#f39c12',
            ];
        }

        $counts = [
            'deceasedtotal' => Deceased::where('burriedStatus', 1)->count(),
            'forApproval' => Deceased::where('approvalStatus', 0)->count(),
            'forBurial' => Deceased::where(['approvalStatus' => 1, 'burriedStatus' => 0])->count(),
        ];

        return view('manager_dashboard', compact('deaths_values', 'recent_deceased', 'no_ofdeceaseds_week', 'no_ofdeceaseds_year', 'deaths_label', 'no_ofdeceaseds', 'no_ofdeceaseds_month', 'no_ofdeceaseds_today', 'dateofbirth_label', 'dateofbirth_values', 'schedules_data', 'counts'));
    }

    public function staff_index()
    {
        // return view('staff_dashboard');
    }
}
