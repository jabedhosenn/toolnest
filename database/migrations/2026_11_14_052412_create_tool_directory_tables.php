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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon', 50);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon', 50);
            $table->string('route_name')->unique();
            $table->string('component_identifier')->unique();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'is_active', 'sort_order']);
            $table->index(['is_popular', 'is_active', 'sort_order']);
            $table->index(['is_featured', 'is_active', 'sort_order']);
        });

        Schema::create('tool_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->unique(['tool_id', 'slug']);
        });

        Schema::create('tool_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'tool_id']);
        });

        Schema::create('recent_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tool_id')->constrained()->cascadeOnDelete();
            $table->timestamp('last_used_at');
            $table->timestamps();

            $table->unique(['user_id', 'tool_id']);
            $table->index(['user_id', 'last_used_at']);
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->char('currency', 3)->default('USD');
            $table->string('billing_interval')->default('month');
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->restrictOnDelete();
            $table->string('status')->default('active');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['plan_id', 'status']);
        });

        Schema::create('usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tool_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action')->default('used');
            $table->json('metadata')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();

            $table->index(['user_id', 'occurred_at']);
            $table->index(['tool_id', 'occurred_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usage_logs');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('recent_tools');
        Schema::dropIfExists('tool_favorites');
        Schema::dropIfExists('tool_tags');
        Schema::dropIfExists('tools');
        Schema::dropIfExists('categories');
    }
};
