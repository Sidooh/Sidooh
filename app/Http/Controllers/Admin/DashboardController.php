<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Statistics\ChartAid;
use App\Helpers\Statistics\Frequency;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Repositories\DashboardRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\ArrayShape;

class DashboardController extends Controller
{
    protected DashboardRepository $dashboard;

    /**
     * DashboardController constructor.
     *
     * @param DashboardRepository $dashboard
     */
    public function __construct(DashboardRepository $dashboard) {
        $this->dashboard = $dashboard;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Application
     */
    public function index(): View|Application {
        $data = $this->dashboard->statistics();

        return view('admin.index', compact('data'));
    }

    #[ArrayShape(['main' => "array", 'total_today' => "int|mixed", 'total_yesterday' => "int|mixed"])]
    public function charts(Request $request): array {
        $frequency = Frequency::tryFrom($request->input('frequency')) ?? Frequency::DAILY;

        $chartAid = new ChartAid($frequency, 'sum', 'amount');

        $revenue = Transaction::select(['created_at', 'amount'])->whereBetween('created_at', [
            $chartAid->chartStartDate(),
            now()
        ])->whereStatus('completed')->get()->groupBy(function($item) use ($chartAid) {
            return $chartAid->chartDateFormat($item->created_at);
        });

        return [
            'main'           => $chartAid->chartDataSet($revenue),
            'total_today'     => Transaction::whereStatus('completed')
                ->whereDate('created_at', Carbon::today())
                ->sum('amount'),
            'total_yesterday' => Transaction::whereStatus('completed')
                ->whereDate('created_at', Carbon::yesterday())
                ->sum('amount')
        ];
    }
}
