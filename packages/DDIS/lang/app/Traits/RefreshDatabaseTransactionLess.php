<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 06/05/2019
 * Time: 01:07 PM
 */

namespace packages\DDIS\lang\app\Traits;


trait RefreshDatabaseTransactionLess
{
    /**
     * Begin a database transaction on the testing database.
     *
     * @return void
     */
    public function beginDatabaseTransaction()
    {
        // Nothing! This is on purpose! just skip me!
    }
}