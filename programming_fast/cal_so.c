#include <stdio.h>

int cal(int num1, char c, int num2) {
	int output = 0;
	switch (c) { 
		case '+': 
			output = num1 + num2; 
			break;
		case '-': 
			output = num1 - num2; 
			break;
		case '*': 
			output = num1 * num2; 
			break;
		case '/': 
			output = num1 / num2; 
			break;
		default: 
			output = -1; 
	}	
	return output;
}
