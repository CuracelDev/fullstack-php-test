<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->json('items');
            $table->timestamp('encounter_date');
            $table->foreignId('hmo_id')->cascadeOnDelete();
            $table->foreignId('provider_id')->cascadeOnDelete();
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('procesed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropConstrainedForeignId('provider_id');
        Schema::dropConstrainedForeignId('hmo_id');
        Schema::dropIfExists('orders');
    }
}
