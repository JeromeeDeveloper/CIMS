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
        Schema::create('deceaseds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            //Mao ni ang mo determine kung kinsay nag manage sa deceased
            $table->string('lastaction_by');

            $table->char('causeofdeath');
            // N = Natural
            // A = Accident
            // H = Homicide
            // S = Suicide.
            // U = Undetermined
            // O = Other
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('suffix');
            //M = Male
            //F = Female
            $table->char('civilstatus');
            $table->char('sex');
            $table->date('dateof_death');
            $table->date('dateof_burial');
            $table->time('burial_time');
            $table->date('dateofbirth');
            $table->tinyInteger('approvalStatus')->default(0);
            $table->tinyInteger('new_notif')->default(0);
            $table->integer('remaining_balance')->default(0);
            // 0 = Not Burried / Pending Status
            // 1 = Burried
            // 2 = Mapped Out
            $table->tinyInteger('burriedStatus')->default(0);
            // 1 = Already Notified By Email
            // 0 = Pending / Not yet notified.
            $table->tinyInteger('hasSentEmail')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deceaseds');
    }
};
