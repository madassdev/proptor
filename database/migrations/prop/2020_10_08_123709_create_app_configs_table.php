<?php

use App\Models\AppConfig;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_configs', function (Blueprint $table) {
            $table->id();
            $table->text('config_key');
            $table->text('config_value')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->timestamps();
        });

        $ac = [
            [
                "config_key" => "app_name",
                "config_value" => json_encode("Proptor X")
            ], 
            [
                "config_key" => "contact_number",
                "config_value" => json_encode("08100000000")
            ], 
            [
                "config_key" => "domain_url",
                "config_value" => json_encode("https://proptorx.herokuapp.com")
            ],     
            [
                "config_key" => "email",
                "config_value" => json_encode("mail@proptorx.com")
            ], 
        ];

        $sc = AppConfig::insert($ac);

        $config_fields = [
            'email',
            'business_name',
            'mobile',
            'city',
            'state',
            'country',
            'address',
            'currency',
            'full_domain_url',
            'fcm_token',
            'chat_presence',
        ];
        foreach($config_fields as $field){
            AppConfig::updateOrCreate(['config_key'=>"$field"]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_configs');
    }
}
