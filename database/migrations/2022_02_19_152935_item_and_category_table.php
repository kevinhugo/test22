<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemAndCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("item_variants");
        Schema::dropIfExists("item_sizes");
        Schema::dropIfExists("item_colors");
        Schema::dropIfExists("item_pictures");
        Schema::dropIfExists("items");
        Schema::dropIfExists("categories");
        
        Schema::create("categories", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();
            $table->string("name");
        });

        Schema::create("items", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();
            $table->string("name");
            $table->unsignedBigInteger("category_id")->nullable(true);
            $table->text("description")->nullable(true);

            $table->foreign("category_id")
            ->references("id")
            ->on("categories")
            ->onDelete("SET NULL");
        });
        
        Schema::create("item_pictures", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();
            $table->unsignedBigInteger("item_id");
            $table->string("link");

            $table->foreign("item_id")
            ->references("id")
            ->on("items")
            ->onDelete("CASCADE");
        });

        Schema::create("item_colors", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();
            $table->unsignedBigInteger("item_id");
            $table->string("color");
            
            $table->foreign("item_id")
            ->references("id")
            ->on("items")
            ->onDelete("CASCADE");
        });

        Schema::create("item_sizes", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();
            $table->unsignedBigInteger("item_id");
            $table->string("size");
            $table->double("price");
            
            $table->foreign("item_id")
            ->references("id")
            ->on("items")
            ->onDelete("CASCADE");
        });

        // Schema::create("item_variants", function (Blueprint $table) {
        //     $table->bigIncrements("id");
        //     $table->timestamps();
        //     $table->unsignedBigInteger("item_id");
        //     $table->unsignedBigInteger("item_size_id");
        //     $table->double("price");
            
        //     $table->foreign("item_id")
        //     ->references("id")
        //     ->on("items")
        //     ->onDelete("CASCADE");
        //     $table->foreign("item_size_id")
        //     ->references("id")
        //     ->on("items")
        //     ->onDelete("CASCADE");
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("item_variants");
        Schema::dropIfExists("item_sizes");
        Schema::dropIfExists("item_colors");
        Schema::dropIfExists("item_pictures");
        Schema::dropIfExists("items");
        Schema::dropIfExists("categories");
    }
}
