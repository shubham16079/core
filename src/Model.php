<?php

namespace App;
use Exception;
use PDO;

class Model
{
    protected string $table;
    protected string $limit;
    protected string $fields;
    protected string $orderBy;
    protected array $bindParams = [];
    protected array $whereConditions = [];

    /**
     * @throws Exception
     */
    public function getData()
    {
        $conn = Database::getConnection();
        $query = $this->setQuery();
        $prepareQuery = $conn->prepare($query);
        foreach ($this->bindParams as $index => $value) {
            $prepareQuery->bindValue($index + 1, $value);
        }

        $prepareQuery->execute();

        return $prepareQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function query($table)
    {
        $this->table = $table;

        return $this;
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

    public function limit(int $limit)
    {
        $this->limit = " LIMIT $limit";

        return $this;
    }

    public function fields(array $fields)
    {
        if (!is_array($fields)) {
            $this->fields = [$fields];
        }
        $this->fields = implode(',', $fields);

        return $this;
    }

    public function orderBy(string $column, string $orderType = 'ASC')
    {
        $this->orderBy = " ORDER BY $column $orderType";

        return $this;
    }

    public function where(string $column, string $operator, string $value)
    {
        $this->bindParams[] = $value;
        $this->whereConditions[] = " $column $operator ?";
        return $this;
    }

}
