<?php

declare(strict_types=1);

use App\Models\PlaceCategory;
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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PlaceCategory::class, 'category_id')
                ->constrained('place_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->boolean('active')->default(false);
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->string('phone_number')->nullable();
            $table->string('opening_hours')->nullable();
            $table->string('instagram')->nullable();
            $table->string('yandex_maps')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
