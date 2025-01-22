<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Source\MediaFile\Domain\Enums\MediableTypeEnum;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media_files', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('original_name');
            $table->json('info')->nullable();
            $table->json('storage_info');
            $table->json('sizes');
            $table->string('mimetype');
            $table->enum('mediable_type', MediableTypeEnum::names());
            $table->uuid('mediable_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
