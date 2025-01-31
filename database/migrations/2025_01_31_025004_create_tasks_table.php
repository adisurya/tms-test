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
        Schema::create('tasks', callback: function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('tasks_name');
            $table->text('description')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->string('status')->index('tasks_status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
