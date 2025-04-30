<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('email');
            $table->string('surname')->nullable()->after('name');
            $table->string('department')->nullable()->after('surname');
            $table->string('staffNumber')->unique()->nullable()->after('department');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'surname', 'department', 'staffNumber']);
        });
    }
}
