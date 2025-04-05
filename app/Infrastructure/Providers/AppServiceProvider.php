<?php

namespace App\Infrastructure\Providers;

use App\Application\EventHandlers\ClinicalResource\NotifyNutritionist;
use App\Application\EventHandlers\ClinicalResource\NotifyNutritionistWhenCreatedAppointment;
use App\Application\EventHandlers\Patient\SendWelcomeEmailWhenCreatedPatient;
use App\Domain\Events\ClinicalResourceAdded;
use App\Domain\Events\CreatedAppointment;
use App\Domain\Events\PatientCreated;
use App\Infrastructure\Persistence\UnitOfWork\EloquentUnitOfWork;
use App\Shared\UnitOfWork;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UnitOfWork::class, EloquentUnitOfWork::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(ClinicalResourceAdded::class, NotifyNutritionist::class);
        Event::listen(CreatedAppointment::class, NotifyNutritionistWhenCreatedAppointment::class);
        Event::listen(PatientCreated::class, SendWelcomeEmailWhenCreatedPatient::class);
    }
}
