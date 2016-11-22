<?php

namespace App\Http\Controllers;

use App\Reports\Models\Report;
use Illuminate\Http\Request;

class GameReportsController extends Controller
{
    public function index(Report $report)
    {
    	return view('reports.index')->withReports($report->all());
    }

    public function show($gamename, Report $report)
    {
    	return view('reports.show')->withReports($report->game($gamename));
    }

    public function details($redisKey, Report $report)
    {
        $report = $report->gameDetails($redisKey);
        $dealer = $report['dealer'];
        $players = $report['player'];

    	return view('reports.details', compact('dealer', 'players'));
    }
}
