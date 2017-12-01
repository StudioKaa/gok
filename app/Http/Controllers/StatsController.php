<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enrollment;
use App\Participant;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;

class StatsController extends Controller
{
    public function show()
    {
        $enrollments = Enrollment::where('state', Enrollment::STATE_ENROLLED)->orderBy('created_at')->get();

        $participants = Participant::whereHas('enrollment', function($query){
            $query->where('state', Enrollment::STATE_ENROLLED);
        })->get();

        Lava::AreaChart('inschrijvingen', $this->getEnrollmentsTable(), [
            'title' => 'Aantal inschrijvingen',
            'legend' => [
                'position' => 'none'
            ]
        ]);

        return view('stats')
            ->with('enrollments', $enrollments)
            ->with('participants', $participants);
    }

    public function getEnrollmentsTable()
    {
        $enrollments_graph = Lava::DataTable();
        $enrollments_graph->addDateColumn('datum')
                   ->addNumberColumn('# inschrijvingen');

        $counts = DB::select("SELECT
                       DATE(e.created_at) AS e_date,
                       count(e.id) AS daily,
                       (
                          SELECT 
                             COUNT(id)
                          FROM enrollments 
                          WHERE DATE(created_at) <= e_date
                       ) as total
                    FROM enrollments AS e
                    GROUP BY e_date;");

        $begin = new DateTime('2017-11-30');
        $end = new DateTime('+1 day');
        $range = new DatePeriod($begin, new DateInterval('P1D') ,$end);

        $total = 0;
        foreach($range as $date)
        {
            foreach($counts as $count)
            {
                if($count->e_date == $date->format('Y-m-d'))
                {
                    $total = $count->total;
                }

                $enrollments_graph->addRow([$date->format('d-m-Y'), $total]);
            }
        }

        return $enrollments_graph;

    }
}
