<?php

namespace App\Providers;

use App\Repositories\AddressRepository;
use App\Repositories\CommentRepository;
use App\RepositoryInterfaces\RideRepositoryInterface;
use App\Repositories\RideRepository;
use App\Repositories\StopRepository;
use App\RepositoryInterfaces\AddressRepositoryInterface;
use App\RepositoryInterfaces\CommentRepositoryInterface;
use App\RepositoryInterfaces\StopRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RideRepositoryInterface::class, RideRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(StopRepositoryInterface::class, StopRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define the success macro
        Response::macro('success', function ($data = [], $message = 'Operation successful', $status = 200) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $status);
        });

        // Define the error macro
        Response::macro('error', function ($message = 'Operation failed', $status = 200) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], $status);
        });
        
        Paginator::useBootstrap();
        LogViewer::auth(function ($request) {
            // return true to allow viewing the Log Viewer.
            return true;
        });
    }
}
