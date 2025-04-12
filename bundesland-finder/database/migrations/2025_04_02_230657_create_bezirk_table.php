<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bezirk', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('bundesland_id')->constrained('bundesland')->onDelete('cascade');
            $table->longText('geometry');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bezirk');
    }
};
