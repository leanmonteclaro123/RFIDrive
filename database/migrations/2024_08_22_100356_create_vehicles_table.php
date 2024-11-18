<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to login_models table
            $table->string('license_plate')->nullable();
            $table->string('province');
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('color');
            $table->string('registered_owner_name');
            $table->string('registered_owner_province');
            $table->string('registered_owner_municipality');
            $table->string('registered_owner_barangay');
            $table->string('registered_owner_zipcode');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('login_models')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key constraint
        });
    
        Schema::dropIfExists('vehicles');
    }
    
    
}
