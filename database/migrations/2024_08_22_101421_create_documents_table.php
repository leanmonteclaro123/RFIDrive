<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id'); // Foreign key to vehicles table
            $table->string('type'); // Type of document (e.g., DL_front, OR, CR)
            $table->string('file_path'); // File storage path
            $table->date('expiry_date')->nullable(); // Nullable for non-expiring documents
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
