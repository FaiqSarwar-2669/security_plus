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
        Schema::create('guard_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guard_id')->nullable()->references('id')->on('Guards')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('company_id');
            $table->string('payablbe');
            $table->string('deduction');
            $table->text('total');
            $table->text('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_payment');
    }
};
