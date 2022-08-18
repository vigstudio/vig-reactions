<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnReaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vig_reactions', function (Blueprint $table) {
            $table->renameColumn('reaction_id', 'reactable_id');
            $table->renameColumn('reaction_type', 'reactable_type');
            $table->renameColumn('user_id', 'responder_id');
            $table->renameColumn('user_type', 'responder_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vig_reactions', function (Blueprint $table) {
            $table->renameColumn('reactable_id', 'reaction_id');
            $table->renameColumn('reactable_type', 'reaction_type');
            $table->renameColumn('responder_id', 'user_id');
            $table->renameColumn('responder_type', 'user_type');
        });
    }
}
