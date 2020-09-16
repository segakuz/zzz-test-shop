<?php

/**
 * Database class
 */
class Db
{
    private $dbh;

    /**
     * Creates PDO instance
     */
    public function __construct()
    {
        try
        {
            $this->dbh = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        }
        catch (PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * Gets PDO instance
     */
    private function getDbh()
    {
        return $this->dbh;
    }

    /**
     * Executes query
     */
    public function execute($query, array $params=null)
    {
        $pdo = $this->getDbh();
        if (is_null($params))
        {
            $stmt = $pdo->query($query);
            return $stmt->fetchAll();
        }
        $stmt = $pdo->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Gets all rows
     */
    public function getAll($query, array $params=null, $fetchStyle = PDO::FETCH_ASSOC)
    {
        $pdo = $this->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll($fetchStyle);
    }

    /**
     * Gets only one row
     */
    public function getOne($query, array $params=null)
    {
        $pdo = $this->getDbh();
        if (is_null($params))
        {
            $stmt = $pdo->query($query);
            $result = $stmt->fetch(PDO::FETCH_NUM);
            return $result[0];
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }
}
