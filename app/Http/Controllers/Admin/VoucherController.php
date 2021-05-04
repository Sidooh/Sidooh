<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherStoreRequest;
use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use App\Repositories\VoucherRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VoucherController extends Controller
{
    protected $voucher;

    /**
     * VoucherController constructor.
     *
     * @param VoucherRepository $voucher
     */
    public function __construct(VoucherRepository $voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $vouchers = $this->voucher->latest()->get();

        return view('admin.crud.vouchers.index', compact('vouchers'));
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
     * @param VoucherStoreRequest $request
     * @return VoucherResource
     */
    public function store(VoucherStoreRequest $request)
    {
        //
        return new VoucherResource($this->voucher->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $voucher
     * @return VoucherResource
     */
    public function show(Voucher $voucher)
    {
//        //
//        Log::info($voucher->parent);
////        Log::info($voucher->parentAndSelf);
//        $voucher['level_' . '1' . '_ancestors'] = $voucher->ancestors()->whereDepth('>=', -1)->get();
//        Log::info($voucher->ancestors);
////        Log::info($voucher->ancestorsAndSelf);
//        Log::info($voucher->siblings);
////        Log::info($voucher->siblingsAndSelf);
//        Log::info($voucher->children);
////        Log::info($voucher->childrenAndSelf);
//        Log::info($voucher->descendants);
////        Log::info($voucher->descendantsAndSelf);
///

        $voucher->load(['user', 'referrer', 'sub_vouchers', 'voucher']);
        $this->voucher->nth_level_referrals($voucher, 5);

        $data = $this->voucher->statistics($voucher);

        return view('admin.crud.vouchers.show', compact('voucher', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function edit(Voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Voucher $voucher
     * @return Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Voucher $voucher
     * @return Response
     */
    public function destroy(Voucher $voucher)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $voucher
     * @return VoucherResource
     */
    public function referrals(Voucher $voucher)
    {
        //
        return new VoucherResource($this->voucher->with(['pending_referrals', 'active_referrals'])->find($voucher->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Voucher $voucher
     * @return VoucherResource
     */
    public function referrer(Request $request, Voucher $voucher)
    {
        //

        return new VoucherResource($this->voucher->getReferrer($voucher, $request->query('level'), $request->query('subscribed')));
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $voucher
     * @return VoucherResource
     */
    public function subscriptions(Voucher $voucher)
    {
        //
        return new VoucherResource($this->voucher->with(['active_subscription'])->find($voucher->id));
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $voucher
     * @return VoucherResource
     */
    public function vouchers(Voucher $voucher)
    {
        //
        return new VoucherResource($voucher->vouchers());
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $voucher
     * @return VoucherResource
     */
    public function earnings(Voucher $voucher)
    {
        //
        return new VoucherResource($this->voucher->earningsSummary($voucher->phone));
    }

    /**
     * Display the specified resource.
     *
     * @param Voucher $voucher
     * @return VoucherResource
     */
    public function earningsReport(Voucher $voucher)
    {
        //

        return $this->voucher->earningsReport($voucher->phone);
        return new VoucherResource($this->voucher->earningsReport($voucher->phone));
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param Voucher $voucher
//     * @return VoucherResource
//     */
    public function subVouchers(Voucher $voucher)
    {
        //
        return new VoucherResource($this->voucher->invest());
    }

}
