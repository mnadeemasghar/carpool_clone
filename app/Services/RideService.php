<?php
namespace App\Services;

use App\Events\RideRequestCreated;
use App\RepositoryInterfaces\RideRepositoryInterface;

class RideService
{
    protected $rideReposity;

    public function __construct(RideRepositoryInterface $rideReposity)
    {
        $this->rideReposity = $rideReposity;    
    }

    public function getRideByUserId($user_id){
        return $this->rideReposity->getRideByUserId($user_id);
    }
    
    public function getSearchedRides($request){
        return $this->rideReposity->getSearchedRides($request);
    }
    
    public function getSearchedMapedRides($request){
        return $this->rideReposity->getSearchedMapedRides($request);
    }

    public function getRideByIdWithComments($ride_id){
        return $this->rideReposity->getRideByIdWithComments($ride_id);
    }

    public function getRideByIdWithStops($ride_id){
        return $this->rideReposity->getRideByIdWithStops($ride_id);
    }

    public function getRideByIdWithUser($ride_id){
        return $this->rideReposity->getRideByIdWithUser($ride_id);
    }

    public function getUserEmailsFromActiveRidesByPickAndDrop($ride, $pick_location_id, $drop_location_id){
        return $this->rideReposity->getUserEmailsFromActiveRidesByPickAndDrop($ride, $pick_location_id, $drop_location_id);
    }

    public function createNewRideByUserId($data, $user_id){
        $ride = $this->rideReposity->createNewRideByUserId($data,$user_id);

        return $ride;
    }

    public function updateRideByUserId($data, $user_id){
        $ride = $this->rideReposity->updateRideByUserId($data,$user_id);
        return $ride;
    }
}