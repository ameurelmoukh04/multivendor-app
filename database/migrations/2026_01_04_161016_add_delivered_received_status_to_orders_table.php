<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('received_at')->nullable()->after('status');
        });
        
        // Update status enum to include delivered and received
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'shipped', 'delivered', 'received', 'completed', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('received_at');
        });
        
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'shipped', 'completed', 'cancelled') DEFAULT 'pending'");
    }
};
