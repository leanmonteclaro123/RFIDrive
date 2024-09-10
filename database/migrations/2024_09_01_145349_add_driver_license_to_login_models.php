<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDriverLicenseToLoginModels extends Migration
{
    public function up()
    {
        Schema::table('login_models', function (Blueprint $table) {
            $table->string('driver_license_front')->nullable()->after('email');
            $table->string('driver_license_back')->nullable()->after('driver_license_front');
            $table->date('driver_license_expiry_date')->nullable()->after('driver_license_back');
        });
    }

    public function down()
    {
        Schema::table('login_models', function (Blueprint $table) {
            $table->dropColumn(['driver_license_front', 'driver_license_back', 'driver_license_expiry_date']);
        });
    }
}
