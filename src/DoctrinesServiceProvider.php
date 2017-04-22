<?php

namespace Seat\Kassie\Doctrines;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

use Seat\Kassie\Doctrines\Models\Fit;
use Seat\Kassie\Doctrines\Observers\FitObserver;
use Seat\Kassie\Doctrines\Commands\PurgeFit;

class DoctrinesServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->addRoutes();
		$this->addViews();
		$this->addMigrations();
		$this->addTranslations();
		$this->addPublications();
		$this->addObservers();
		$this->addCommands();
	}

	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/Config/package.sidebar.php', 'package.sidebar');
		$this->mergeConfigFrom(__DIR__ . '/Config/calendar.permissions.php', 'web.permissions');
	}

	private function addRoutes()
	{
		$this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
	}

	private function addViews()
	{
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'doctrines');
	}

	private function addMigrations()
	{
		$this->loadMigrationsFrom(__DIR__ . '/database/migrations');
	}

	private function addTranslations()
	{
		$this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'doctrines');
	}

	private function addPublications()
	{
		$this->publishes([
			__DIR__ . '/resources/assets/css' => public_path('web/css/kassie/doctrines'),
			__DIR__ . '/resources/assets/js' => public_path('web/js/kassie/doctrines')
		]);
	}

	private function addObservers() 
	{
		Fit::observe(FitObserver::class);
	}

	private function addCommands() 
	{
		$this->commands([
			PurgeFit::class,
		]);
	}
}
