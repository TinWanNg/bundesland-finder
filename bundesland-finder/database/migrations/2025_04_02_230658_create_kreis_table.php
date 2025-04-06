<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kreis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('bezirk_id')->constrained('bezirk')->onDelete('cascade');
            $table->geometry('positions', subtype: 'point', srid: 0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kreis');
    }
};
