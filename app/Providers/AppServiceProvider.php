<?php

namespace App\Providers;

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
        Gate::define('update-contact', function ($user, $contact) {
            return $user->id == $contact->user_id;
        });

        Gate::define('add-contact-to-group', function ($user, $contact, $group){
            return $user->id == $contact->user_id && $user->id == $group->user_id;
        });

        if (Gate::denies('add-contact-to-group', [$contact, $group])) {
            abort(403);
        }
    }
}
