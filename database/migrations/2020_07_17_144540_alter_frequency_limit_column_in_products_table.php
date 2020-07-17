<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFrequencyLimitColumnInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('products', 'frequency_limit')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('frequency_limit');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('products', 'frequency_limit')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('frequency_limit');
            });
        }
    }
}
