<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFrequencyLimitColumnInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('frequency_limit', ['annually', 'biannually', 'quarterly', 'monthly', 'bimonthly', 'forthnight', 'weekly', 'daily'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('frequency_limit', ['annually', 'biannually', 'quarterly', 'monthly', 'bimonthly', 'forthnight', 'weekly', 'daily'])->nullable();
        });
    }
}
