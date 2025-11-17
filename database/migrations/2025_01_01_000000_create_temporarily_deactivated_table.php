<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('temporarily_deactivated', function (Blueprint $table) {
            $table->id();
            $table->morphs('deactivatable');
            $table->timestamp('deactivate_until')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('temporarily_deactivated');
    }
};