<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Enums\Frequency;
use App\Enums\Period;
use App\Helpers\Statistics\ChartAid;
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
        $period = Period::tryFrom($request->input('period', 'last_30_days')) ?? Period::LAST_THIRTY_DAYS;
        $frequency = Frequency::tryFrom($request->input('frequency', 'daily')) ?? Frequency::DAILY;

        $chartAid = new ChartAid($period, $frequency);

        $data = Account::select(['created_at'])->whereBetween('created_at', [
            $chartAid->chartStartDate()->utc(),
            LocalCarbon::now()->utc()
        ])->get()->groupBy(fn($item) => $chartAid->chartDateFormat($item->created_at));

        $data = $chartAid->chartDataSet($data);

        return Chartisan::build()
            ->labels($data['labels'])
            ->dataset('Accounts', $data['datasets']);
    }
}
