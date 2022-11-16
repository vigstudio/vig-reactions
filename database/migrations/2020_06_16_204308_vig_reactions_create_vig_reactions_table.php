<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class VigReactionsCreateVigReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('vig_reactions');
        Schema::create('vig_reactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 10);
            $table->bigInteger('reaction_id')->nullable();
            $table->string('reaction_type')->nullable();
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
        Schema::dropIfExists('vig_reactions');
    }
}
