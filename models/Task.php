<?php

class Task {
    private $pdo;
    
    public function __construct($database) {
        $this->pdo = $database->getConnection();
    }
    
    // Получить все задачи
    public function getAllTasks($limit = null, $offset = null) {
        $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $stmt = $this->pdo->prepare($sql);
        
        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            if ($offset !== null) {
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Получить задачу по ID
    public function getTaskById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Создать задачу
    public function createTask($data) {
        $sql = "INSERT INTO tasks (title, description, status) VALUES (:title, :description, :status)";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':status', $data['status']);
        
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
    
    // Обновить задачу
    public function updateTask($id, $data) {
        $sql = "UPDATE tasks SET title = :title, description = :description, status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // Удалить задачу
    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    // Проверить существует ли задача
    public function exists($id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}