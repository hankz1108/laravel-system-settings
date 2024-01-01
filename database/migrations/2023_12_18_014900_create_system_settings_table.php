<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('system-settings.table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('group')->comment('取用group');
            $table->string('key')->comment('取用key');
            $table->text('value')->nullable()->comment('內容');
            $table->text('description')->nullable()->comment('說明');
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
        Schema::dropIfExists(env('system-settings.table_name'));
    }
}
