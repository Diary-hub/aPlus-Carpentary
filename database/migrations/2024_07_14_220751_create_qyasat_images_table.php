<?php

use App\Models\Qyasat;
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
        Schema::create('qyasat_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignIdFor(Qyasat::class, 'qyasat_id')->constrained()->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qyasat_images');
    }
};
