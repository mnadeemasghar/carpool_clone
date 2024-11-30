<?php
namespace App\RepositoryInterfaces;

interface StopRepositoryInterface
{
    public function addStopToRide($ride_id, $address_id, $type);
    public function getStopAddresses();
    public function deleteById($id);
}