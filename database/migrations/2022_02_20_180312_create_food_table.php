<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedSmallInteger('calories');
            $table->unsignedSmallInteger('carbs');
            $table->string('meal'); // PHP 8.1 Enum 'breakfast', 'lunch', 'dinner' and 'snacks'
            $table->foreignIdFor(\App\Models\User::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
