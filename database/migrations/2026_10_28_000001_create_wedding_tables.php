<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Wedding site data, previously kept in data/*.json:
 *   data.json            -> rsvps
 *   comments.json        -> wishes
 *   invites.json         -> invites
 *   memories.json        -> memory_posts
 *   memory_comments.json -> memory_comments
 *   media.json           -> settings (key "media")
 *
 * legacy_id keeps the id a record had in the JSON files, so importing the
 * same files again (php artisan wedding:import-json) never duplicates rows.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->string('legacy_id', 64)->nullable()->unique();
            $table->text('token')->nullable();
            $table->string('token_hash', 64)->nullable()->unique(); // sha256(token): tokens are too long to index directly
            $table->string('fullname');
            $table->string('phone', 50)->default('');
            $table->unsignedTinyInteger('guests')->default(1);
            $table->string('attend', 3); // yes | no
            $table->text('message')->nullable();
            $table->string('ip_address', 45)->default('');
            $table->string('user_agent')->default('');
            $table->timestamp('edited_at')->nullable(); // last time the guest resent their RSVP
            $table->timestamps();
        });

        Schema::create('wishes', function (Blueprint $table) {
            $table->id();
            $table->string('legacy_id', 64)->nullable()->unique();
            $table->foreignId('rsvp_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('message')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->string('ip_address', 45)->default('');
            $table->string('user_agent')->default('');
            $table->timestamps();
        });

        Schema::create('invites', function (Blueprint $table) {
            $table->id();
            $table->text('token');
            $table->string('token_hash', 64)->unique();
            $table->string('name');
            $table->timestamp('first_opened_at')->nullable();
            $table->timestamp('last_opened_at')->nullable();
            $table->unsignedInteger('open_count')->default(0);
            $table->timestamps();
        });

        Schema::create('memory_posts', function (Blueprint $table) {
            $table->id();
            $table->string('legacy_id', 64)->nullable()->unique();
            $table->timestamp('posted_at')->nullable();
            $table->text('content');
            $table->json('images')->nullable();
            $table->unsignedInteger('likes')->default(0);
            $table->timestamps();
        });

        Schema::create('memory_comments', function (Blueprint $table) {
            $table->id();
            $table->string('legacy_id', 64)->nullable()->unique();
            $table->foreignId('memory_post_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->text('message');
            $table->string('ip_address', 45)->default('');
            $table->string('user_agent')->default('');
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key', 100)->primary();
            $table->json('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('memory_comments');
        Schema::dropIfExists('memory_posts');
        Schema::dropIfExists('invites');
        Schema::dropIfExists('wishes');
        Schema::dropIfExists('rsvps');
    }
};
