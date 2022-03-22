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
use Illuminate\Support\Arr;
use LocalCarbon;

class TransactionsTimeSeries extends BaseChart
{
    /**
     * Determines the name suffix of the chart route.
     * This will also be used to get the chart URL
     * from the blade directive. If null, the chart
     * name will be used.
     */
    public ?string $routeName = 'time-series.transactions';

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $period = Period::tryFrom($request->input('period', 'last_30_days')) ?? Period::LAST_THIRTY_DAYS;
        $frequency = Frequency::tryFrom($request->input('frequency', 'daily')) ?? Frequency::DAILY;
        $status = $request->input('status', 'completed');

        $whereStatus = match ($status) {
            'completed' => ['COMPLETED'],
            'reimbursed' => ['REIMBURSED'],
            'pending' => ['PENDING'],
            'failed' => ['FAILED'],
            default => Arr::pluck(Status::cases(), 'name'),
        };

        $chartAid = new ChartAid($period, $frequency);

        $data = Transaction::select(['created_at'])->whereBetween('created_at', [
            $chartAid->chartStartDate()->utc(),
            LocalCarbon::now()->utc()
        ])->whereIn('status', $whereStatus)->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

        $data = $chartAid->chartDataSet($data);

        return Chartisan::build()->labels($data['labels'])->dataset('Transactions', $data['datasets']);
    }
}
