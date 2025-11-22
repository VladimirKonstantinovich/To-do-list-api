<?php

// Удаляем все предыдущий вывод
ob_start();

// Устанавливаем заголовки для CORS и JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Обработка OPTIONS запроса (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config/database.php';
require_once 'models/Task.php';
require_once 'middleware/Validation.php';
require_once 'controllers/TaskController.php';

// Получаем данные из тела запроса
$input = json_decode(file_get_contents('php://input'), true);

// Получаем путь из REQUEST_URI и метод HTTP
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Инициализируем базу данных и контроллер
$database = new Database();
$taskController = new TaskController($database);

// Роутинг
try {
    if ($path === '/tasks' && $method === 'GET') {
        $response = $taskController->getAllTasks();
    } 
    elseif ($path === '/tasks' && $method === 'POST') {
        $response = $taskController->createTask($input);
    } 
    elseif (preg_match('/^\/tasks\/(\d+)$/', $path, $matches) && $method === 'GET') {
        $taskId = $matches[1];
        $response = $taskController->getTaskById($taskId);
    } 
    elseif (preg_match('/^\/tasks\/(\d+)$/', $path, $matches) && $method === 'PUT') {
        $taskId = $matches[1];
        $response = $taskController->updateTask($taskId, $input);
    } 
    elseif (preg_match('/^\/tasks\/(\d+)$/', $path, $matches) && $method === 'DELETE') {
        $taskId = $matches[1];
        $response = $taskController->deleteTask($taskId);
    } 
    else {
        http_response_code(404);
        $response = [
            'success' => false,
            'message' => 'Endpoint not found'
        ];
    }
} catch (Exception $e) {
    http_response_code(500);
    $response = [
        'success' => false,
        'message' => 'Internal server error: ' . $e->getMessage()
    ];
}

// Очищаем буфер вывода
ob_end_clean();

// Возвращаем JSON ответ
echo json_encode($response, JSON_UNESCAPED_UNICODE);