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
        Schema::create('forms_and_portfolio', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('registrations')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->text('form_content')->nullable();
            $table->string('logo')->nullable();
            $table->string('Banner_image')->nullable();
            $table->text('portfolio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms_and_portfolio');
    }
};
