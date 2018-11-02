
from peewee import *
import Flight_pb2
from socket import *

db = MySQLDatabase('FlightTracker', user='root', passwd='1717')

host = "127.0.0.1"
port = 8000
udpSocket = socket(AF_INET, SOCK_DGRAM)
udpSocket.bind(("", port))

class FlightLog(Model):
    flightId = IntegerField(db_column='flightId')
    altitude = IntegerField(db_column='altitude')
    speed = IntegerField(db_column='speed')
    angle = DoubleField(db_column='angle')
    sendTime = DateTimeField(db_column='sendTime')
    longitude = DoubleField(db_column='longitude')
    latitude = DoubleField(db_column='latitude')
    class Meta:
        database = db 
        table_name = 'flight_logs' 

def PraseToObject(data):
	flightLog = Flight_pb2.Flight()
	flightLog.ParseFromString(data)
	return flightLog


def insertToDB(flightLog):
	FlightLog.create(flightId=flightLog.flightId,altitude=flightLog.altitude,speed=flightLog.speed,angle=flightLog.angle,sendTime=flightLog.sendTime,longitude=flightLog.longitude,latitude=flightLog.latitude)


print "waiting on port:", port
while 1:
	try:
		data, addr = udpSocket.recvfrom(100)
		insertToDB(PraseToObject(data))
	except Exception,e:
		print 'Error : '+str(e)
		

