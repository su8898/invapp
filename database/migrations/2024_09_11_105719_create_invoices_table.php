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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_no")->index();
            $table->timestamp("invoice_date");
            $table->integer("customer_id");
            $table->string("terms")->nullable();
            $table->string("reference")->nullable();
            $table->float("gross_amt");
            $table->float("vat_amt");
            $table->float("net_amt");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
