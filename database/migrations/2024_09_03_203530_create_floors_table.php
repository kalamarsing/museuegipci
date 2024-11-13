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
        Schema::create('floors', function (Blueprint $table) {
            $table->id();
            $table->string('map')->nullable();
            $table->softDeletes(); 
            $table->timestamps();
        });

        Schema::create('floor_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')->constrained('floors')->onDelete('cascade');
            $table->string('name');
            $table->longText('value');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onDelete('set null');
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('floor_fields');
        Schema::dropIfExists('floors');
    }
};
