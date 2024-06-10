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
        Schema::create('coffinplots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_id');
            $table->foreign('block_id')
                ->references('id')
                ->on('blocks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('deceased_id');
            $table->foreign('deceased_id')
                ->references('id')
                ->on('deceaseds')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('plot_number');
            //1 = active - Naa pa sa cemetery
            //2 = inactive = transferred or nawala na sa cemetery
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coffinplots');
    }
};
