<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRideRequest;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Interest;
use App\Models\Ride;
use App\Models\Stop;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletEntry;
use App\Services\AddressService;
use App\Services\RideService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\GoogleApi;
use App\Services\StopService;

class RideContoller extends Controller
{
    protected $rideService;
    protected $googleApi;
    protected $addressService;
    protected $stopService;

    public function __construct(
        RideService $rideService, 
        GoogleApi $googleApi, 
        AddressService $addressService,
        StopService $stopService
        )
    {
        $this->rideService = $rideService;
        $this->googleApi = $googleApi;
        $this->addressService = $addressService;
        $this->stopService = $stopService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $rides = $this->rideService->getRideByUserId($user_id);
        
        return view('ride.index')->with('rides',$rides);
    }

    public function search(Request $request){
            $rides = $this->rideService->getSearchedRides($request);
            $mapedRides = $this->rideService->getSearchedMapedRides($request);
            
            $page_title = "Search Result - ";

            $pick_location_title = Address::where('id',$request->pick_location_id)->first()?->title;
            $page_title .= "For: ";
            $page_title .= $pick_location_title;


            // $drop_location_title = Address::where('id',$request->drop_location_id)->first()?->title;
            // $page_title .= " To: ";
            // $page_title .= $drop_location_title;

            $pickAddresses = $this->stopService->getStopAddresses();

            return view('ride.search')
                ->with('page',$page_title)
                ->with('rides',$rides)
                ->with('pickAddresses',$pickAddresses)
                ->with('mapedRides',$mapedRides)
                ->with('pick_location_id',$request->pick_location_id);
                // ->with('drop_location_id',$request->drop_location_id);
    }

    public function getDropLocations(Request $request)
    {
        $pickLocationId = $request->input('pick_location_id');
    
        $rideIds = Stop::where('address_id', $pickLocationId)->pluck('ride_id');
    
        if ($rideIds->isEmpty()) {
            // Return an empty array or a message if no drop locations found
            return response()->json([]);
        }

        $dropLocationIds = Stop::whereIn('ride_id',$rideIds)->where('address_id','!=',$pickLocationId)->pluck('address_id');
    
        // Fetch addresses where the id is in the dropLocationIds
        $dropLocations = Address::whereIn('id', $dropLocationIds)
                                 ->get(['id', 'title']);
    
        // Return the drop locations as JSON
        return response()->json($dropLocations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $addresses = Address::all();
        $page = "Create Ride";
        return view('ride.create',compact('addresses','page'));
    }

    public function map()
    {
        return view('ride.map');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRideRequest $request)
    {
        $data = $request->except("_token");

        if(!Auth::check()){
            // create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'password' => Hash::make($request->password)
            ]);

            // Send email verification notification
            $user->sendEmailVerificationNotification();
            Auth::login($user);
        }

        $user_id = Auth::user()->id;

        $pick_location = $request->pick_location;
        $drop_location = $request->drop_location;

        // check pick location id
        $pick_location_data = $this->addressService->getAddressByTitle($pick_location);

        // check drop location id
        $drop_location_data = $this->addressService->getAddressByTitle($drop_location);

        $data['pick_location_id'] = $pick_location_data->id;
        $data['drop_location_id'] = $drop_location_data->id;

        $ride = $this->rideService->createNewRideByUserId($data, $user_id);
        $ride = $ride->refresh();
        $fee_deducted = $this->deductServiceFee($ride);
        
