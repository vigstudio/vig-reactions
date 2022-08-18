<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class VigReactionsColumnSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vig_reactions', function (Blueprint $table) {
            $table->string('session_id')->nullable()->after('type');
            $table->bigInteger('user_id')->nullable()->after('reaction_type');
            $table->string('user_type')->nullable()->after('user_id');
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
