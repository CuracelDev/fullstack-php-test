<?php

use App\Models\Hmo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hmo_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Hmo::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('cancelled_at')->nullable();
            $table->integer('finished_at')->nullable();
            $table->timestamps();

            $table->index(['cancelled_at', 'finished_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hmo_batches');
    }
};
