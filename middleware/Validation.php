<?php

class Validation {
    
    public static function validateTaskData($data, $isUpdate = false) {
        $errors = [];
        
        // Валидация заголовка
        if (!$isUpdate || isset($data['title'])) {
            if (empty($data['title'])) {
                $errors[] = 'Title is required';
            } elseif (strlen(trim($data['title'])) < 3) {
                $errors[] = 'Title must be at least 3 characters long';
            } elseif (strlen(trim($data['title'])) > 255) {
                $errors[] = 'Title must not exceed 255 characters';
            }
        }
        
        // Валидация описания
        if (isset($data['description']) && !empty($data['description']) && strlen($data['description']) > 1000) {
            $errors[] = 'Description must not exceed 1000 characters';
        }
        
        // Валидация статуса
        if (!$isUpdate || isset($data['status'])) {
            $allowedStatuses = ['pending', 'in_progress', 'completed'];
            if (!isset($data['status']) || !in_array($data['status'], $allowedStatuses)) {
                $errors[] = 'Status must be one of: pending, in_progress, completed';
            }
        }
        
        return $errors;
    }
    
    public static function validateTaskId($id) {
        if (!is_numeric($id) || $id <= 0) {
            return ['Invalid task ID'];
        }
        return [];
    }
}