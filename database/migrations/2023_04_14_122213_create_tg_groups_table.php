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

        Schema::create('tg_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_title');
            $table->string('group_id');
            $table->boolean('allow_messages')->default(true);
            $table->string('city')->default('Kyiv');
            $table->string('message_period')->nullable()->default("[0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]");
            $table->string('message_type')->nullable()->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_groups');
    }
};
