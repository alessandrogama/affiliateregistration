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
        Schema::create('affiliate_referrals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('affiliate_id');
            $table->unsignedBigInteger('referrer_identifier'); 
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('referrer_identifier')->references('id')->on('affiliates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_referrals');
    }
};
