<?php

use App\Models\User;
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
        Schema::create('permession_models', function (Blueprint $table) {
            $table->id();
            $table->boolean('isAdmin')->default(0);

            $table->boolean('canViewProduct')->default(0);
            $table->boolean('canViewCompany')->default(0);
            $table->boolean('canViewCategory')->default(0);

            $table->boolean('canEditProduct')->default(0);
            $table->boolean('canEditCompany')->default(0);
            $table->boolean('canEditCategory')->default(0);

            $table->boolean('canAddProduct')->default(0);

            $table->boolean('canViewEmployee')->default(0);
            $table->boolean('canEditEmployee')->default(0);

            $table->boolean('canViewQyasat')->default(0);
            $table->boolean('canEditQyasat')->default(0);

            $table->foreignIdFor(User::class, 'user_id');

            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permession_models');
    }
};
