<?php

namespace App\Providers;

use App\Models\Setting;
use App\Utils\NotificationUtility;
use App\Repositories\Customer\AuthRepository;
use App\Repositories\Customer\Interfaces\AuthRepositoryInterface;
use App\Repositories\Provider\AuthRepository as ProviderAuthRepository;
use App\Repositories\Provider\Interfaces\AuthRepositoryInterface as InterfacesAuthRepositoryInterface;
use App\Services\Customer\AuthService;
use App\Services\Customer\Interfaces\AuthServiceInterface;
use App\Services\Provider\AuthService as ProviderAuthService;
use App\Services\Provider\Interfaces\AuthServiceInterface as InterfacesAuthServiceInterface;
use App\Utils\ProjectUtility;
use App\Utils\Utility;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Project;
use App\Observers\ProjectObserver;
use App\Observers\InspectionObserver;
use App\Models\Inspection;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\ProjectReport;
use App\Observers\OfferItemObserver;
use App\Observers\OfferObserver;
use App\Observers\ProjectReportObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      $this->app->bind(AuthServiceInterface::class , AuthService::class);
      $this->app->bind(AuthRepositoryInterface::class , AuthRepository::class);
      $this->app->bind(InterfacesAuthServiceInterface::class , ProviderAuthService::class);
      $this->app->bind(InterfacesAuthRepositoryInterface::class , ProviderAuthRepository::class);


        $this->app->singleton('utility', function () {
            return new Utility();
        });
          $this->app->singleton('ProjectUtility', function () {
            return new ProjectUtility();
        });  
        $this->app->singleton('NotificationUtility', function () {
            return new NotificationUtility();
        });
    }



    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

           if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }

         Carbon::setLocale('ar');
         Project::observe(ProjectObserver::class);
         Inspection::observe(InspectionObserver::class);
         Offer::observe(OfferObserver::class);
         OfferItem::observe(OfferItemObserver::class);
        ProjectReport::observe(ProjectReportObserver::class);
        $this->applyMailSettingsFromDatabase();

    }

    protected function applyMailSettingsFromDatabase(): void
    {
        if (!Schema::hasTable('settings')) {
            return;
        }

        $settings = Setting::whereIn('key', [
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ])->pluck('value', 'key');

        if ($settings->isEmpty()) {
            return;
        }

        config([
            'mail.default' => $settings['mail_mailer'] ?? config('mail.default'),
            'mail.mailers.smtp.host' => $settings['mail_host'] ?? config('mail.mailers.smtp.host'),
            'mail.mailers.smtp.port' => (int) ($settings['mail_port'] ?? config('mail.mailers.smtp.port')),
            'mail.mailers.smtp.username' => $settings['mail_username'] ?? config('mail.mailers.smtp.username'),
            'mail.mailers.smtp.password' => $settings['mail_password'] ?? config('mail.mailers.smtp.password'),
            'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? config('mail.mailers.smtp.encryption'),
            'mail.from.address' => $settings['mail_from_address'] ?? config('mail.from.address'),
            'mail.from.name' => $settings['mail_from_name'] ?? config('mail.from.name'),
        ]);
    }
}
