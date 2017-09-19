USE `yeticave`;
# Добавление информации в БД: существующий список категорий
INSERT INTO categories(name)
VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');

# Добавление информации в БД: существующий список пользователей
INSERT INTO users
VALUES (0 , DATE_SUB(NOW(), INTERVAL '3 8' DAY_HOUR), 'ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', NULL, NULL),
       (0 , DATE_SUB(NOW(), INTERVAL 3 DAY), 'kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', NULL, NULL),
       (0 , DATE_SUB(NOW(), INTERVAL '2 18' DAY_HOUR), 'warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', NULL, NULL);

# Добавление информации в БД: список объявлений
INSERT INTO lots
VALUES (0, DATE_SUB(NOW(), INTERVAL '3 3:21' DAY_MINUTE), '2014 Rossignol District Snowboard', '---Описпние не предоставлено---', 'img/lot-1.jpg', 10999, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 500, NULL, 1, NULL, 1),
       (0, DATE_SUB(NOW(), INTERVAL '2 20:15' DAY_MINUTE), 'DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. 
       	Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим 
       	прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, 
       	крутая графика от Шона Кливера еще никого не оставляла равнодушным.', 'img/lot-2.jpg', 159999, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 5000, NULL, 2, NULL, 1),
       (0, DATE_SUB(NOW(), INTERVAL '2 13:48' DAY_MINUTE), 'Крепления Union Contact Pro 2015 года размер L/XL', '---Описпние не предоставлено---', 'img/lot-3.jpg', 8000, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 250, NULL, 3, NULL, 2),
       (0, DATE_SUB(NOW(), INTERVAL '2 6' DAY_HOUR), 'Ботинки для сноуборда DC Mutiny Charocal', '---Описпние не предоставлено---', 'img/lot-4.jpg', 10999, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 1000, NULL, 1, NULL, 3),
       (0, DATE_SUB(NOW(), INTERVAL 2 DAY), 'Куртка для сноуборда DC Mutiny Charocal', '---Описпние не предоставлено---', 'img/lot-5.jpg', 7500, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 250, NULL, 2, NULL, 4),
       (0, NOW(), 'Маска Oakley Canopy', '---Описпние не предоставлено---', 'img/lot-6.jpg', 5400, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 200, NULL, 3, NULL, 6);

# Добавление информации в БД: ставок для объявления
INSERT INTO bets
VALUES (0, DATE_SUB(NOW(), INTERVAL '1 3' DAY_HOUR), 7500, 5, 3),
       (0, DATE_SUB(NOW(), INTERVAL '3:43' HOUR_MINUTE), 7750, 5, 2),
       (0, DATE_SUB(NOW(), INTERVAL 27 MINUTE), 8000, 5, 1);

# Запросы для действий: получить список из всех категорий
SELECT name FROM categories;

# Запросы для действий: получить самые новые, открытые лоты
SET session sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
SELECT l.name, l.price_start, l.image, COALESCE(MAX(b.price), l.price_start) AS price, count(b.id) AS bet_count, c.name FROM lots AS l
LEFT JOIN bets AS b ON b.lot_id=l.id
JOIN categories AS c ON l.category_id=c.id
WHERE l.date_end > NOW()
GROUP BY l.id
ORDER BY l.id DESC;

# Запросы для действий: найти лот по его названию или описанию
SELECT * FROM lots
WHERE name LIKE '%something%' 
OR description LIKE '%something%';

# Запросы для действий: обновить название лота по его идентификатору
UPDATE lots
SET name='something'
WHERE id=7;

# Запросы для действий: получить список самых свежих ставок для лота по его идентификатору
SELECT * FROM bets
WHERE lot_id=5
ORDER BY id DESC;