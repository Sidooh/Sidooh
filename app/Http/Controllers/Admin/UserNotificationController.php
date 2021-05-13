<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserNotificationStoreRequest;
use App\Models\Account;
use App\Models\UserNotification;
use App\Repositories\UserNotificationRepository;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    protected $userNotification;

    /**
     * UserNotificationController constructor.
     *
     * @param UserNotificationRepository $userNotification
     */
    public function __construct(UserNotificationRepository $userNotification)
    {
        $this->userNotification = $userNotification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userNotifications = $this->userNotification->latest()->get();

        return view('admin.crud.user_notifications.index', compact('userNotifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $accounts = Account::select('phone')->get();

        return view('admin.crud.user_notifications.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserNotificationStoreRequest $request)
    {
        //

//        TODO: Save notification
        $userNotification = UserNotification::create([
            'type' => $request->type,
            'content' => $request->message,
            'to' => $request->recipients,
            'status' => 'Pending'
        ]);

//        TODO: Send as laravel notification instead.
        if ($request->type = 'SMS') {
            if (in_array('ALL', $request->recipients))
                $recipients = (array)Account::all()->pluck('phone')->toArray();
            else
                $recipients = $request->recipients;

            $response = (new AfricasTalkingApi())->sms($recipients, $request->message);

            $userNotification->status = $response['status'];
            $userNotification->save();

            session()->flash('success', "Messages sent successfully.");

        }

        session()->flash('error', "Only SMS is available at this time.");

        return redirect()->route('admin.user-notifications.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\UserNotification $userNotification
     * @return \Illuminate\Http\Response
     */
    public function show(UserNotification $userNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\UserNotification $userNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(UserNotification $userNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UserNotification $userNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserNotification $userNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\UserNotification $userNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserNotification $userNotification)
    {
        //
    }
}
