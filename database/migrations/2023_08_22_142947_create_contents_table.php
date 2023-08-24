<?php

use App\Models\Course;
use App\Models\File;
use App\Models\User;
use App\Models\Content;
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
            $table->foreignIdFor(Course::class)->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(File::class, 'file_thumb_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(File::class, 'file_video_id')->nullable()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->text('description');
            $table->string('iframe')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contents_files', function (Blueprint $table) {
            $table->foreignIdFor(Content::class)->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(File::class)->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('contents_viewed', function (Blueprint $table) {
            $table->foreignIdFor(Content::class)->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class)->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents_files');
        Schema::dropIfExists('contents_viewed');
        Schema::dropIfExists('contents');
    }
};