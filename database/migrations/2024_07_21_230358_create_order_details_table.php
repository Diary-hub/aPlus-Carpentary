<?php

use App\Models\Employee;
use App\Models\Qyasat;
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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->decimal('price');
            $table->string('resource_type');
            $table->string('description')->nullable();
            $table->decimal('price_meter');
            $table->decimal('meter');
            $table->decimal('total_meter_price');

            $table->foreignIdFor(Qyasat::class, 'qyas_id')->nullable();
            $table->foreignIdFor(Employee::class, 'employee_id')->nullable();



            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
