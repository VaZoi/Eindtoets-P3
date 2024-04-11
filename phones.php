<?php

class Phones
{
    private $dbh;
    private $phonestable = 'phones';
    public function __construct($dbh)
    {
        $this->dbh = $dbh;
    }
    public function getPhonestable() : array
    {
        return $this->dbh->run("SELECT * from $this->phonestable")->fetchAll();
    }

    public function addPhones($name, $brand, $model, $storage, $price) : int
    {
        $this->dbh->run("INSERT INTO $this->phonestable (name, brand, model, storage, price) VALUES (?, ?, ?, ?, ?)", [$name, $brand, $model, $storage, $price]);
        return $this->dbh->lastId();
    }

    public function editPhones($name, $brand, $model, $storage, $price, $phone_id) : PDOStatement 
    {
        return $this->dbh->run("UPDATE $this->phonestable SET name = ?, brand = ?, model = ?, storage = ?, price = ? WHERE phone_id = ?", [$name, $brand, $model, $storage, $price, $phone_id]);
    }

    public function deletePhones($phone_id) : int
    {
        return $this->dbh->run("DELETE FROM $this->phonestable where phone_id = $phone_id");
    }

    public function onePhone($phone_id) : array 
    {
        return $this->dbh->run("SELECT * from $this->phonestable where phone_id = $phone_id")->fetch();
    }
}
