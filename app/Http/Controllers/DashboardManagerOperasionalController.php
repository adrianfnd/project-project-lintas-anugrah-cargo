<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Paket;
use App\Models\SuratJalan;

class DashboardManagerOperasionalController extends Controller
{
    public function dashboard()
    {
        $paketHariIni = Paket::whereDate('created_at', Carbon::today())->count();
        $totalPaket = Paket::count();
        $paketDikirim = Paket::where('status', 'dikirim')->count();
        $paketSampai = Paket::where('status', 'selesai')->count();

        return view('manager_operasional.dashboard', compact('paketHariIni', 'totalPaket', 'paketDikirim', 'paketSampai'));
    }

    public function getChartDataPaket(Request $request)
    {
        $period = $request->query('period');
        $now = Carbon::now();

        $labels = [];
        $data = [];

        if ($period == 'monthly') {
            $weeksInMonth = [];
            for ($i = 1; $i <= $now->daysInMonth; $i++) {
                $date = Carbon::createFromDate($now->year, $now->month, $i);
                $week = $date->weekOfMonth;
                if (!isset($weeksInMonth[$week])) {
                    $weeksInMonth[$week] = [];
                }
                $weeksInMonth[$week][] = $i;
            }

            foreach ($weeksInMonth as $week => $days) {
                $startOfWeek = Carbon::createFromDate($now->year, $now->month, $days[0]);
                $endOfWeek = Carbon::createFromDate($now->year, $now->month, end($days))->endOfDay();

                $count = Paket::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
                $labels[] = "Minggu $week";
                $data[] = $count;
            }
        } elseif ($period == 'yearly') {
            for ($month = 1; $month <= 12; $month++) {
                $count = Paket::whereYear('created_at', $now->year)
                              ->whereMonth('created_at', $month)
                              ->count();
                $labels[] = Carbon::createFromDate($now->year, $month, 1)->format('M');
                $data[] = $count;
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function getChartDataPerformance(Request $request)
    {
        $period = $request->query('period', 'monthly');
        $now = Carbon::now();

        $labels = [];
        $data = [];

        if ($period == 'monthly') {
            $weeksInMonth = [];
            for ($i = 1; $i <= $now->daysInMonth; $i++) {
                $date = Carbon::createFromDate($now->year, $now->month, $i);
                $week = $date->weekOfMonth;
                if (!isset($weeksInMonth[$week])) {
                    $weeksInMonth[$week] = [];
                }
                $weeksInMonth[$week][] = $i;
            }

            foreach ($weeksInMonth as $week => $days) {
                $startOfWeek = Carbon::createFromDate($now->year, $now->month, $days[0]);
                $endOfWeek = Carbon::createFromDate($now->year, $now->month, end($days))->endOfDay();

                $averageRate = SuratJalan::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->avg('rate');

                $labels[] = "Minggu $week";
                $data[] = round($averageRate, 2);
            }
        } elseif ($period == 'yearly') {
            for ($month = 1; $month <= 12; $month++) {
                $averageRate = SuratJalan::whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $month)
                    ->avg('rate');

                $labels[] = Carbon::create($now->year, $month, 1)->format('M');
                $data[] = round($averageRate, 2);
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}






