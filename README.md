# To-do List API
REST API для управления списком задач (To-Do List), реализованное на чистом PHP.

---

### ✅ Реализовано

 - API с CRUD-операциями для задач
 - Валидация входных данных
 - Хранение данных в SQLite
 - Http методы (Post, Get, Put, Delete)

 ----
 
 ### 📦 Технологии

 - Язык: PHP 7+
 - База данных: SQLite (файл database/todo.db)
 - Сервер: встроенный PHP-сервер (для разработки)

---

### 🚀 Запустить проект

1. В Powershell или bash: клонируйте репозиторий:
   ```bash
   git clone git@github.com:VladimirKonstantinovich/To-do-list-api.git
   cd todo-api

2. Запустите сервер
   ```bash
   php -S localhost:8000

 ----
   
### Создание запросов

   1. Создание задачи
      ```bash
      curl -X POST http://localhost:8000/tasks -H "Content-Type: application/json" -d '{"title":"new task","description":"task description","status":"pending"}'

   2. Просмотр списка задач
      ```bash
      curl -X GET http://localhost:8000/tasks 

   3. Просмотр задачи по id
      ```bash
      curl -X GET http://localhost:8000/tasks/1 

   4. Обновление задачи
      ```bash
      curl -X PUT http://localhost:8000/tasks/1 \
      -H "Content-Type: application/json" \
      -d '{"title":"Обновлённая задача","status":"completed"}'

   5. Удаление задачи по id
      ```bash
      curl -X DELETE http://localhost:8000/tasks/1

   6. Проверка на title
      ```bash
      curl -X POST http://localhost:8000/tasks -H "Content-Type: application/json" -d '{"status":"pending"}'

   7. Проверка статуса
      ```bash
      curl -X POST http://localhost:8000/tasks -H "Content-Type: application/json" -d '{"title":"Задача","status":"invalid"}'

> " 💡  API возвращает ответы в формате JSON.  
> Если запрос неправильный — север установит HTTP-статус 400 Bad Request с описанием ошибки. "

--- 

### Сбросить базу данных:
- Удаляем файл базы данных
  ```bash
  rm database/todo.db
- Перезапускаем сервер (таблица создастся заново и задача будет с id = 1)
  ```bash
  php -S localhost:8000

---

### Формат данных:

| Поле | Обязательное | Формат  |
| :---         |     :---:      | :--- |
| title   | Да     |Строка от 3 до 255 символов    |
| description     | Нет         |Строка до 1000 символов      |
| status          |  Да         |pending, in_progress или completed |
