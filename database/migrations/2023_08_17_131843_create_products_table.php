<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->start_from(2015001);
            $table->string('image')->nullable();
            $table->string('name');
            $table->unsignedBigInteger('type_prod');
            $table->double('debit');
            $table->string('unity_debit');
            $table->double('pression');
            $table->string('year');
            $table->string('time_day');
            $table->foreign('type_prod')
            ->references('id')->on('typeproducts')->onDelete('restrict');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE products AUTO_INCREMENT = 2015001;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
