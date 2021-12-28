<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description')->nullable();
            $table->integer('author');
            $table->enum('tickets_limited', ['yes', 'no']);
            $table->enum('behalf_of_company', ['yes', 'no']);
            $table->integer('tickets_number')->nullable();
            $table->integer('ticket_price');
            $table->integer('category');
            $table->string('poster');
            $table->enum('receive_notif', ['yes', 'no'])->default('yes');
            $table->enum('published', ['yes', 'no']);
            $table->enum('can_see_visitors', ['Everyone', 'Event visitors', 'No body'])->default('Everyone');
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('begins_at');
            $table->string('location');
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
        Schema::dropIfExists('events');
    }
}
