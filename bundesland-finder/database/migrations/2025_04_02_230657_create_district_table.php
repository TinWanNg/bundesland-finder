<?php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('district', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('city_id')->constrained('city')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('district');
    }
};

