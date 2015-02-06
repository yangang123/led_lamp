#include <stm32l1xx.h>
	
void TIM6_Init()
{
	RCC->APB1ENR|=RCC_APB1ENR_TIM6EN;
	NVIC_EnableIRQ(TIM6_IRQn);
	//NVIC_SetPriority(TIM6_IRQn, 3);
	TIM6->CR1 |= TIM_CR1_ARPE;
	TIM6->CR1 &= ~TIM_CR1_UDIS;//UEV disable bit
	TIM6->DIER  |=TIM_DIER_UIE;//
	TIM6->ARR=1000;//1000-1sec.
	TIM6->PSC=16000-1;//16mHz
	//TIM6->CR1 |= TIM_CR1_CEN;
	TIM6->CR1 &= ~TIM_CR1_UDIS;//UEV disable bit
}
		
void TIM6_IRQHandler(void)
{
	TIM6->SR &= ~ TIM_SR_UIF;//clear update interrupt flag bit
	GPIOB->ODR ^= GPIO_ODR_ODR_6;
	
}

void Delay_sec(uint8_t z)
	{
		TIM6->ARR=z*1000;
		TIM6->EGR|=TIM_EGR_UG;
		TIM6->SR &= ~ TIM_SR_UIF;
		TIM6->CR1 |= TIM_CR1_OPM | TIM_CR1_CEN;
		while(!(TIM6->SR & TIM_SR_UIF));                          // Дождаться конца задержки
		TIM6->SR &= ~TIM_SR_UIF;      
			
		
	}
	