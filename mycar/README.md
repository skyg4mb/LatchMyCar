### LATCH PYTHON SDK AND MYCAR APPLICATION. ###


#### PREREQUISITES ####

* Python.

* Read API documentation (https://latch.elevenpaths.com/www/developers/doc_api).

* To get the "Application ID" and "Secret", (fundamental values for integrating Latch in any application), it’s necessary to register a developer account in Latch's website: https://latch.elevenpaths.com. On the upper right side, click on "Developer area".

* Serial of dispositive MyCar.

#### CONFIGURATING MYCAR ####


* For configurate MyCar, edit Detect.py at the line secretid and appid with your latch application

```
	AppId
	Secret
	
	At the line URL url = 'http://107.170.113.246/carsec/v1/index.php/account/91654917396765864' Replace 91654917396765864 with the serial of your dispositive.
	
  ```

* Run detect.py
