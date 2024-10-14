<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
{
    Schema::table('vehicles', function (Blueprint $table) {
        $table->string('vehicle_type')->after('user_id')->nullable(); // Add this column
    });
}

public function down()
{
    Schema::table('vehicles', function (Blueprint $table) {
        $table->dropColumn('vehicle_type');
    });
}

};
