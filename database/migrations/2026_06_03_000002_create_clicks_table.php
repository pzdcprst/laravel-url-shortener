<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clicks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('short_url_id')->constrained('short_urls')->cascadeOnDelete();
            $table->string('ip', 45);
            $table->text('user_agent')->nullable();
            $table->string('referer', 2048)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['short_url_id', 'created_at']);
            $table->index(['short_url_id', 'ip']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
