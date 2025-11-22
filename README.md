<h1 align="left">To-do-list-api</h1>
<p>REST API для управления списком задач (To-Do List), реализованное на чистом PHP.</p>
-------------------------------------------------------------------------------------------------------
<h3 align="left">✅ Реализовано</h3>
<ul>
  <li>API с CRUD-операциями для задач</li>
  <li>Валидация входных данных</li>
  <li>Хранение данных в SQLite</li>
  <li>Http методы (Post, Get, Put, Delete)</li>
</ul>
 -------------------------------------------------------------------------------------------------------
 <h3 align="left">📦 Технологии</h3>
<ul>
  <li>Язык: PHP 7+</li>
  <li>База данных: SQLite (файл database/todo.db)</li>
  <li>Сервер: встроенный PHP-сервер (для разработки)</li>
</ul>
-------------------------------------------------------------------------------------------------------
<h3 align="left">🚀 Запустить проект</h3>
<ul>
  <p>1) В Powershell или bash: клонируйте репозиторий</p>
  <li>git clone git@github.com:VladimirKonstantinovich/To-do-list-api.git</li>
  <li>cd todo-api</li>
  <br>
  <p>2) Запустите сервер</p>
  <li>php -S localhost:8000</li>
   <br>
  <p>3) Проверить работу API</p>
  <li>
    curl -X POST http://localhost:8000/tasks -H "Content-Type: application/json" -d '{"title":"new task","description":"task description","status":"pending"}' (Создание задачи)
  </li>
  <li>
    curl -X GET http://localhost:8000/tasks (Просмотр списка задач)
  </li>
  <li>
    curl -X GET http://localhost:8000/tasks/1 (Просмотр задачи по id)
  </li>
  <li>curl -X PUT http://localhost:8000/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{"title":"Обновлённая задача","status":"completed"}' (Обновление задачи)
  </li>
  <li>
    curl -X DELETE http://localhost:8000/tasks/1 (Удаление задачи по id)
  </li>
  <li>
    curl -X POST http://localhost:8000/tasks -H "Content-Type: application/json" -d '{"status":"pending"}' (Проверка на title)
  </li>
  <li>
    curl -X POST http://localhost:8000/tasks -H "Content-Type: application/json" -d '{"title":"Задача","status":"invalid"}' (Проверка статуса)
  </li>
</ul>
<h3 align="left">Сбросить базу данных</h3>
<ul>
  <li>rm database/todo.db (Удаляем файл базы данных)</li>
  <li>php -S localhost:8000 (Перезапускаем сервер, таблица создастся заново и задача будет с id = 1)</li>
</ul>

<h3>Формат title, description и status</h3>
<ul>
  <li>
    "title": "Task title" - От 3х до 255 символов
  </li>
  <li>
    "description": "Task description" - Максимум до 1000 символов 
  </li>
  <li>
    "status": "pending" - Обязательно: pending, in_progress или completed
  </li>
</ul>
