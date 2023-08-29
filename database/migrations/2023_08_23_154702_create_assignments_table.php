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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('product_id');
            $table->string('c_huile')->nullable();
            $table->string('c_filtre')->nullable();
            $table->string('c_dehuil')->nullable();
            $table->string('entretien')->nullable();

            $table->timestamp('updated_c_huile')->nullable();


            $table->foreign('client_id')
              ->references('id')->on('users')->onDelete('restrict');
            $table->foreign('product_id')
              ->references('id')->on('products')->onDelete('restrict');
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
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('updated_c_huile');
        });
    }
};
