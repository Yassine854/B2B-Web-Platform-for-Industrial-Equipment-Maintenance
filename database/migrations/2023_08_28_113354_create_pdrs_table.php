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
        Schema::create('pdrs', function (Blueprint $table) {
            $table->id()->start_from(0001);
            $table->string('designation')->nullable();
            $table->string('reference')->nullable();
            $table->string('quantite')->nullable();
            $table->unsignedBigInteger('intervention_id')->nullable();
            $table->unsignedBigInteger('diagnostic_id')->nullable();
            $table->foreign('intervention_id')
            ->references('id')->on('interventions')->onDelete('cascade');
            $table->foreign('diagnostic_id')
            ->references('id')->on('diagnostics')->onDelete('cascade');
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
        Schema::dropIfExists('pdrs');
    }
};
