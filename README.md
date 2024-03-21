# IoT Sensor Data Monitoring System

## Overview
This project implements an IoT sensor data monitoring system using Arduino and PHP. It collects temperature, humidity stores it in a MySQL database, and visualizes it using web-based charts.

## Components
### Arduino Sketch
The Arduino sketch collects sensor data using a DHT sensor and sends it to a remote server via HTTP POST requests. It requires the DHT library for sensor communication and WiFi connection to transmit data.

### PHP Scripts
The PHP scripts handle data storage in a MySQL database and generate charts to visualize the sensor data.
- `upload.php`: Inserts sensor readings into the database.
- `chart.php`: Retrieves data from the database and generates line charts using the Chart.js library.

## Setup
1. Upload the Arduino sketch to your ESP8266 or ESP32 device and configure the WiFi SSID and password.
2. Set up a MySQL database and import the provided SQL schema.
3. Configure the database connection parameters in `config.php`.
4. Deploy the PHP scripts to a web server with PHP support.
5. Access the `chart.php` script in a web browser to view real-time sensor data charts.

## Usage
- Ensure the Arduino device is connected to the sensor and powered on.
- Open a web browser and navigate to the `chart.php` URL to view the sensor data charts.


