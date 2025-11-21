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
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid'); // authenticated users have their own 'stuck' uuid, 
            // guests have a cookie based one that lasts 1 week

            // this also secures the stock count for 1 week
            // TODO: implement 'stock' item reservations (i.e. 'there are 5 items left in stock, 2 in cart)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_carts');
    }
};
