<?php

use App\Enums\OrderStatus;
use App\Models\Hmo;
use App\Models\HmoBatch;
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
            $table->foreignIdFor(Hmo::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(HmoBatch::class)->nullable()
                ->constrained('hmo_batches')
                ->nullOnDelete();
            $table->string('provider', 60);
            $table->double('total', 16, 2);
            $table->json('items');
            $table->date('encounter_date');
            $table->string('status', 25)
                ->default(OrderStatus::PENDING->value)
                ->index();
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
        Schema::dropIfExists('orders');
    }
}
