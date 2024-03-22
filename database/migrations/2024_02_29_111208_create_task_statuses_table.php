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
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->enum('to_status', ['todo', 'inprogress', 'complete', 'verified', 'modification']);
            $table->date('status_change_date');
            $table->enum('from_status', ['todo', 'inprogress', 'complete', 'verified', 'modification']);
            $table->unsignedBigInteger('modify_user_id');
            $table->foreign('modify_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_statuses');
    }
};
