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
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->timestamp('expiration_date')->nullable();
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('codes');
    }
};
