<?php

declare(strict_types = 1);

namespace App;

abstract class Model
{
    protected static DB $db;
    protected static Config $config;
    protected string $filepath;

    public function __construct()
    {
        if (! isset(static::$config)) {
            static::$config = new Config($_ENV);
        }
        if (! isset(static::$db)) {
            static::$db = new DB(static::$config->db);
        }
        if (! empty($_FILES)) {
            $this->filepath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];
            move_uploaded_file($_FILES['receipt']['tmp_name'], $this->filepath);
        }

    }

    protected static function db(): DB {
        return static::$db;
    }

    public function insert(array $invoices_array) {

        static::$db->beginTransaction();
        try {
            for ($i = 0; $i < count($invoices_array); $i++) {
                $stmt = static::$db->prepare(
                    'INSERT INTO invoices (`Date`, `Check`, `Description`, `Amount`)
                    VALUES (:Date, :Check, :Description, :Amount)'
                ); 
                $stmt->execute($invoices_array[$i]);   
            }
            static::$db->commit();
        } catch(\Throwable $e) {
            if (static::$db->inTransaction()) {
                static::$db->rollBack();
            }
            throw new \Exception('Insertion failed: ' . $e->getMessage());
        }
    }

    public function get():array {
        static::$db->beginTransaction();

        try {
            $stmt = static::$db->prepare(
                'SELECT * FROM invoices'
            );
    
            $stmt->execute();
    
            static::$db->commit();
        } catch(\Throwable $e) {
            if (static::$db->inTransaction()) {
                static::$db->rollBack();
            } else {
                throw new \Exception('Insertion failed');
            }
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFilePath() {
        return $this->filepath;
    }
}