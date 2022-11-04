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
        Schema::create('item_details', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('supplier_name');
            $table->bigInteger('supplier_id')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->decimal('price')->nullable();
            $table->string('company')->nullable();
            $table->string('category')->nullable();
            $table->decimal('weight')->nullable();
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
        Schema::dropIfExists('item_details');
    }
};
