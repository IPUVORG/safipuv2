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
        Schema::create('pastors', function (Blueprint $table) {
            $table->id();
            $table->integer('region_id');
            $table->integer('district_id');
            $table->integer('sector_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->string('name');
            $table->string('lastname');
            $table->integer('genre_id');
            $table->integer('nationality_id');
            $table->integer('cardNumber')->unique();
            $table->date('birthdate')->nullable();
            $table->string('placedate')->nullable();
            $table->integer('marital_id');
            $table->integer('blood_id');
            $table->integer('study_id');
            $table->string('school')->nullable();
            $table->date('baptismdate')->nullable();
            $table->string('baptizerman')->nullable();
            $table->string('phonehome')->nullable();
            $table->string('phonemovil')->nullable();
            $table->string('email')->unique();
            $table->string('addresspastor')->nullable();
            $table->integer('house_id');
            $table->boolean('ivss')->default(0)->nullable();
            $table->boolean('lph')->default(0)->nullable();
            $table->boolean('otherwork')->default(0)->nullable();
            $table->string('work')->nullable();
            $table->integer('rifNumber')->nullable()->unique();
            $table->date('startdate')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastors');
    }
};
