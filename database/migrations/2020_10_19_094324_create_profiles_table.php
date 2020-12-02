<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("userId");
            $table->string("profileName");
            $table->string("searchMethod");
            $table->string("type");
            $table->string("number");
            $table->string("payment");
            $table->string("deliveryPrice");
            $table->string("createCostDelivery");
            $table->string("deliveryCostCode");
            $table->string("deliveryCost");
            $table->string("costPrice");
            $table->string("createCost");
            $table->string("costCode");
            $table->string("paymentCode");
            $table->string("changePaymentStatus");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
