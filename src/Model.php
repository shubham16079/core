<?php

namespace App;

use App\Database;
use PDO;

class Model
{
    protected string $table;
    protected string $limit;
    protected string $fields;
    protected string $orderBy;
    protected array $bindParams = [];
    protected array $whereConditions = [];

    public function getData()
    {
        $database = new Database();
        $conn = $database->getConnection();
        if ($conn) {
            $query = $this->setQuery();
            $prepareQuery = $conn->prepare($query);
            foreach ($this->bindParams as $index => $value) {
                $prepareQuery->bindValue($index + 1, $value);
            }

            $prepareQuery->execute();
            return $prepareQuery->fetchAll(PDO::FETCH_ASSOC);


        } else {
            echo "database error";
        }
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    private function setQuery($columns = '*')
    {
        if (!empty($this->fields)) {
            $columns = $this->fields;
        }

        $query = "SELECT $columns FROM $this->table";
        if (!empty($this->whereConditions)) {
            $query .= " WHERE" . implode('AND', $this->whereConditions);
        }
        if (!empty($this->orderBy)) {
            $query .= $this->orderBy;
        }
        if (!empty($this->limit)) {
            $query .= $this->limit;
        }
        return $query;
    }

    public function limit(int $limit): void
    {
        $this->limit = " LIMIT $limit";
    }

    public function fields(array $fields)
    {
        if (!is_array($fields)) {
            $this->fields = [$fields];
        }
        $this->fields = implode(',', $fields);

    }

    public function orderBy(string $column, string $orderType = 'ASC')
    {
        return $this->orderBy = " ORDER BY $column $orderType";
    }

    public function where(string $column, string $operator, string $value)
    {
        $this->bindParams[] = $value;
        $this->whereConditions[] = " $column $operator ?";
        return $this;
    }

}
