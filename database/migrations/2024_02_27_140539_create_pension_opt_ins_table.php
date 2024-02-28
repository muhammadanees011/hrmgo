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
        Schema::create('pension_opt_ins', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('pension_scheme_id');
            $table->date('date');
            $table->string('status', 20)->default('Active');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pension_opt_ins');
    }
};

