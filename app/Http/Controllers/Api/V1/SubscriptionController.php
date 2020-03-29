<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    protected $subscription;

    /**
     * SubscriptionController constructor.
     *
     * @param SubscriptionRepository $subscription
     */
    public function __construct(SubscriptionRepository $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Display a listing of the resource.
     *
     * @return SubscriptionResource
     */
    public function index()
    {
        //
        return new SubscriptionResource($this->subscription->with(['account', 'subscription_type'])->get());
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
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Subscription $subscription
     * @return SubscriptionResource
     */
    public function show(Subscription $subscription)
    {
        //
        return new SubscriptionResource($subscription);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subscription $subscription
     * @return Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Subscription $subscription
     * @return Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscription $subscription
     * @return Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return SubscriptionResource
     */
    public function active()
    {
        //
        return new SubscriptionResource($this->subscription->active()->get());
    }

}
