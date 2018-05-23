<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enrollment;
use App\Participant;
use App\Term;
use App\Activity;
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

        $count['total'] = $participants->count();
        $count['e15'] = $participants->filter(function ($participant, $key){
            return $participant->birthday > new DateTime('2014-06-01');
        })->count();
        $count['e35'] = $count['total'] - $count['e15'];

        $count['ideal'] = Term::whereNotNull('mollie_id')->where('state', Term::STATE_PAYED)->count();

        Lava::AreaChart('participants', $this->getEnrollmentsTable(), [
            'title' => 'Aantal deelnemers',
            'legend' => [
                'position' => 'none'
            ]
        ]);

        Lava::PieChart('equipment', $this->getEquipmentTable(), [
            'is3D' => false,
            'title' => 'Kampeermiddelen',
            'pieSliceText' => 'value'
        ]);

        Lava::PieChart('arrival', $this->getArrivalTable(), [
            'is3D' => false,
            'title' => 'Aankomst',
            'pieSliceText' => 'value'
        ]);

        return view('stats')
            ->with('count', $count)
            ->with('enrollments', $enrollments)
            ->with('participants', $participants)
            ->with('diets', $this->getDiets())
            ->with('preferences', $this->getActivityCounts())
            ->with('tickets', $this->getTicketCounts())
            ->with('arrival');
    }

    public function getDiets()
    {
        $counts = DB::select("SELECT diet, COUNT(*) AS n FROM `participants` WHERE diet IS NOT NULL AND enrollment_id IN (SELECT id FROM enrollments WHERE state = " . Enrollment::STATE_ENROLLED . ") GROUP BY diet");
        return $counts;
    }

    public function getActivityCounts()
    {
        $counts = array();
        foreach (Activity::all() as $activity)
        {
            $counts["$activity->order. $activity->title"] = $activity->countPreferences();
        }
        return $counts;
    }

    public function getTicketCounts()
    {
        //SELECT activity_id, activity, round, COUNT(DISTINCT enrollment) AS count_enrollments FROM tickets_integrated GROUP BY activity_id, round ORDER BY activity_id, round

        return DB::select("SELECT * FROM `tickets_groups`");
    }

    public function getEquipmentTable()
    {
        $graph = Lava::DataTable();
        $graph->addStringColumn('label')
              ->addNumberColumn('count');

        $counts = DB::select("SELECT COUNT(id) AS count, equipment FROM `enrollments` WHERE state = ".Enrollment::STATE_ENROLLED." GROUP BY(equipment)");

        foreach ($counts as $count)
        {
            $graph->addRow([$count->equipment, $count->count]);
        }

        return $graph;
    }

    public function getArrivalTable()
    {
        $graph = Lava::DataTable();
        $graph->addStringColumn('label')
              ->addNumberColumn('count');

        $counts = DB::select("SELECT COUNT(id) AS count, arrival FROM `enrollments` WHERE state = ".Enrollment::STATE_ENROLLED." GROUP BY(arrival)");

        foreach ($counts as $count)
        {
            $graph->addRow([$count->arrival ?? 'onbekend', $count->count]);
        }

        return $graph;
    }

    public function getEnrollmentsTable()
    {
        $enrollments_graph = Lava::DataTable();
        $enrollments_graph->addDateColumn('datum')
                   ->addNumberColumn('# deelnemers');

        $counts = DB::select("SELECT
                       DATE(e.created_at) AS e_date,
                       count(e.id) AS daily,
                       (
                          SELECT 
                            COUNT(id)
                          FROM participants 
                          WHERE DATE(created_at) <= e_date
                          AND enrollment_id IN(SELECT id FROM enrollments WHERE state = " . Enrollment::STATE_ENROLLED . ")
                       ) as total
                    FROM participants AS e
                    WHERE enrollment_id IN(SELECT id FROM enrollments WHERE state = " . Enrollment::STATE_ENROLLED . ")
                    GROUP BY e_date;");

        $begin = new DateTime('2017-11-25');
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
