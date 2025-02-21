<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

use App\Utils\IOpenAIAPIClient;
use App\Utils\OpenAIAPIClient;
use App\Utils\MockOpenAIAPIClient;

use App\Adapters\Score\IScoringAdapter;
use App\Adapters\Score\MockScoringAdapter;
use App\Adapters\Score\ScoringAdapter;
use App\Adapters\Score\OpenAIScoringAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IOpenAIAPIClient::class, OpenAIAPIClient::class);
        $this->app->bind(IScoringAdapter::class, ScoringAdapter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
