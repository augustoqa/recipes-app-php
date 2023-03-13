<?php

namespace Ninja;

class DatabaseTable {
	private $pdo;
	private $table;
	private $primaryKey;

	public function __construct(\PDO $pdo, string $table, string $primaryKey = 'id')
	{
		$this->pdo = $pdo;
		$this->table = $table;
		$this->primaryKey = $primaryKey;
	}

	private function query($sql, $parameters = [])
	{
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($parameters);

		return $stmt;
	}

	public function total()
	{
		$stmt = $this->query("SELECT COUNT(*) AS `total` FROM `{$this->table}`");
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);

		return $row['total'];
	}

	public function find($field, $value)
	{
		$stmt = $this->query(
			"SELECT * FROM `{$this->table}` WHERE `{$field}` = :field",
			[':field' => $value]
		);

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function findAll()
	{
		$stmt = $this->query("SELECT * FROM `{$this->table}`");
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function save(array $record)		
	{
		try {
			if (empty($record[$this->primaryKey])) {
				unset($record[$this->primaryKey]);
			}

			$this->insert($record);
		} catch (\PDOException $e) {
			$this->update($record);
		}
	}

	private function insert(array $record)
	{
		$sql = sprintf("INSERT INTO `{$this->table}` SET %s", $this->getSqlPlaceholder($record));

		$this->query($sql, $this->getParameters($record));
	}

	private function update(array $record)
	{
		$sql = sprintf(
			"UPDATE `{$this->table}` SET %s WHERE `{$this->primaryKey}` = :primaryKey", 
			$this->getSqlPlaceholder($record)
		);

	    $parameters = $this->getParameters($record);
	    $parameters[':primaryKey'] = $record[$this->primaryKey];

		$this->query($sql, $parameters);
	}

	public function delete($id)
	{
		$this->query(
			"DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = :primaryKey", 
			[':primaryKey' => $id]
		);
	}

	private function getSqlPlaceholder($record): string
	{
		$sql = '';
		foreach (array_keys($record) as $field) {
			$sql .= "`${field}` = :${field},";
		}
		return rtrim($sql, ',');
	}

	private function getParameters($record): array
	{
		$parameters = [];
		foreach($record as $field => $value) {
			$parameters[":{$field}"] = $value;
		}

		return $parameters;
	}
}