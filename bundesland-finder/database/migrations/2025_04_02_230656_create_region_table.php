<?php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('region', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('bundesland_id')->constrained('bundesland')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('region');
    }
};
