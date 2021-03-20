<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBalanceView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW balances_view AS SELECT customer_id, SUM(amount) AS balance FROM (
            SELECT customer_id, SUM(amount) AS amount FROM deposits GROUP BY customer_id
            UNION ALL
            SELECT customer_id, -SUM(amount) AS amount FROM withdrawls GROUP BY customer_id
        ) AS derived
        GROUP BY customer_id ORDER BY customer_id");
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW balances_view");
    }
}
