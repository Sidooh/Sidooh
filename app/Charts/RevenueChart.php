<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Helpers\Statistics\ChartAid;
use App\Helpers\Statistics\Frequency;
use App\Models\Transaction;
use Carbon\CarbonImmutable;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class RevenueChart extends BaseChart
{
    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directrive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'revenue';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan {
        $carbon = (new CarbonImmutable)->setTimezone('Africa/Nairobi');

        $frequency = Frequency::tryFrom((string)$request->input('frequency')) ?? Frequency::DAILY;

        $chartAid = new ChartAid($frequency, 'sum', 'amount');

        $yesterday = Transaction::select(['created_at', 'amount'])->whereBetween('created_at', [
            $carbon::yesterday()->startOfDay(),
            $carbon::yesterday()->endOfDay()
        ])->whereIn('status', ['completed', 'success'])->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

        $today = Transaction::select(['created_at', 'amount'])->whereBetween('created_at', [
            $carbon::today()->startOfDay(),
            $carbon::today()->endOfDay()
        ])->whereIn('status', ['completed', 'success'])->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

        $todayHrs = now()->diffInHours($carbon->startOfDay());
        ['labels' => $labels, 'datasets' => $datasetsYesterday] = $chartAid->chartDataSet($yesterday, 24);
        ['datasets' => $datasetsToday] = $chartAid->chartDataSet($today, $todayHrs + 1);

        return Chartisan::build()
            ->labels($labels)
            ->dataset('Today', $datasetsToday)
            ->dataset('Yesterday', $datasetsYesterday);
    }
}
