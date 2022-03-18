<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Helpers\Statistics\ChartAid;
use App\Helpers\Statistics\Frequency;
use App\Models\Account;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use LocalCarbon;

class CumulativeAccounts extends BaseChart
{
    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'cumulative.accounts';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $frequency = Frequency::tryFrom('daily') ?? Frequency::DAILY;
        $chartAid = new ChartAid($frequency);

        $data = Account::select(['created_at'])->whereBetween('created_at', [
            LocalCarbon::today()->startOfDay()->utc(),
            LocalCarbon::today()->endOfDay()->utc()
        ])->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

        $hrs = LocalCarbon::now()->diffInHours(LocalCarbon::now()->startOfDay());
        [
            'datasets' => $dataset,
            'labels' => $labels,
        ] = $chartAid->chartDataSet($data, $hrs + 1);

        return Chartisan::build()
            ->labels($labels)
            ->dataset('Accounts', $dataset);
    }
}
