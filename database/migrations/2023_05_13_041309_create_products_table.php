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
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('image');
        $table->string('title');
        $table->string('slug');
        $table->unsignedBigInteger('category_id');
        $table->text('content');
        $table->bigInteger('weight');
        $table->json('variations')->nullable();
        $table->bigInteger('price');
        $table->integer('discount')->nullable();
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
        Schema::dropIfExists('products');
    }
};
