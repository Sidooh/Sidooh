<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    protected $dashboard;

    /**
     * DashboardController constructor.
     *
     * @param DashboardRepository $dashboard
     */
    public function __construct(DashboardRepository $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //
        $data = $this->dashboard->statistics();

//        return $data;

        return view('admin.index', compact('data'));

//        return new DashboardResource($this->dashboard->statistics());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DashboardStoreRequest $request
     * @return DashboardResource
     */
    public function store(DashboardStoreRequest $request)
    {
        //
        return new DashboardResource($this->dashboard->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Dashboard $dashboard
     * @return DashboardResource
     */
    public function show(Dashboard $dashboard)
    {
//        //
//        Log::info($dashboard->parent);
////        Log::info($dashboard->parentAndSelf);
//        $dashboard['level_' . '1' . '_ancestors'] = $dashboard->ancestors()->whereDepth('>=', -1)->get();
//        Log::info($dashboard->ancestors);
////        Log::info($dashboard->ancestorsAndSelf);
//        Log::info($dashboard->siblings);
////        Log::info($dashboard->siblingsAndSelf);
//        Log::info($dashboard->children);
////        Log::info($dashboard->childrenAndSelf);
//        Log::info($dashboard->descendants);
////        Log::info($dashboard->descendantsAndSelf);

        return new DashboardResource($dashboard);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Dashboard $dashboard
     * @return Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Dashboard $dashboard
     * @return Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dashboard $dashboard
     * @return Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Dashboard $dashboard
     * @return DashboardResource
     */
    public function referrals(Dashboard $dashboard)
    {
        //
        return new DashboardResource($this->dashboard->with(['pending_referrals', 'active_referrals'])->find($dashboard->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Dashboard $dashboard
     * @return DashboardResource
     */
    public function referrer(Request $request, Dashboard $dashboard)
    {
        //

        return new DashboardResource($this->dashboard->getReferrer($dashboard, $request->query('level'), $request->query('subscribed')));
    }

    /**
     * Display the specified resource.
     *
     * @param Dashboard $dashboard
     * @return DashboardResource
     */
    public function subscriptions(Dashboard $dashboard)
    {
        //
        return new DashboardResource($this->dashboard->with(['active_subscription'])->find($dashboard->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Dashboard $dashboard
     * @return DashboardResource
     */
    public function vouchers(Dashboard $dashboard)
    {
        //
        return new DashboardResource($dashboard->vouchers());
    }

    /**
     * Display the specified resource.
     *
     * @param Dashboard $dashboard
     * @return DashboardResource
     */
    public function earnings(Dashboard $dashboard)
    {
        //
        return new DashboardResource($this->dashboard->earningsSummary($dashboard->phone));
    }

    /**
     * Display the specified resource.
     *
     * @param Dashboard $dashboard
     * @return DashboardResource
     */
    public function earningsReport(Dashboard $dashboard)
    {
        //

        return $this->dashboard->earningsReport($dashboard->phone);
        return new DashboardResource($this->dashboard->earningsReport($dashboard->phone));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param Dashboard $dashboard
//     * @return DashboardResource
//     */
    public function subDashboards(Dashboard $dashboard)
    {
        //
        return new DashboardResource($this->dashboard->invest());
    }

}
