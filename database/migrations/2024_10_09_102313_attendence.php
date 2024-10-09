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
        Schema::create('attendence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Guard_id')->references('id')->on('Guards')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('Name');
            $table->string('Alert1');
            $table->string('Alert2');
            $table->string('Alert3');
            $table->string('Alert4');
            $table->string('Alert5');
            $table->string('Percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendence');
    }
};
