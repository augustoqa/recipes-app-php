<?php

function query($database, $sql, $parameters = [])
{
	$stmt = $database->prepare($sql);
	$stmt->execute($parameters);

	return $stmt;
}

function total($database, $table)
{
	$stmt = query($database, "SELECT COUNT(*) AS `total` FROM `{$table}`");
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	return $row['total'];
}

function find($database, $table, $field, $value)
{
	$stmt = query(
		$database, 
		"SELECT * FROM `{$table}` WHERE `{$field}` = :field",
		[':field' => $value]
	);

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findAll($database, $table)
{
	$stmt = query($database, "SELECT * FROM `{$table}`");
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function save($database, $table, $primaryKey, array $values)		
{
	try {
		if (empty($values[$primaryKey])) {
			unset($values[$primaryKey]);
		}

		insert($database, $table, $values);
	} catch (PDOException $e) {
		update($database, $table, $primaryKey, $values);
	}
}

function insert($database, $table, array $values)
{
	$sql = sprintf("INSERT INTO `{$table}` SET %s", getSqlPlaceholder($values));

	query($database, $sql, getParameters($values));
}

function update($database, $table, $primaryKey, array $values)
{
	$sql = sprintf(
		"UPDATE `{$table}` SET %s WHERE `{$primaryKey}` = :primaryKey", 
		getSqlPlaceholder($values)
	);

    $parameters = getParameters($values);
    $parameters[':primaryKey'] = $values[$primaryKey];

	query($database, $sql, $parameters);
}

function delete($database, $table, $primaryKey, $id)
{
	query($database, "DELETE FROM `{$table}` WHERE `{$primaryKey}` = :primaryKey", [':primaryKey' => $id]);
}

function getSqlPlaceholder($values): string
{
	$sql = '';
	foreach (array_keys($values) as $field) {
		$sql .= "`${field}` = :${field},";
	}
	return rtrim($sql, ',');
}

function getParameters($values): array
{
	$parameters = [];
	foreach($values as $field => $value) {
		$parameters[":{$field}"] = $value;
	}

	return $parameters;
}