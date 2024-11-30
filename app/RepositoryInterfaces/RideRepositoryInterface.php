<?php
namespace App\RepositoryInterfaces;

interface RideRepositoryInterface
{
    public function getRideByUserId($user_id);
    public function getSearchedRides($request);
    public function getSearchedMapedRides($request);
    public function getRideByIdWithComments($ride_id);
    public function getRideByIdWithStops($ride_id);
    public function getRideByIdWithUser($ride_id);
    public function getUserEmailsFromActiveRidesByPickAndDrop($ride, $pick_location_id, $drop_location_id);
    public function createNewRideByUserId($data,$user_id);
    public function updateRideByUserId($data,$user_id);
}