CREATE TABLE sensor_data (
    id MEDIUMINT AUTO_INCREMENT PRIMARY KEY,
    logdate DATETIME,
    temperature FLOAT,
    humidity FLOAT,
    pressure FLOAT,
    light FLOAT
);