<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('image_id')->constrained()->onDelete('cascade');
            $table->foreignId('shared_with_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_images');
    }
}
