<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateEnumStatusOnAuctionsTable extends Migration
{
    public function up()
    {
        DB::table('auctions')
            ->whereNotIn('status', ['open', 'closed', 'completed', 'pending'])
            ->update(['status' => 'pending']);

        DB::statement("ALTER TABLE auctions MODIFY COLUMN status ENUM('open', 'closed', 'completed', 'pending') NOT NULL");
    }

    public function down()
    {
        DB::table('auctions')
            ->whereNotIn('status', ['open', 'closed'])
            ->update(['status' => 'open']);

        DB::statement("ALTER TABLE auctions MODIFY COLUMN status ENUM('open', 'closed') NOT NULL");
    }
}