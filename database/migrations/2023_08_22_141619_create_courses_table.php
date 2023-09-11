<?php

use App\Models\File;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(File::class, 'file_thumb_id')->references('id')->on('files')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(File::class, 'file_certificate_id')->references('id')->on('files')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
