#include <stm32l1xx.h>
#include <stdint.h>
#include "color_control.h"
#include "timers.h"
#include "usart.h"
extern uint8_t *R_current, *R_received, *G_current, *G_received, *B_current, *B_received, *ChangeTime;
#include "color_control.h"
uint8_t DeltaR, DeltaG, DeltaB;

void Blur()
{
	if(*R_current<*R_received)
	DeltaR=(*R_received)-(*R_current);
	if(*R_current>*R_received)
	DeltaR=(*R_current)-(*R_received);
	
	if(*G_current<*G_received)
	DeltaG=(*G_received)-(*G_current);
	if(*G_current>*G_received)
	DeltaG=(*G_current)-(*G_received);
	
	if(*B_current<*B_received)
	DeltaB=(*B_received)-(*B_current);
	if(*B_current>*B_received)
	DeltaB=(*B_current)-(*B_received);

		//Y=(X^2)/256	
//Y=((X+15)^2)/256	
//Только 8 бит мало для нее, минимум 9 битный режим Шим нужен.
//Тогда по идее яркость должна стать визуально линейной.
//(соответственно делить надо на количество значений разрядности)
}

