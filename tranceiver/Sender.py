from time import *
from random import randint
from string import *
from socket import *
import Flight_pb2
import sys
import csv

host = "127.0.0.1"
port = 8000
udpSocket = socket(AF_INET, SOCK_DGRAM)


def SerializeString(record):
  Flight = Flight_pb2.Flight()
  randomFlightId = randint(1,15)
  Flight.flightId = randomFlightId
  Flight.altitude = randint(100,20000)
  Flight.speed = randint(100,400)
  Flight.angle = randint(0,360)
  Flight.sendTime = strftime("%Y-%m-%d %H:%M:%S", gmtime())
  Flight.latitude = float(record[0]) + ((7 - randomFlightId)*2)
  Flight.longitude = float(record[1]) + ((7 - randomFlightId)*2)
  return Flight.SerializeToString()


f = open("../../Mobile_activity.csv", "rb")
records = csv.reader(f)
for record in records:
	if record[0] == 'lat':
		continue
	udpSocket.sendto(SerializeString(record),(host, port))
	# sleep(2)
	# decoded = Flight_pb2.Flight()
	# decoded.ParseFromString(SerializeString(record))
	# print decoded