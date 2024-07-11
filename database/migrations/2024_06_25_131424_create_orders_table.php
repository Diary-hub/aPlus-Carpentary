<?php

use App\Models\Client;
use App\Models\Employee;
use App\Models\OrderType;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OrderType::class, 'type_id')->nullable();
            $table->string('color');
            $table->decimal('meter');
            $table->foreignIdFor(Employee::class, 'employee_id')->nullable();
            $table->decimal('meter_price', 10, 2);
            $table->foreignIdFor(Client::class, 'client_id');
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->softDeletes();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
