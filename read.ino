#include <Arduino.h>

// Include the credentials header file
#include "credentials.h"

#ifdef ESP32
  #include <WiFi.h>
  #include <HTTPClient.h>
#else
  #include <ESP8266WiFi.h>
  #include <ESP8266HTTPClient.h>
  #include <WiFiClient.h>
#endif

#include "DHT.h"

#define DHTTYPE           DHT11     /// DHT 11 
#define DHTPIN            4         /// Pin connected to the DHT sensor data pin
#define RETRY_LIMIT       20        /// Retry limit for DHT sensor readings
DHT dht(DHTPIN, DHTTYPE);

void setup() {
  // Initialize serial communication
  Serial.begin(115200);

  // Initialize DHT sensor
  dht.begin();

  // Connect to Wi-Fi using credentials from credentials.h
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");

  // Wait until connected to Wi-Fi
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  // Print local IP address
  Serial.println();
  Serial.println("WiFi connected");
  Serial.println("IP Address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  int retry_limit = RETRY_LIMIT;
  float humidity, temperature;

  // Read temperature and humidity from DHT sensor
  humidity = dht.readHumidity();
  temperature = dht.readTemperature();

  // Retry reading if values are NaN
  while (isnan(temperature) || isnan(humidity)) {
    Serial.println("Failed to read from DHT sensor!");
    humidity = dht.readHumidity();
    temperature = dht.readTemperature();
    delay(500);
    
    // Restart ESP if retry limit is reached
    if (--retry_limit < 1) {
      ESP.restart();
    }
  }

  // Open a connection to the server
  HTTPClient http;
  http.begin("https://andrespalomor.helioho.st/upload.php");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  // Format POST request with sensor data
  String post_data = "temperature=" + String(temperature) +
                     "&humidity=" + String(humidity) +
                     "&pressure=0.0&light=0.0";

  // Send POST request and check response
  int http_response_code = http.POST(post_data);
  if (http_response_code > 0) {
    // Print response from server
    String response = http.getString();
    Serial.print("HTTP Response code: ");
    Serial.println(http_response_code);
    Serial.println(response);
  } else {
    // Print error if POST request failed
    Serial.print("Error sending POST request! HTTP Response code: ");
    Serial.println(http_response_code);
  }

  // Close HTTP connection
  http.end();

  // Print sensor data
  Serial.print("Temperature: ");
  Serial.println(temperature);
  Serial.print("Humidity: ");
  Serial.println(humidity);

  // Wait for 2 minutes before next reading
  delay(120000);
}
