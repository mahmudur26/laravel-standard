<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_hit_records', function (Blueprint $table) {
            $table->id('api_hit_record_id');
            $table->string('api_visitor_ip', 45)->nullable(); // IPv6 safe
            $table->string('api_visitor_platform')->nullable();
            $table->string('api_visitor_browser_name')->nullable();
            $table->string('api_visitor_browser_version')->nullable();
            $table->string('api_visitor_os_type')->nullable();
            $table->string('api_path')->nullable();
            $table->string('api_version')->nullable();
            $table->string('api_visitor_device_type')->nullable();
            $table->string('api_visitor_device_brand')->nullable();
            $table->string('api_visitor_device_model')->nullable();
            $table->string('api_visitor_location_latitude')->nullable();
            $table->string('api_visitor_location_longitude')->nullable();
            $table->string('api_visitor_location_city')->nullable();
            $table->string('api_visitor_location_country')->nullable();
            $table->dateTime('api_visit_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_hit_records');
    }
};
