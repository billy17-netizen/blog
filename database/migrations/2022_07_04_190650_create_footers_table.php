<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->text('short_description')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('copyright')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('footers');
    }
};
