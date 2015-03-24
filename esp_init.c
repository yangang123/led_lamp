#include <string.h>
#include <stdint.h>
#include "usart.h"
#include "timers.h"

uint8_t N=0;

void ESP_Init(char *cmd)
	{
		char *initstring1="AT+RST";
		char *initstring1_="";
		char *initstring2="AT+CWMODE=2";
	//	char *initstring3="AT+CWJAP=\"kaa\",\"19562876\" ";
		char *initstring3="AT+CWSAP=\"kaa\",\"19562876\",10,4";
		//char *initstring3="AT+CWJAP=\"East-home-apartment-2\",\"9418057015\" ";
		char *initstring4="AT+CIFSR";
		char *initstring5="AT+CIPMODE=0";
		char *initstring6="AT+CIPMUX=1";
		char *initstring7="AT+CIPSERVER=1,8888";	
		char *initstring8="AT+CIPSTO=1";
		char *initstring9="AT+CIPSTATUS";	
		char *ESP_Init_Array[]={initstring1, initstring1_, initstring2, initstring3, initstring4, initstring5, initstring6, initstring7, initstring8, initstring9};
		if(N>9)
			return;
		if (strcmp(cmd,"start"))
			{
			USART1_SendString(ESP_Init_Array[N]);
			N++;
			return;
			}
			if (strcmp(cmd,"init"))
				{
					Delay_msec(5);
				USART1_SendString(ESP_Init_Array[N]);
				N++;				
				}
		
	}
	



