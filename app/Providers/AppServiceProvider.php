<?php

namespace App\Providers;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Implementations\TaskRepository;
use App\Services\Contracts\TaskServiceInterface;
use App\Services\Implementations\TaskService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the TaskRepositoryInterface to its implementation
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);

        // Bind the TaskServiceInterface to its implementation
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
