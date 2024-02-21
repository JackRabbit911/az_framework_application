<?php

namespace App\Model;

use Sys\Model\Trait\QueryBuilder;
use Sys\Model\Trait\Schema;

final class ModelHome 
{
    use QueryBuilder;
    use Schema;
    
    public function dbExits(?string $dbname = null)
    {
        $dbname = (($dbname)) ?: env('connect.mysql.database');
        $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'";
        return ($this->qb->query($sql)->first()) ? true : false;
    }
}