        if(true){
        // if($fee_deducted){
            return redirect()->route('ride.status',$ride->id)->banner('Ride created');
        }
        else{
            $message = 'Ride created but you to activate it. Visit "My Rides" to view the status of your rides';
        
            return redirect()->route('stop.index',$ride->id)->dangerBanner($message);
        }
    }

    public function status($ride_id){
        $ride = $this->rideService->getRideByIdWithUser($ride_id);
        return view('ride.create-success',compact('ride'));
    }

    public function guestCreate(){
        return view('ride.create-guest');
    }

    public function guestStore(Request $request){

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $phone = $request->phone;

        $pick_location = $request->pick_location;
        $drop_location = $request->drop_location;

        // create user
        $user = User::where('email',$email)->first();
        if(!$user){
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'phone' => $phone
            ]);
        }

        Auth::login($user);

        // check pick location id
        $pick_location_data = Address::where('title',$pick_location)->first();
        if(!$pick_location_data){
            $pick_location_data = Address::create(['title' => $pick_location]);
        }

        // check drop location id
        $drop_location_data = Address::where('title',$drop_location)->first();
        if(!$drop_location_data){
            $drop_location_data = Address::create(['title' => $drop_location]);
        }

        // create ride
        $data = $request->except(['_token','name','email','password','phone']);
        $data['pick_location_id'] = $pick_location_data->id;
        $data['drop_location_id'] = $drop_location_data->id;

        $ride = $this->rideService->createNewRideByUserId($data, $user->id);
        if($ride){
            $ride = $ride->refresh();
            return redirect()->route('ride.success',['ride' => $ride]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ride $ride)
    {
        return view('ride.show')->with('ride',$ride);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ride $ride)
    {
        if($ride->user_id == Auth::user()->id){
            $addresses = Address::all();
            $ride->pick_location = Address::find($ride->pick_location_id)->title;
            $ride->drop_location = Address::find($ride->drop_location_id)->title;
            return view('ride.edit')->with('ride',$ride)->with('addresses',$addresses);
        }
        else{
            return redirect()->back()->with([
                'flash.banner' => 'You are not authorized to edit this.',
                'flash.bannerStyle' => 'danger'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ride $ride)
    {
        $user = Auth::user();
        if($ride->user_id == $user->id){
            $data = $request->except('_token');

            $pick_location_data = $this->addressService->getAddressByTitle($data['pick_location']);
            $drop_location_data = $this->addressService->getAddressByTitle($data['drop_location']);

            $data['pick_location_id'] = $pick_location_data->id;
            $data['drop_location_id'] = $drop_location_data->id;
            
            $data['mon'] = isset($data['mon']) ? "on":null;
            $data['tue'] = isset($data['tue']) ? "on":null;
            $data['wed'] = isset($data['wed']) ? "on":null;
            $data['thu'] = isset($data['thu']) ? "on":null;
            $data['fri'] = isset($data['fri']) ? "on":null;
            $data['sat'] = isset($data['sat']) ? "on":null;
            $data['sun'] = isset($data['sun']) ? "on":null;

            $data['id'] = $ride->id;

            // $updated_ride = $ride->update($data);
            $updated_ride = $this->rideService->updateRideByUserId($data, $user->id);
            if($updated_ride){
                return redirect()->route('ride.show',['ride'=>$ride])->with([
                    'flash.banner' => 'Ride request updated successfully',
                ]);;
            }
        }
        else{
            return redirect()->back()->with([
                'flash.banner' => 'You are not authorized to update this.',
                'flash.bannerStyle' => 'danger'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ride $ride)
    {
        if($ride->user_id == Auth::user()->id){
            if($ride->delete()){
                return redirect()->route('ride.create')->banner('Your ride deleted!');
            }
        }
        else{
            return redirect()->back()->with([
                'flash.banner' => 'You are not authorized to delete this.',
                'flash.bannerStyle' => 'danger'
            ]);
        }
    }

    /**
     * Show interest in the specified resource from storage.
     */
    public function interested(Ride $ride){
        $user = Auth::user();
        $user_id = $user->id;

        if($ride->user_id == $user_id){
            session()->flash('message', 'You can not show interest in your own ride request!');
            session()->flash('alert-type', 'danger');

            return redirect()->route('ride.show',['ride' => $ride]);
        }

        $insterest = Interest::where('user_id',$user_id)->where('ride_id',$ride->id)->first();
        if(!$insterest){
            if(Interest::create([
                'ride_id' => $ride->id,
                'user_id' => $user_id
            ])){
                $this->googleApi->sendNotification(
                    $ride->user_id,
                    "{$user->name} is Interested",
                    "Someone is interested in your ride request. Log in to view the contact number."
                );               
                
                session()->flash('message', 'You are interested now!');
                session()->flash('alert-type', 'success');
    
                return redirect()->route('ride.show',['ride' => $ride]);
            }
            else{
                return redirect()->route('ride.show',['ride' => $ride])->with([
                    'flash.banner' => 'Insterest not saved, try again',
                    'flash.bannerStyle' => 'danger'
                ]);
            }
        }
        else{
            if($insterest->delete()){
                session()->flash('message', 'Interest revoked!');
                session()->flash('alert-type', 'success');
    
                return redirect()->route('ride.show',['ride' => $ride]);
            }
            else{
                return redirect()->route('ride.show',['ride' => $ride])->with([
                    'flash.banner' => 'Insterest not saved, try again',
                    'flash.bannerStyle' => 'danger'
                ]);
            }
        }
    }

    public function activate(Ride $ride){
        // check user balance
        $user = User::where('id', $ride->user_id)->with('wallet')->first();

        // amount to be checked
        $service_fee = 1000;

        if($user){
            if($user->wallet && $user->wallet->amount >= $service_fee)
                // deduct the service fee
                if($this->deductServiceFee($ride)){
                    // update ride to active
                    $ride->status = 'active';
                    if($ride->save()){
                        return redirect()->back()->banner('Ride status Activated');
                    }
                }
                else{
                    return redirect()->back()->dangerBanner('Somthing went wrong while charging service fee, please call at +92-301-0046979 for further instructions');
                }
            else{
                return redirect()->back()->dangerBanner('You must have ' . $service_fee . ' balance please topup you wallet, To topup, Please us at +92-301-0046979');
            }
        }
        else{
            return redirect()->back()->dangerBanner('Somthing went wrong, please try again');
        }
    }

    protected function deductServiceFee($ride){
        $amount = (int) 1000;
        $currency_symbol = "PKR";
        
        // Update Wallet Balance
        
        // check if the wallet is available
        $wallet = Wallet::where('user_id',$ride->user_id)->where('currency_symbol',$currency_symbol)->first();
        
        if($wallet && $wallet->amount >= $amount){
            $wallet->update([
                'amount' => $wallet->amount - $amount
            ]);
        }
        else{
            return false;
        }
        
        // check if admin wallet available
        $admin_id = Admin::first()->user_id;
        $admin_user = User::where('id',$admin_id)->first();
        $admin_user_id = $admin_user->id;
        $admin_wallet = Wallet::where('user_id',$admin_user_id)->where('currency_symbol',$currency_symbol)->first();
        
        if($admin_wallet){
            $admin_wallet->update([
                'amount' => $admin_wallet->amount + $amount
            ]);
        }
        else{
            $admin_wallet = Wallet::create([
                'user_id' => $admin_user_id,
                'amount' => $amount,
                'currency_symbol' => $currency_symbol
            ]);
        }

        // Create wallet entry
        $wallet_entry = WalletEntry::create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => 'dr',
            'description' => 'Service fee deduction (RideID: '. $ride->id .')'
        ]);

        // creeate admin wallet entry
        $admin_wallet_entry = WalletEntry::create([
            'wallet_id' => $admin_wallet->id,
            'amount' => $amount,
            'type' => 'cr',
            'description' => 'Service fee deduction (UserID: '. $ride->user_id .', RideId: '. $ride->id .')',
            'transaction_parent_id' => $wallet_entry->id
        ]);
        if($wallet_entry && $admin_wallet_entry){
            return true;
        }
        else{
            return false;
        }
    }
}
