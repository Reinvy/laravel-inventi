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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('brand');
            $table->string('sn');
            $table->string('code');
            $table->string('status');
            $table->string('condition');
            $table->date('procurement_date');
            $table->string('description')->nullable();
            $table->boolean('is_used')->default(false);
            $table->string("unit")->nullable();
            $table->string("sub_unit")->nullable();
            $table->string("user")->nullable();
            $table->string("sap_number")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
