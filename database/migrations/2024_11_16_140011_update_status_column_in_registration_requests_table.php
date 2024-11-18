<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInRegistrationRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('registration_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'validated'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('registration_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }
}
