<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
            
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('companyName',100);
                $table->string('password');
                $table->timestamp('email_verified_at')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->enum('type', [1, 2, 3, 4])->comment('1 for super admin 2 for admin 3 for client');
                $table->string('mobile', 15)->unique()->nullable();
                $table->string('profilePicture',191)->nullable();
                $table->string('state',10)->nullable();
                $table->string('district',10)->nullable();
                $table->string('address',50)->nullable();
                $table->string('industry',20)->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('users');
    }
};
