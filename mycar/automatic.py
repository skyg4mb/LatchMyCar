#!/usr/bin/env python

import time
import RPi.GPIO as GPIO
import latch

def main():

    # tell the GPIO module that we want to use the 
    # chip's pin numbering scheme
    GPIO.setmode(GPIO.BCM)

    # setup pin 25 as an output
    GPIO.setup(25,GPIO.OUT)
    GPIO.setup(22,GPIO.OUT)
    GPIO.output(25,False)
    GPIO.output(22,False)

    while True:
	status = latchService()
	if status == "off":
		GPIO.output(25,False)
		GPIO.output(22,True)
	else: 
		GPIO.output(25,True)
		GPIO.output(22,False)
	time.sleep(2)

    GPIO.cleanup()

def latchService():
	
	AppId='NnGdta7i36dqdetqnqHq'
	Secret='zLQxecyQxuuAkkNBjNr98kFjdmQs6uu8kgQXVz8y'
	accountId='crQbALnDd8mii3mrKy7nymHH8EUPQdE4UX9M83qUEFN93MewKxcQwzJkJ38CzdpX'

	api = latch.Latch(AppId, Secret)

	response = api.status(accountId)
	responseData = response.get_data()
	status = response.get_data().get('operations').get(AppId).get('status')

	return status

if __name__=="__main__":
    main()

