<?php

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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->float('value', 8,2);
            $table->boolean('paid')->default(false);
            $table->boolean('paid_owner')->default(false);
          
          
            $table->foreignId('created_by')->constrained('users')
                ->constrained()
                ->onDelete('cascade');
                
                
                


           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};

