<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionStoreRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Samerior\MobileMoney\Mpesa\Database\Entities\MpesaBulkPaymentResponse;

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
     * @return Response
     */
    public function index()
    {
        //
        $subscriptions = $this->subscription->latest()->get();

        $todaySubscriptions = $subscriptions->filter(function ($item) {
            return $item->updated_at->isToday();
        })->count();

        [$activeSubscriptions, $inactiveSubscriptions] = $subscriptions->partition(function ($item) {
            return $item->active;
        });

        return view('admin.crud.subscriptions.index', compact('todaySubscriptions', 'activeSubscriptions', 'inactiveSubscriptions'));
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
     * @param SubscriptionStoreRequest $request
     * @return SubscriptionResource
     */
    public function store(SubscriptionStoreRequest $request)
    {
        //
        return new SubscriptionResource($this->subscription->store($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Subscription $subscription
     * @return SubscriptionResource
     */
    public function show(Subscription $subscription)
    {
        $subscription->load(['account']);
//
        if ($subscription->payment->subtype == 'STK')
            $subscription->load(['payment.stkRequest.response']);
        elseif ($subscription->payment->subtype == 'B2C') {
            $subscription->load(['payment.b2cRequest']);

            $subscription->payment->b2cRequest->response = MpesaBulkPaymentResponse::with('data')
                ->where('ConversationID', $subscription->payment->b2cRequest->conversation_id)->first();
        }

//        return new SubscriptionResource($subscription);

        return view('admin.crud.subscriptions.show', compact('subscription'));
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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function queryStatus()
    {
        //

        $exitCode = Artisan::call('mpesa:query_status');

        return back();
    }

}
