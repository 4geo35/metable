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
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("content");
            $table->string("property")->nullable();
            $table->unsignedBigInteger("meta_id")->nullable();
            $table->unsignedBigInteger("metable_id")->nullable();
            $table->string("metable_type")->nullable();
            $table->string("page")->nullable();
            $table->dateTime("separated")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metas');
    }
};
