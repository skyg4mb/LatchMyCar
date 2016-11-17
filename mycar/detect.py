#!/usr/bin/env python

import time
import RPi.GPIO as GPIO
import latch
import requests
from requests.auth import HTTPDigestAuth
import json

def main():

    # tell the GPIO module that we want to use the 
    # chip's pin numbering scheme
    GPIO.setmode(GPIO.BCM)

    # setup pin 25 as an output
    GPIO.setup(4,GPIO.IN)
    GPIO.setup(22,GPIO.OUT)
    GPIO.output(22,True)

    while True:
        if GPIO.input(4):
             	# the button is being pressed, so turn on the green LED
             	# and turn off the red LED
		time.sleep(0.1)
        else:
		status = latchService()
		if status == "off":
			#GPIO.output(25,False)
			GPIO.output(22,True)
			print "Motor bloqueado por latch"
			time.sleep(3)
		elif status == "Cliente no registrado":
			print "\n"
		else: 
			print "Iniciando motor"
			GPIO.output(22,False)
			time.sleep(2)
			GPIO.output(22,True)
        time.sleep(0.1)

    GPIO.cleanup()

def latchService():
	
	AppId=''
	Secret=''
	accountId=getAccountId()

	if accountId=='Cliente no registrado':
		print 'Debe registrar primero el dispositivo en nuestra pagina web con el codigo 91654917396765864'
		return 'Cliente no registrado'
	else:
		api = latch.Latch(AppId, Secret)
		response = api.status(accountId)
		responseData = response.get_data()
		status = response.get_data().get('operations').get(AppId).get('status')
		return status

def getAccountId():
	url = 'http://107.170.113.246/carsec/v1/index.php/account/91654917396765864' #Serial para dispositivos de prueba
	response = requests.get(url)
	if(response.ok):
			jData = json.loads(response.content)
	try:
	  	return jData[0]['id']	
	except:
		return 'Cliente no registrado'

if __name__=="__main__":
    main()

