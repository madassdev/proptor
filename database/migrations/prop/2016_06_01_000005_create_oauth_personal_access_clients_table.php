<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class CreateOauthPersonalAccessClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_personal_access_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();
        });
        DB::insert('insert into oauth_personal_access_clients (id, client_id) values (?, ?)',
            [1, 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    //just a way
    public function down()
    {
        Schema::dropIfExists('oauth_personal_access_clients');
    }
}
