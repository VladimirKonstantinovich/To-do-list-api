<?php

class Database {
    private $pdo;
    
    public function __construct() {
        $databasePath = __DIR__ . '/../database/todo.db';
        
        // Создаем директорию для базы данных, если не существует
        if (!file_exists(dirname($databasePath))) {
            mkdir(dirname($databasePath), 0755, true);
        }
        
        $this->pdo = new PDO("sqlite:$databasePath");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        // Устанавливаем кодировку UTF-8
        $this->pdo->exec("PRAGMA encoding = 'UTF-8'");
        $this->pdo->exec("PRAGMA foreign_keys = ON");
        $this->pdo->exec("PRAGMA journal_mode = WAL");
        
        $this->createTables();
    }
    
    private function createTables() {
        $sql = "CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT,
            status TEXT DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        
        $this->pdo->exec($sql);
    }
    
    public function getConnection() {
        return $this->pdo;
    }
}