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
            $table->integer('tickets_number');
            $table->integer('ticket_price');
            $table->string('poster');
            $table->enum('receive_notif', ['yes', 'no'])->default('yes');
            $table->enum('published', ['yes', 'no']);
            $table->enum('can_see_visitors', ['Everyone', 'Event visitors', 'No body'])->default('Everyone');
            $table->string('publish_at')->nullable();
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
