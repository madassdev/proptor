<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('name');
            $table->string('secret', 100)->nullable();
            $table->string('provider')->nullable();
            $table->text('redirect');
            $table->boolean('personal_access_client');
            $table->boolean('password_client');
            $table->boolean('revoked');
            $table->timestamps();
        });

        DB::insert('insert into oauth_clients (id, name, secret, redirect, personal_access_client, password_client, revoked) values (?, ?, ?, ?, ?, ?, ?)',
            [1, 'Learnstack Personal Access Client', 'secret', 'https://learnstack.com', 1, 0, 0]);
        DB::insert('insert into oauth_clients (id, name, secret, redirect, personal_access_client, password_client, revoked) values (?, ?, ?, ?, ?, ?, ?)',
            [2, 'Learnstack Password Grant Client', 'grant', 'http://learnstack.com', 0, 1, 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_clients');
    }
}
