<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Facades\LocalCarbon;
use App\Helpers\Statistics\ChartAid;
use App\Helpers\Statistics\Frequency;
use App\Models\Transaction;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class RevenueChart extends BaseChart
{
    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'revenue';
    public string $timezone = 'Africa/Nairobi';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan {
        $frequency = Frequency::tryFrom((string)$request->input('frequency')) ?? Frequency::DAILY;
        $status = $request->input('paymentStatus', 'successful');

        $whereStatus = match ($status) {
            'successful' => ['completed'],
            default => ['success', 'failed', 'pending', 'reimbursed'],
        };

        $chartAid = new ChartAid($frequency, 'sum', 'amount');

        $yesterday = Transaction::select(['created_at', 'amount'])->whereBetween('created_at', [
            LocalCarbon::yesterday()->startOfDay()->utc(),
            LocalCarbon::yesterday()->endOfDay()->utc()
        ])->whereIn('status', $whereStatus)->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

        $today = Transaction::select(['created_at', 'amount'])->whereBetween('created_at', [
            LocalCarbon::today()->startOfDay()->utc(),
            LocalCarbon::today()->endOfDay()->utc()
        ])->whereIn('status', $whereStatus)->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

        $todayHrs = LocalCarbon::now()->diffInHours(LocalCarbon::now()->startOfDay());
        ['datasets' => $datasetsToday] = $chartAid->chartDataSet($today, $todayHrs + 1);
        $revenueYesterday = $chartAid->chartDataSet(
            $yesterday, $frequency->value === 'daily'
            ? 24
            : null
        );

        return Chartisan::build()
            ->labels($revenueYesterday['labels'])
            ->dataset('Today', $datasetsToday)
            ->dataset('Yesterday', $revenueYesterday['datasets']);
    }
}
