<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateOwnablesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(Config::get('amethyst.owner.data.ownable.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('owner_type')->string();
            $table->integer('owner_id')->unsigned();
            $table->string('relation')->nullable();
            $table->string('ownable_type')->string();
            $table->string('ownable_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('amethyst.owner.data.ownable.table'));
    }
}
