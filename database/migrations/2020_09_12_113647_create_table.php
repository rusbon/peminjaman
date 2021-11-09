<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('location_id', false, true);
            $table->bigInteger('type_id', false, true);
            $table->bigInteger('name');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('cascade');
        });

        Schema::create('loanings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inventory_id', false, true);
            $table->string('name');
            $table->string('nrp');
            $table->integer('quantity');
            $table->timestamps();
            $table->timestamp('returned_at')->nullable();

            $table->foreign('inventory_id')
                ->references('id')
                ->on('inventories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists('types');
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('loanings');
    }
}
