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
        Schema::table('maintenance', function (Blueprint $table) {
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->after('status');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null')->after('supervisor_id');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->after('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropForeign(['created_by']);
            $table->dropColumn(['priority', 'assigned_to', 'created_by']);
        });
    }
};
