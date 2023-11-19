CREATE TABLE restaurants (
    id INT AUTO_INCREMENT,
    name VARCHAR(128),
    address VARCHAR(128),
    type VARCHAR(128),
    phone VARCHAR(32),
    visited BOOLEAN,
    visited_date DATE,

    CONSTRAINT PK_restaurant PRIMARY KEY (id)
);

CREATE TABLE meals (
    id INT AUTO_INCREMENT,
    name VARCHAR(128),
    photo_path VARCHAR(128),
    calories FLOAT,
    proteins FLOAT,
    carbs FLOAT,
    fats FLOAT,
    fibers FLOAT,
    restaurant_id INT,

    CONSTRAINT FK_meal_restaurant 
        FOREIGN KEY (restaurant_id) REFERENCES restaurants(id),

    CONSTRAINT PK_Meal PRIMARY KEY (id)
);

CREATE TABLE eaten (
    id INT AUTO_INCREMENT,
    portion_size FLOAT,
    date_of_eat DATE,
    meal_id INT,

    CONSTRAINT FK_meal_eaten_meal 
        FOREIGN KEY (meal_id) REFERENCES meals(id),

    CONSTRAINT PK_eaten PRIMARY KEY (id)
);

-- INSERTS
INSERT INTO restaurants (name, address, type, phone, visited, visited_date) VALUES ('Restaurant 1', 'Address 1', 'Type 1', '+420111222333', true, '2019-01-01');
INSERT INTO restaurants (name, address, type, phone, visited, visited_date) VALUES ('Restaurant 2', 'Address 2', 'Type 2', '+420444555666', true, '2019-01-02');
INSERT INTO restaurants (name, address, type, phone, visited, visited_date) VALUES ('Restaurant 3', 'Address 3', 'Type 3', '+420777888999', true, '2019-01-03');

INSERT INTO meals (name, photo_path, calories, proteins, carbs, fats, fibers, restaurant_id) VALUES ('Meal 1', 'path1', 100, 10, 20, 30.1, 40, 1);
INSERT INTO meals (name, photo_path, calories, proteins, carbs, fats, fibers, restaurant_id) VALUES ('Meal 2', 'path2', 105, 15, 24, 31.5, 40, 1);
INSERT INTO meals (name, photo_path, calories, proteins, carbs, fats, fibers, restaurant_id) VALUES ('Meal 3', 'path3', 110, 10, 20, 30.8, 40, 1);

INSERT INTO eaten (portion_size, date_of_eat, meal_id) VALUES (100.5, '2019-01-01', 1);
INSERT INTO eaten (portion_size, date_of_eat, meal_id) VALUES (200.1, '2019-01-02', 2);
INSERT INTO eaten (portion_size, date_of_eat, meal_id) VALUES (201.5, '2019-01-03', 3);