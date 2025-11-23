<?php

namespace App\Providers;

use App\Models\DocumentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer(['student.*'], function ($view) {
            if (Auth::check() && Auth::user()->role === 'student') {
                $userId = Auth::id();

                $ref_no = Cache::remember("student:ref_no:{$userId}", now()->addSeconds(5), function () use ($userId) {
                    return DocumentRequest::where('user_id', $userId)
                        ->latest()
                        ->value('reference_number');
                });

                $view->with('ref_no', $ref_no);
            }
        });
        // View::composer(['student.*'], function ($view) {
        //     if (Auth::check() && Auth::user()->role === 'student') {
        //         static $ref_no = null;

        //         if($ref_no === null) {
        //             $ref_no = DocumentRequest::where('user_id', Auth::id())
        //                 ->latest()
        //                 ->value('reference_number');
        //         }
        //         $view->with('ref_no', $ref_no);
        //     }
        // });
    }
}
