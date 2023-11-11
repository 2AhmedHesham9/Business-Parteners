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
        Schema::create('parteners', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_partener');
            $table->string('description');
            $table->string('img_path');
            $table->string('link_company_profile');
            $table->string('link_facebook');
            $table->string('link_whatsapp');
            $table->string('phone_number');
            $table->string('link_instigram');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parteners');
    }
};
