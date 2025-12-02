<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->float('temperature')->nullable();
            $table->float('humidity')->nullable();
            $table->float('tds_value')->nullable();
            $table->float('ph')->nullable();
            $table->float('water_level')->nullable();
            // Status pompa (simpan sebagai boolean atau integer 0/1)
            $table->boolean('pump_a_status')->default(0);
            $table->boolean('pump_b_status')->default(0);
            $table->boolean('refill_status')->default(0);
            $table->timestamps(); // Created_at otomatis mencatat waktu
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensors');
    }
};
