
import sys
import latch

def main():
	AppId=''; #En esta seccion se debe colocar el AppId
	Secret=''; #En esta seccion se debe colocar el SecretID
	api = latch.Latch(AppId, Secret)
	token = sys.argv[1];
   	response = api.pair(token);
   	accountId = response.get_data().get('accountId');
   	print accountId;
	
if __name__ == "__main__":
	main()
