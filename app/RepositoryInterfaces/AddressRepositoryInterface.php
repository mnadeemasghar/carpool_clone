<?php
namespace App\RepositoryInterfaces;

interface AddressRepositoryInterface
{
    public function getAddressByTitle($title,$data);
    public function getAddresses($title);
}