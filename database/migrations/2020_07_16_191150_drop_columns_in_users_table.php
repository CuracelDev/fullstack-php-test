<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'tax_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('tax_status');
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
        if (Schema::hasColumn('users', 'tax_status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('tax_status');
            });
        }
    }
}
