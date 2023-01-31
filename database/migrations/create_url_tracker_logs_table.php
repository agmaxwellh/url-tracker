<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('url_tracker_logs_table', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('url_tracker_table_id')->index();
            $table->ipAddress()->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('method')->nullable();
            $table->timestamps();
        });
    }
};
