<?php

namespace App\Http\Controllers\Admin;

use App\Events\MailNotificationCreated;
use App\Http\Controllers\Controller;
use App\Jobs\SendInspireQuoteToAllUsers;
use App\Models\MailNotification;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailNotificationController extends Controller
{
    private $quoteService;
    
    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function inspireQuote(){
        $quote = $this->quoteService->getQuotes();
        SendInspireQuoteToAllUsers::dispatch($quote);
        return redirect()->back()->banner('Quote Sent');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mail_notification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mail = MailNotification::create([
            'subject' => $request->subject,
            'body' => $request->body,
            'user_id' => Auth::user()->id
        ]);

        if($mail){
            event(new MailNotificationCreated($mail));
            return redirect()->route('dashboard')->banner('Email created');
        }
        else{
            return redirect()->route('dashboard')->dangerBanner("Something went wrong");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
