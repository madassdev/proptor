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
            $table->foreignId('type_id')->constrained();

            $table->string('name');
            $table->string('slug');
            $table->integer('price');
            $table->integer('general_price')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            $table->string('state')->nullable();
            $table->text('address')->nullable();
            $table->text('image_url')->nullable();
            $table->text('gallery_images_url')->nullable();
            $table->string('status')->default('active');
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
