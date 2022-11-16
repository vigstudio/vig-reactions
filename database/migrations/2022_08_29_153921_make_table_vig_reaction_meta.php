<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTableVigReactionMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('vig_reaction_meta');
        Schema::create('vig_reaction_meta', function (Blueprint $table) {
            $table->id();
            $table->text('value')->nullable();
            $table->integer('reactable_id')->unsigned()->nullable();
            $table->string('reactable_type')->nullable();
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
        Schema::dropIfExists('vig_reaction_meta');
    }
}
