<?php

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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('puid');
            $table->date('meal_date');
            $table->integer('location_id');
            $table->string('location_name');
            $table->string('mealperiod');
            $table->string('meal_day');
            $table->string('host_userid');
            $table->string('host_name');
            $table->string('guest_userid');
            $table->string('guest_name');
            $table->boolean('approved')->nullable();
            $table->string('status')->nullable();
            $table->text('comments')->nullable();
            $table->boolean('processed')->nullable();
            $table->boolean('manual_entry')->nullable();
            $table->string('entry_userid')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
