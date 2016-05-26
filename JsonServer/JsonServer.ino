// Sample Arduino Json Web Server
// Created by Benoit Blanchon.
// Heavily inspired by "Web Server" from David A. Mellis and Tom Igoe

#include <SPI.h>
#include <Ethernet.h>
#include <ArduinoJson.h>

byte mac[] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xEA};
//IPAddress ip(10, 126, 12, 72);
IPAddress ip(192, 168, 1, 150);
EthernetServer server(80);

bool readRequest(EthernetClient& client) {
  bool currentLineIsBlank = true;
  while (client.connected()) {
    if (client.available()) {
      char c = client.read();
      if (c == '\n' && currentLineIsBlank) {
        return true;
      } else if (c == '\n') {
        currentLineIsBlank = true;
      } else if (c != '\r') {
        currentLineIsBlank = false;
      }
    }
  }
  return false;
}

JsonObject& prepareResponse(JsonBuffer& jsonBuffer) {
  JsonObject& root = jsonBuffer.createObject();

  JsonArray& analogValues1 = root.createNestedArray("cahaya");
    int reading;
    
    reading = analogRead(0);
    analogValues1.add(reading);
  

  JsonArray& analogValues2 = root.createNestedArray("suhu");
    float value;
    int reading2;
    
    reading2 = analogRead(1);
    float voltage = reading2 * 50.0;
    voltage /= 1024.0;
    value = ((voltage - 0.5) * 10);
    analogValues2.add(value);
  

  return root;
}

void writeResponse(EthernetClient& client, JsonObject& json) {
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: application/json");
  client.println("Connection: close");
  client.println();

  json.prettyPrintTo(client);
}

void setup() {
  Ethernet.begin(mac, ip);
  server.begin();
}

void loop() {
  EthernetClient client = server.available();
  if (client) {
    bool success = readRequest(client);
    if (success) {
      StaticJsonBuffer<500> jsonBuffer;
      JsonObject& json = prepareResponse(jsonBuffer);
      writeResponse(client, json);
    }
    delay(1);
    client.stop();
  }
}
