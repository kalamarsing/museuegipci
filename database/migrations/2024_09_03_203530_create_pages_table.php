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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->softDeletes(); 
            $table->timestamps();
        });

        Schema::create('page_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->string('name');
            $table->longText('value');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onDelete('set null');
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_fields');
        Schema::dropIfExists('pages');
    }
};
