<?php

namespace APISModel\Model;

abstract class AbstractManager
{
    /**
     * @var \PDO
     */
    protected $db;

    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
}
