<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherStoreRequest;
use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use App\Repositories\VoucherRepository;
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

        $voucher->load(['user', 'referrer', 'sub_vouchers', 'voucher']);
        $this->voucher->nth_level_referrals($voucher, 5);

        $data = $this->voucher->statistics($voucher);

        return view('admin.crud.vouchers.show', compact('voucher', 'data'));
    }

}
