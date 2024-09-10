<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilePictureToLoginModels extends Migration
{
    public function up()
    {
        Schema::table('login_models', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('driver_license_expiry_date');
        });
    }

    public function down()
    {
        Schema::table('login_models', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
        });
    }
}
