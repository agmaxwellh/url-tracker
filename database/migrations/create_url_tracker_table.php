<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('url_tracker_table', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->string('url')->index();
            $table->string('placeholder')->index();
            $table->unsignedBigInteger('count')->default(0);
            $table->timestamps();
        });
    }
};
