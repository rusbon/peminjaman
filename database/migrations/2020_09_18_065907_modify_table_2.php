<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locSpecifics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('location_id', false, true);
            $table->string('name');
            $table->timestamps();

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->bigInteger('locSpecific_id', false, true);
            $table->string('misc')->nullable();

            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
            $table->dropColumn('quantity');

            $table->foreign('locSpecific_id')
                ->references('id')
                ->on('locSpecifics')
                ->onDelete('cascade');
        });

        Schema::table('loanings', function (Blueprint $table) {
            $table->string('misc')->nullable();
            $table->string('contact');
            $table->dropColumn('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('misc');

            $table->dropForeign(['locSpecific_id']);
            $table->dropColumn('locSpecific_id');

            $table->integer('quantity');

            $table->bigInteger('location_id', false, true);
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');
        });
        Schema::table('loanings', function (Blueprint $table) {
            $table->dropColumn('misc');
            $table->dropColumn('contact');
            $table->integer('quantity');
        });
        Schema::dropIfExists('locSpecifics');
    }
}
