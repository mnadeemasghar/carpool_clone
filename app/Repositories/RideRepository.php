<?php
namespace App\Repositories;

use App\Events\RideRequestCreated;
use App\Models\Address;
use App\Models\Ride;
use App\Models\Stop;
use App\Models\User;
use App\RepositoryInterfaces\RideRepositoryInterface;
use App\RepositoryInterfaces\StopRepositoryInterface;
use Carbon\Carbon;

class RideRepository  implements RideRepositoryInterface
{

    private $stopRepository;

    public function __construct (StopRepositoryInterface $stopRepository){
        $this->stopRepository = $stopRepository;
    }

    public function getSearchedMapedRides($request){
        $ride_ids = Stop::where('address_id',$request->pick_location_id)->pluck('ride_id');
        $rides = Ride::query();
        $rides = $rides->where('status','!=','inactive');

        // gender
        if(!empty($request->gender)){
            switch(strtolower($request->gender)){
                case 'male':
                    $gender = User::GENDER_MALE;
                    break;
                case 'female':
                    $gender = User::GENDER_FEMALE;
                    break;
            }
            if(isset($gender)){
                $user_ids = User::where('gender',$gender)->pluck('id');
                $rides = $rides->whereIn('user_id',$user_ids);
            }
        }

        // vehicle type
        if(!empty($request->vehicle_type)){
            switch(strtolower($request->vehicle_type)){
                case 'car':
                    $vehicle_type = Ride::VEHICLE_CAR;
                    break;
                case 'bike':
                    $vehicle_type = Ride::VEHICLE_BIKE;
                    break;
                case 'van':
                    $vehicle_type = Ride::VEHICLE_VAN;
                    break;
            }
            if(isset($vehicle_type)){
                $rides = $rides->where('vehicle_type',$vehicle_type);
            }
        }

        // role
        if(!empty($request->role)){
            switch(strtolower($request->role)){
                case 'driver':
                    $role = Ride::ROLE_DRIVER;
                    break;
                case 'passenger':
                    $role = Ride::ROLE_PASSENGER;
                    break;
            }
            if(isset($role)){
                $rides = $rides->where('role',$role);
            }
        }

        if(isset($request->pick_location_id)){
            $rides = $rides->whereIn('id',$ride_ids);
        }
        if(isset($request->drop_location_id)){
            $rides = $rides->where('drop_location_id',$request->drop_location_id);
        }
        $rides = $rides->where('end_date', '>=', Carbon::today()->toDateString())
                    ->with('user')
                    // ->whereHas('user', function ($query) {$query->whereNotNull('email_verified_at');})
                    ->with('latestComment') // Eager load only the latest comment
                    ->withCount('comments')
                    ->with('stops')
                    ->with('stops.address')
                    ->with('user')
                    ->with('interested_users')
                    ->with('pick_location')
                    ->with('drop_location')
                    ->orderby('created_at','desc');
        return $rides->get()->toArray();
    }

