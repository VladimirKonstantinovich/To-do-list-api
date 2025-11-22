<?php

class TaskController {
    private $taskModel;
    
    public function __construct($database) {
        $this->taskModel = new Task($database);
    }
    
    // Получить все задачи
    public function getAllTasks() {
        $tasks = $this->taskModel->getAllTasks();
        
        return [
            'success' => true,
            'data' => $tasks,
            'count' => count($tasks)
        ];
    }
    
    // Получить задачу по ID
    public function getTaskById($id) {
        $errors = Validation::validateTaskId($id);
        if (!empty($errors)) {
            http_response_code(400);
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors
            ];
        }
        
        $task = $this->taskModel->getTaskById($id);
        
        if (!$task) {
            http_response_code(404);
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }
        
        return [
            'success' => true,
            'data' => $task
        ];
    }
    
    // Создать задачу
    public function createTask($data) {
        $errors = Validation::validateTaskData($data);
        if (!empty($errors)) {
            http_response_code(400);
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors
            ];
        }
        
        try {
            $taskId = $this->taskModel->createTask($data);
            $newTask = $this->taskModel->getTaskById($taskId);
            
            http_response_code(201);
            return [
                'success' => true,
                'message' => 'Task created successfully',
                'data' => $newTask
            ];
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'success' => false,
                'message' => 'Error creating task: ' . $e->getMessage()
            ];
        }
    }
    
    // Обновить задачу
    public function updateTask($id, $data) {
        $errors = Validation::validateTaskId($id);
        if (!empty($errors)) {
            http_response_code(400);
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors
            ];
        }
        
        if (!$this->taskModel->exists($id)) {
            http_response_code(404);
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }
        
        $validationErrors = Validation::validateTaskData($data, true);
        if (!empty($validationErrors)) {
            http_response_code(400);
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validationErrors
            ];
        }
        
        try {
            $updated = $this->taskModel->updateTask($id, $data);
            
            if ($updated) {
                $updatedTask = $this->taskModel->getTaskById($id);
                
                return [
                    'success' => true,
                    'message' => 'Task updated successfully',
                    'data' => $updatedTask
                ];
            } else {
                http_response_code(500);
                return [
                    'success' => false,
                    'message' => 'Error updating task'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'success' => false,
                'message' => 'Error updating task: ' . $e->getMessage()
            ];
        }
    }
    
    // Удалить задачу
    public function deleteTask($id) {
        $errors = Validation::validateTaskId($id);
        if (!empty($errors)) {
            http_response_code(400);
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $errors
            ];
        }
        
        if (!$this->taskModel->exists($id)) {
            http_response_code(404);
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }
        
        try {
            $deleted = $this->taskModel->deleteTask($id);
            
            if ($deleted) {
                return [
                    'success' => true,
                    'message' => 'Task deleted successfully'
                ];
            } else {
                http_response_code(500);
                return [
                    'success' => false,
                    'message' => 'Error deleting task'
                ];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return [
                'success' => false,
                'message' => 'Error deleting task: ' . $e->getMessage()
            ];
        }
    }
}