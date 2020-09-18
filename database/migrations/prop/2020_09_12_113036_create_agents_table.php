<?php

use App\Models\Agent;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });

        User::find(1)->agent()->create([
            'name' => 'Admin',
            'description' => 'This is the description of Admin as an Agent',
            'status' => 'approved'
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutors');
    }
}
