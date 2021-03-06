#include <string.h>
#include <stdint.h>
#include <cstdlib>
#include "parsing.h"
#include "cmdstructure.h"
#include "color_control.h"
#include "esp_init.h"
#include "usart.h"
#include "timers.h"
#include "blur.h"

char CmdDataArray[100];
uint8_t ArrI=0;

void ExecuteCommand() {
		Blur();
	}

void Usart_Parsing() {
	if(strcmp(CmdDataArray,"ready")==0 || strcmp(CmdDataArray,"OK")==0) {
		ESP_Init("init");
		USART1_SendChar(0x0A);
		}
	char *ipd="+IPD";
	if(memcmp(CmdDataArray, ipd, sizeof(4))==0) {
		char *colon=memchr(CmdDataArray, ':',12);
		char *p=strtok(colon+1, ",");
		LampCmdStructure.CmdStructArr[0]=atoi(p);
		for(uint8_t i=0;i<5;) {	
			p=strtok(NULL, ",");
			LampCmdStructure.CmdStructArr[++i]=atoi(p);	
			}
			ExecuteCommand();
	}
}

void Data_Received(char data) {	
	if(data==0x0A && CmdDataArray[ArrI-1]==0x0D) {//CR-LF(0x0D-0x0A)
		CmdDataArray[ArrI-1]=0;	
		Usart_Parsing();
		ArrI=0;
		CmdDataArray[0]=0;
		}	else {
		CmdDataArray[ArrI]=data;
		ArrI++;
		}
}
