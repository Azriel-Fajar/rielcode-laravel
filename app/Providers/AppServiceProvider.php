<?php

namespace App\Providers;

use App\Listeners\AdminAuthListener;
use App\Models\ChatLog;
use App\Models\ContactSubmission;
use App\Models\Order;
use App\Models\Package;
use App\Models\Project;
use App\Models\ReferralCommission;
use App\Models\Referrer;
use App\Models\Testimonial;
use App\Models\TestimonialInvite;
use App\Observers\AdminCrudObserver;
use Filament\Events\Auth\Login as FilamentLogin;
use Filament\Events\Auth\Logout as FilamentLogout;
use Illuminate\Auth\Events\Failed as AuthFailed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $observer = AdminCrudObserver::class;

        $listener = new AdminAuthListener;
        Event::listen(FilamentLogin::class, [$listener, 'handleLogin']);
        Event::listen(FilamentLogout::class, [$listener, 'handleLogout']);
        Event::listen(AuthFailed::class, [$listener, 'handleLoginFail']);

        Order::observe($observer);
        Package::observe($observer);
        Project::observe($observer);
        Testimonial::observe($observer);
        TestimonialInvite::observe($observer);
        Referrer::observe($observer);
        ReferralCommission::observe($observer);
        ChatLog::observe($observer);
        ContactSubmission::observe($observer);
    }
}
