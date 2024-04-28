<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_login_at')->nullable()->index();
            $table->unsignedInteger('login_attempts')->nullable();
            $table->boolean('require_password_update')->default(false);
            $table->string('status')->index();
            $table->string('new_email')->index()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->string('address');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 14, 2)->unsigned();
            $table->unsignedInteger('stock');
            $table->boolean('on_sale')->default(false);
            $table->json('features');
            $table->dateTime('published_at');
            $table->timestamp('expire_at');
            $table->date('released_on');
            $table->time('sale_time');
            $table->enum('approval_status', ['draft', 'published']);
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->year('manufactured_year');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
