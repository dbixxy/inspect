<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserDatasToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nation_id')->nullable();
            $table->string('eng_license_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->text('photo')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_phone_number')->nullable();
            $table->text('company_address')->nullable();
            $table->text('company_logo')->nullable();
            $table->string('tax_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nation_id');
            $table->dropColumn('eng_license_id');
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropColumn('photo');
            $table->dropColumn('company_name');
            $table->dropColumn('company_phone_number');
            $table->dropColumn('company_address');
            $table->dropColumn('company_logo');
            $table->dropColumn('tax_id');
        });
    }
}
