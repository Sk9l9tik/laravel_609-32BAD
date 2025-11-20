<?php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToPastesTable extends Migration
{
    public function up()
    {
        Schema::table('pastes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('pastes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
}