<?php
namespace App\Services;

use App\Models\User;
use Google_Client;

class GoogleApi
{
    public function getGoogleAccessToken(){

        $credentialsFilePath = storage_path('carpool-lahore-firebase-adminsdk-k3eao-6d06b85d47.json'); //replace this with your actual path and file name
        $client = new Google_Client();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        return $token['access_token'];
    }

    public function sendNotification($userId, $title, $body)
    {
        $user = User::findOrFail($userId);

        if (!$user->device_token) {
            return redirect()->route('dashboard')->dangerBanner('User does not have a device token.');
        }

        $data = [
            "message" => [
                "token" => $user->device_token,
                "notification" => [
                    "title" => $title,
                    "body" => $body
                ]
            ]
        ];

        $headers = [
            'Authorization: Bearer ' . $this->getGoogleAccessToken(),
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/carpool-lahore/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }
}