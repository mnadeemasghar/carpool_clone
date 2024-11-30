<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\Interest;
use App\Models\MailNotification;
use App\Models\Quote;
use App\Models\Ride;
use App\Models\Setting;
use App\Models\User;
use App\Services\RideService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    protected $rideService;

    public function __construct(RideService $rideService)
    {
        $this->rideService = $rideService;
    }
    function dashboard(Request $request){

        $user = User::find(Auth::user()->id);
        if($user->isAdmin()){
            
            $logFiles = File::files(storage_path('logs'));

            $cards = [
                [
                    'title' => 'Blogs',
                    'count' => Blog::count(),
                    'url' => route('admin.blog.index')
                ],
                [
                    'title' => 'Settings',
                    'count' => Setting::count(),
                    'url' => route('admin.setting.index')
                ],
                [
                    'title' => 'Ride Requests',
                    'count' => $this->rideService->getSearchedRides($request)->total(),
                    'url' => route('admin.ride.index')
                ],
                [
                    'title' => 'Interests Showed',
                    'count' => Interest::count(),
                    'url' => ''
                ],
                [
                    'title' => 'Addresses',
                    'count' => Address::count(),
                    'url' => route('admin.address.index')
                ],
                [
                    'title' => 'Users',
                    'count' => User::where('email_verified_at','!=',null)->count(),
                    'url' => route('admin.user.index')
                ],
                [
                    'title' => 'Admins',
                    'count' => Admin::count(),
                    'url' => ''
                ],
                // [
                //     'title' => 'Wallet',
                //     'count' => Wallet::whereNotIn('user_id',$admin_ids)->sum('amount'),
                //     'url' => route('admin.wallet.index')
                // ],
                // [
                //     'title' => 'Subscriptions',
                //     'count' => Subscription::count(),
                //     'url' => route('admin.subscription.index')
                // ],
                [
                    'title' => 'Email Notifications',
                    'count' => MailNotification::count(),
                    'url' => route('admin.mail-notification.create')
                ],
                [
                    'title' => 'Logs',
                    'count' => count($logFiles),
                    'url' => url('/log-viewer')
                ],
                [
                    'title' => 'Pending Jobs',
                    'count' => DB::table('jobs')->count(),
                    'url' => ''
                ],
                [
                    'title' => 'Failed Jobs',
                    'count' => DB::table('failed_jobs')->count(),
                    'url' => ''
                ],
                [
                    'title' => 'Send Quote',
                    'count' => Quote::count(),
                    'url' => route('admin.send.inpsire.quote')
                ]

            ];

            $cards = collect($cards);

            return view('admin.dashboard')->with('cards',$cards);
        }
        else{
            $cards = [
                [
                    'title' => 'Search Ride',
                    'count' => null,
                    'url' => route('ride.search')
                ],
                [
                    'title' => 'Create Ride Request',
                    'count' => null,
                    'url' => route('ride.create')
                ],
                [
                    'title' => 'My Rides',
                    'count' => null,
                    'url' => route('ride.index')
                ],
                // [
                //     'title' => 'My Wallet',
                //     'count' => null,
                //     'url' => route('wallet.index')
                // ],
                [
                    'title' => 'Profile',
                    'count' => null,
                    'url' => route('profile.show')
                ],

            ];

            $cards = collect($cards);

            return view('dashboard')->with('cards',$cards);
        }
    }
}
