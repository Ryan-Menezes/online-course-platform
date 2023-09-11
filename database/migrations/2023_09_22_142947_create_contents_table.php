<?php

use App\Models\File;
use App\Models\User;
use App\Models\Content;
use App\Models\Section;
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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Section::class)->references('id')->on('sections')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(File::class, 'file_thumb_id')->references('id')->on('files')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(File::class, 'file_video_id')->nullable()->references('id')->on('files')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->text('description');
            $table->string('iframe')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        Schema::create('content_file', function (Blueprint $table) {
            $table->foreignIdFor(Content::class)->references('id')->on('contents')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(File::class)->references('id')->on('files')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('content_viewed', function (Blueprint $table) {
            $table->foreignIdFor(Content::class)->references('id')->on('contents')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class)->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_file');
        Schema::dropIfExists('content_viewed');
        Schema::dropIfExists('contents');
    }
};