    public function getSearchedRides($request){
        $ride_ids = Stop::where('address_id',$request->pick_location_id)->pluck('ride_id');
        $rides = Ride::query();
        $rides = $rides->where('status','!=','inactive');

        // gender
        if(!empty($request->gender)){
            switch(strtolower($request->gender)){
                case 'male':
                    $gender = User::GENDER_MALE;
                    break;
                case 'female':
                    $gender = User::GENDER_FEMALE;
                    break;
            }
            if(isset($gender)){
                $user_ids = User::where('gender',$gender)->pluck('id');
                $rides = $rides->whereIn('user_id',$user_ids);
            }
        }

        // vehicle type
        if(!empty($request->vehicle_type)){
            switch(strtolower($request->vehicle_type)){
                case 'car':
                    $vehicle_type = Ride::VEHICLE_CAR;
                    break;
                case 'bike':
                    $vehicle_type = Ride::VEHICLE_BIKE;
                    break;
                case 'van':
                    $vehicle_type = Ride::VEHICLE_VAN;
                    break;
            }
            if(isset($vehicle_type)){
                $rides = $rides->where('vehicle_type',$vehicle_type);
            }
        }

        // role
        if(!empty($request->role)){
            switch(strtolower($request->role)){
                case 'driver':
                    $role = Ride::ROLE_DRIVER;
                    break;
                case 'passenger':
                    $role = Ride::ROLE_PASSENGER;
                    break;
            }
            if(isset($role)){
                $rides = $rides->where('role',$role);
            }
        }

        if(isset($request->pick_location_id)){
            $rides = $rides->whereIn('id',$ride_ids);
        }
        if(isset($request->drop_location_id)){
            $rides = $rides->where('drop_location_id',$request->drop_location_id);
        }
        $rides = $rides->where('end_date', '>=', Carbon::today()->toDateString())
                    ->with('user')
                    // ->whereHas('user', function ($query) {$query->whereNotNull('email_verified_at');})
                    ->with('latestComment') // Eager load only the latest comment
                    ->withCount('comments')
                    ->with('stops')
                    ->with('stops.address')
                    ->with('interested_users')
                    ->with('pick_location')
                    ->with('drop_location')
                    ->orderby('created_at','desc');
        return $rides->paginate(15);
    }

    public function getRideByUserId($user_id){
        return Ride::where('user_id',$user_id)
                // ->where('end_date',">=",Carbon::now())
                ->with('interested_users')
                ->with('pick_location')
                ->with('drop_location')
                ->orderby('created_at','desc')
                ->paginate(20);
    }
    
    public function getRideByIdWithComments($ride_id){
        return Ride::where('id',$ride_id)
                ->where('end_date',">=",Carbon::now())
                ->with(['comments' => function ($query) {
                    $query->with('user')->orderBy('created_at', 'desc')->paginate(1000);
                }])
                ->first();
    }
    
    public function getRideByIdWithStops($ride_id){
        return Ride::where('id',$ride_id)
                ->where('end_date',">=",Carbon::now())
                ->with('stops')
                ->first();
    }
    
    public function getRideByIdWithUser($ride_id){
        return Ride::where('id',$ride_id)
                ->where('end_date',">=",Carbon::now())
                ->with('user')
                ->first();
    }
    
    public function getUserEmailsFromActiveRidesByPickAndDrop($ride, $pick_location_id, $drop_location_id){
        $user_ids =  Ride::where('id' , "!=" , $ride->id)
                ->where('pick_location_id',$pick_location_id)
                ->where('drop_location_id',$drop_location_id)
                ->pluck('user_id');
        return User::whereIn('id',$user_ids)->get();
    }

    public function createNewRideByUserId($data,$user_id){
        $data['user_id'] = $user_id;

        // TODO: this will be removed for charging service fee
        $data['status'] = 'active';

        $ride = Ride::create($data);

        // add pick stop
        $this->addStopToRide($ride->id, $data['pick_location_id'], Stop::TYPE_PICK);

        // add drop stop
        $this->addStopToRide($ride->id, $data['drop_location_id'], Stop::TYPE_DROP);

        if($ride){
            // call the RideCreated event
            event(new RideRequestCreated($ride));
        }

        return $ride;
    }

    public function updateRideByUserId($data,$user_id){
        $data['user_id'] = $user_id;

        $ride = Ride::find($data['id']);
        $ride->update($data);

        // add pick stop
        $this->addStopToRide($ride->id, $ride->pick_location_id, Stop::TYPE_PICK);

        // add drop stop
        $this->addStopToRide($ride->id, $ride->drop_location_id, Stop::TYPE_DROP);

        return $ride;
    }

    public function addStopToRide($ride_id, $address_id, $type){
        return $this->stopRepository->addStopToRide($ride_id, $address_id, $type);
    }
}
