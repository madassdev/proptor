<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('active');
            $table->string('type')->default('active');
            $table->string('name');
            $table->string('slug');
            $table->integer('price');
            $table->integer('general_price')->nullable();
            $table->integer('units')->default(1);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            $table->text('image_url')->nullable();
            $table->text('gallery_images_url')->nullable();

            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->text('neighborhood')->nullable();

            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('size')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();

            $table->string('bedrooms')->nullable();
            $table->string('bathrooms')->nullable();
            $table->string('unit')->nullable();
            $table->string('measurement')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
