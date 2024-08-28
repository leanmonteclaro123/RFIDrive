<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginModelsTable extends Migration
{
    public function up()
    {
        Schema::create('login_models', function (Blueprint $table) {
            $table->id();
            $table->string('role')->default('User');
            $table->string('full_name');
            $table->string('telephone', 11);
            $table->string('province');
            $table->string('municipal');
            $table->string('barangay');
            $table->string('zipcode', 10);
            $table->string('type');
            $table->string('codeID')->nullable();
            $table->string('campus')->default('Batangas State University ARASOF Nasugbu');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('login_models');
    }
}
