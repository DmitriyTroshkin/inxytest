Привет. 

Это мое тестовое задание.

Чтобы установить, нужно настроить подключение к Postgresql в .env
Запустить миграции, запустить тесты.
Так же есть сидер который добавить в таблицу 30 пользователей для ручного теста.

соотвественно 3 ручки
(id пользователей это UUID)

Обновить данные пользователя - PUT http://example.com/api/users/{id}
{
    "name":"Update User",
    "email":"update@email.com",
    "age":20
}

Депозит - POST http://example.com/api/users/{id}/deposit
{
    "amount":"100.55"
}

Перевод между пользователями - POST http://example.com/api/users/transfer
{
    "from_user_id":"448f795d-1216-42cd-a149-ead4cd74bdae",
    "to_user_id":"e47cc56f-92fa-4fdc-8950-46d476fe160e",
    "amount":"300.25"
}