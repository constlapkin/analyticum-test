# Тестовое задание от Analyticum

Нужно сделать рекурсивную цепочку комментариев с сохранением в БД.
 
Изначально должна быть форма отправки комментария, ниже неё выводится список отправленных. На каждый комментарий можно дать ответ, и так до бесконечности.
 
Верстка не важна, достаточно `textarea` для ввода текста и кнопки отправления, список комментариев ниже выводится в древовидном виде. Под каждым комментарием кнопка ответить, которая открывает textarea и кнопку отправления.
 
Обновление комментариев после добавления должно происходить средствами `ajax`.

## Решение

Задача выполненна на стеке PHP 7, MySQL.

Для инициализации базы данных и таблицы необходимо запустить: 

```PHP
$conn = Comments\DB();
$conn->initDB();
```

Представленное решение использует технологию Ajax (`js/ajax.js`), минимум верстки.
