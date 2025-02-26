<?php

namespace App\Infrastructure\Providers;

use App\Application\UseCases\Appointment\Command\CreateAppointmentCommand;
use App\Application\UseCases\Appointment\Command\CreateAppointmentCommandHandler;
use App\Application\UseCases\Appointment\Queries\GetAppointmentsByNutritionistIdQuery;
use App\Application\UseCases\Appointment\Queries\GetAppointmentsByNutritionistIdQueryHandler;
use App\Application\UseCases\Patient\Command\AddAddressCommand;
use App\Application\UseCases\Patient\Command\AddAddressCommandHandler;
use App\Application\UseCases\Patient\Command\AddDietaryPreferenceCommand;
use App\Application\UseCases\Patient\Command\AddDietaryPreferenceCommandHandler;
use App\Application\UseCases\Patient\Command\AddMeasurementCommand;
use App\Application\UseCases\Patient\Command\AddMeasurementCommandHandler;
use App\Application\UseCases\Patient\Command\CreatePatientCommand;
use App\Application\UseCases\Patient\Command\CreatePatientCommandHandler;
use App\Application\UseCases\Patient\Command\CreateTicketCommand;
use App\Application\UseCases\Patient\Command\CreateTicketCommandHandler;
use App\Application\UseCases\Patient\Queries\GetAllPatientsQuery;
use App\Application\UseCases\Patient\Queries\GetAllPatientsQueryHandler;
use App\Infrastructure\Core\CommandBus;
use App\Infrastructure\Persistence\UnitOfWork\EloquentUnitOfWork;
use App\Infrastructure\Repositories\Appointment\AppointmentRepositoryImpl;
use App\Infrastructure\Repositories\Patient\PatientRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CommandBus::class, function () {
            $commandBus = new CommandBus();
            //commands
            $commandBus->register(CreateAppointmentCommand::class, new CreateAppointmentCommandHandler(new AppointmentRepositoryImpl(), new EloquentUnitOfWork()));
            $commandBus->register(CreatePatientCommand::class, new CreatePatientCommandHandler(new PatientRepositoryImpl(), new EloquentUnitOfWork()));
            $commandBus->register(AddAddressCommand::class, new AddAddressCommandHandler(new PatientRepositoryImpl(), new EloquentUnitOfWork()));
            $commandBus->register(AddDietaryPreferenceCommand::class, new AddDietaryPreferenceCommandHandler(new PatientRepositoryImpl(), new EloquentUnitOfWork()));
            $commandBus->register(AddMeasurementCommand::class, new AddMeasurementCommandHandler(new PatientRepositoryImpl(), new EloquentUnitOfWork()));
            $commandBus->register(CreateTicketCommand::class, new CreateTicketCommandHandler(new PatientRepositoryImpl(), new EloquentUnitOfWork()));

            //queries
            $commandBus->register(GetAppointmentsByNutritionistIdQuery::class, new GetAppointmentsByNutritionistIdQueryHandler(new AppointmentRepositoryImpl()));
            $commandBus->register(GetAllPatientsQuery::class, new GetAllPatientsQueryHandler(new PatientRepositoryImpl()));

            return $commandBus;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
