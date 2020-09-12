<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->string('v_code')->nullable();
            $table->string('status')->default('registered');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        $user =  (object) json_decode(json_encode([
            "full_name" => "Admin Admin",
            "first_name"=>"Admin",
            "last_name"=>"Admin",
            "email"=>"admin@admin.com",
            "mobile"=>"09011223344",
            "password"=>bcrypt("password"),
        ]));
        
        // $user = auth()->guard('api')->user();
        $admin = [
            'id'             => 1,
            'full_name' => $user->full_name,
            'first_name'           => $user->first_name,
            'last_name'     =>  $user->last_name,
            'email'          => $user->email,
            'mobile'          => $user->mobile,
            'status'          => 'active',
            'password'       => $user->password,
            'remember_token' => null,
            'created_at'     => Carbon::now(),
            'email_verified_at'     =>  Carbon::now(),
            'updated_at'     => Carbon::now(),
            'deleted_at'     => null,
        ];

        $admin = User::insert($admin);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
