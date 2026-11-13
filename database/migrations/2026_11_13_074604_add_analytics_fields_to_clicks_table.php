<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            // Align url_id with urls.id (it was created as a string column) and
            // give redirect_time_ms enough precision for real-world latencies.
            $table->unsignedBigInteger('url_id')->change();
            $table->decimal('redirect_time_ms', 8, 2)->default(0)->change();

            $table->string('ip_hash', 64)->nullable()->index();
            $table->string('referrer')->nullable();
            $table->string('country', 2)->nullable();

            $table->index(['url_id', 'created_at']);
        });

        // SQLite (used by the test suite) cannot attach foreign keys to
        // existing tables, so only add the constraint on other drivers.
        if (DB::connection()->getDriverName() !== 'sqlite') {
            Schema::table('clicks', function (Blueprint $table) {
                $table->foreign('url_id')->references('id')->on('urls')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            if (DB::connection()->getDriverName() !== 'sqlite') {
                $table->dropForeign(['url_id']);
            }

            $table->dropIndex(['ip_hash']);
            $table->dropIndex(['url_id', 'created_at']);
            $table->dropColumn(['ip_hash', 'referrer', 'country']);
        });

        Schema::table('clicks', function (Blueprint $table) {
            $table->string('url_id')->change();
            $table->float('redirect_time_ms', 2)->default(0.00)->change();
        });
    }
};
