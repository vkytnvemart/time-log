<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('time_logs', function (Blueprint $table) {
        $table->id();
        $table->date('work_date');
        $table->text('description');
        $table->unsignedTinyInteger('hours');
        $table->unsignedTinyInteger('minutes');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_logs');
    }
};
