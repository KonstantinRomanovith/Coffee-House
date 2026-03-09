CREATE DATABASE IF NOT EXISTS coffee_shop;
USE coffee_shop;

-- Таблица пользователей
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблица категорий
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

-- Таблица продуктов
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    full_description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    characteristics JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Таблица корзины
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Вставка категорий
INSERT INTO categories (name, description) VALUES
('Эспрессо', 'Классический итальянский эспрессо'),
('Фильтр-кофе', 'Мягкий и ароматный фильтр-кофе'),
('Кофе в зернах', 'Свежеобжаренные зерна для дома');

-- Вставка продуктов
INSERT INTO products (category_id, name, description, full_description, price, image, stock, characteristics) VALUES
(1, 'Эспрессо Италия', 'Насыщенный итальянский эспрессо', 'Классический итальянский эспрессо с богатым вкусом и плотной пенкой. Идеально для начала дня.', 250.00, 'espresso.jpg', 50, '{"Обжарка": "Темная", "Кислотность": "Низкая", "Тело": "Полное", "Аромат": "Шоколад, орехи"}'),
(1, 'Эспрессо Франция', 'Мягкий французский эспрессо', 'Французский эспрессо с мягким вкусом и легкой кислинкой. Отличный выбор для утреннего кофе.', 270.00, 'french-espresso.jpg', 35, '{"Обжарка": "Средняя", "Кислотность": "Средняя", "Тело": "Среднее", "Аромат": "Карамель, цветы"}'),
(2, 'Колумбия', 'Кофе из высокогорий Колумбии', 'Фильтр-кофе из колумбийских высокогорий с ярким вкусом и фруктовыми нотами.', 320.00, 'colombia.jpg', 25, '{"Обжарка": "Светлая", "Кислотность": "Высокая", "Тело": "Легкое", "Аромат": "Цитрус, ягоды"}'),
(2, 'Эфиопия', 'Африканский фильтр-кофе', 'Эфиопский фильтр-кофе с цветочным ароматом и ягодными нотками.', 350.00, 'ethiopia.jpg', 20, '{"Обжарка": "Светлая", "Кислотность": "Высокая", "Тело": "Легкое", "Аромат": "Жасмин, черника"}'),
(3, 'Бразилия', 'Зерна из Бразилии', 'Бразильские кофейные зерна средней обжарки с шоколадным вкусом.', 400.00, 'brazil.jpg', 30, '{"Обжарка": "Средняя", "Кислотность": "Средняя", "Тело": "Среднее", "Аромат": "Шоколад, орехи"}'),
(3, 'Гватемала', 'Гватемальские зерна', 'Гватемальские зерна с ярким вкусом и специями.', 380.00, 'guatemala.jpg', 28, '{"Обжарка": "Средняя", "Кислотность": "Средняя", "Тело": "Полное", "Аромат": "Шоколад, специи"}');