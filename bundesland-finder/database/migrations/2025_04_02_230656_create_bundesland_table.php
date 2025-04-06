<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bundesland', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('capital')->unique();
            $table->geometry('positions', subtype: 'point', srid: 0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundesland');
    }
};

