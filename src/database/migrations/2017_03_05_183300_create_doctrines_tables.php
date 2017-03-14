<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateDoctrinesTables extends Migration
{
	public function up()
	{
		Schema::create('doctrines_doctrine_folders', function (Blueprint $table) {
			$table->increments('id');

			$table->string('name');
			$table->tinyInteger('order')->default(0);
		});

		Schema::create('doctrines_doctrines', function (Blueprint $table) {
			$table->increments('id');

			$table->string('name');
			$table->longText('comment')->nullable();
			$table->string('permission');
			$table->boolean('published');

			$table->softDeletes();
			$table->timestamps();

			$table->integer('folder_id')->unsigned()->nullable();
			$table->foreign('folder_id')
				->references('id')
				->on('doctrines_doctrine_folders')
				->onDelete('set null');

			$table->integer('owner_id')->unsigned()->nullable();
			$table->foreign('owner_id')
				->references('id')
				->on('users')
				->onDelete('set null');
		});

		Schema::create('doctrines_fit_categories', function (Blueprint $table) {
			$table->increments('id');

			$table->string('name');
			$table->longText('comment')->nullable();
		});

		Schema::create('doctrines_fits', function (Blueprint $table) {
			$table->increments('id');

			$table->string('name');
			$table->longText('comment')->nullable();
			$table->boolean('published');

			$table->softDeletes();
			$table->timestamps();

			$table->integer('ship');
			$table->foreign('ship')
				  ->references('typeID')
				  ->on('invTypes');

			$table->integer('category_id')->unsigned()->nullable();
			$table->foreign('category_id')
				->references('id')
				->on('doctrines_fit_categories')
				->onDelete('set null');

			$table->integer('owner_id')->unsigned()->nullable();
			$table->foreign('owner_id')
				->references('id')
				->on('users')
				->onDelete('set null');
		});

		Schema::create('doctrines_doctrine_fit', function (Blueprint $table) {
			$table->integer('doctrine_id')->unsigned();
			$table->foreign('doctrine_id')
				  ->references('id')
				  ->on('doctrines_doctrines')
				  ->onDelete('cascade');

			$table->integer('fit_id')->unsigned();
			$table->foreign('fit_id')
				  ->references('id')
				  ->on('doctrines_fits')
				  ->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('doctrines_doctrine_fit');
		Schema::drop('doctrines_doctrines');
		Schema::drop('doctrines_fits');
		Schema::drop('doctrines_doctrine_folders');
		Schema::drop('doctrines_fit_categories');
	}
}