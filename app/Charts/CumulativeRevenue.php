<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Enums\Frequency;
use App\Enums\Period;
use App\Enums\Status;
use App\Helpers\Statistics\ChartAid;
use App\Models\Transaction;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use LocalCarbon;

class CumulativeRevenue extends BaseChart
{
    public ?string $routeName = 'cumulative.revenue';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $period = Period::tryFrom($request->input('period', 'last_30_days')) ?? Period::LAST_THIRTY_DAYS;
        $frequency = Frequency::tryFrom($request->input('frequency', 'daily')) ?? Frequency::DAILY;

        $chartAid = new ChartAid($period, $frequency, 'sum', 'amount');

        $data = Transaction::select(['created_at', 'amount'])->whereBetween('created_at', [
            $chartAid->chartStartDate()->utc(),
            LocalCarbon::now()->utc()
        ])->whereStatus(Status::COMPLETED->name)->get()->groupBy(fn($item) => $chartAid->chartDateFormat($item->created_at));

        $data = $chartAid->chartDataSet($data);

        return Chartisan::build()
            ->labels($data['labels'])
            ->dataset('Revenue', $data['datasets']);
    }
}
