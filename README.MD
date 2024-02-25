# Задание 1
````
SELECT u.id,
CONCAT(u.first_name, ' ', u.last_name) AS full_name,
b.author,
GROUP_CONCAT(b.name SEPARATOR ', ') AS book_list
FROM users u
LEFT JOIN user_books ub ON u.id = ub.user_id
LEFT JOIN books b ON ub.book_id = b.id
WHERE (extract(YEAR FROM ub.get_date) - extract(YEAR FROM u.birthday)) BETWEEN 7 AND 17
AND DATEDIFF(ub.return_date, ub.get_date) <= 14
GROUP BY u.id, b.author
HAVING COUNT(b.id) = 2;
````
# Задание 2
Ход развертывания проекта
1. склонировать репозиторий
2. открыть проект в phpstorm или перейти в папку проекта в терминале
3. выполнить команду `composer install`
4. выполнить команду `docker compose up -d`
5. выполнить команду миграций `vendor/bin/doctrine-migrations migrate`
6. выполнить запрос из папки `test-request/auth.http` в phpstorm
или курлом из терминала, при этом на вашей системе должна быть установлена библиотека curl
````
curl --location 'localhost/api/v1/auth' \
   --header 'Content-Type: application/json' \
   --data '{
   "login": "someuser",
   "password" : "qwerty123"
   }'
````
должен прийти ответ в следующем формате:
````
{
    "status": "success",
    "code": 200,
    "data": {
        "auth_token": "HhGocXnAvFw2BN8xpTeKIELSJ0zlCf5DiOgQZr_saUy4MbY3-j1PWq9u67tdmVkR"
    }
}
````
в ответе копируем токен из поля data.auth_token

7. используем полученный токен для отправки запросов `convert.http` и `rates.http` в папке `test-request` если вы через phpstorm
или с помощью курла
````
curl --location --request POST 'localhost/api/v1?method=convert&from=USD&to=BTC&value=80000' \
--header 'Authorization: Bearer HhGocXnAvFw2BN8xpTeKIELSJ0zlCf5DiOgQZr_saUy4MbY3-j1PWq9u67tdmVkR'
````
````
curl --location 'localhost/api/v1?method=rates&currency=EUR' \
--header 'Authorization: Bearer HhGocXnAvFw2BN8xpTeKIELSJ0zlCf5DiOgQZr_saUy4MbY3-j1PWq9u67tdmVkR'
````
использован фреймворк slim, компоненты symfony и doctrine