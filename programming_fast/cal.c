#include <stdio.h>
#include <stdlib.h>

int main(int argc, char *argv[]) {
	/*
	int i;
	for(i = 0; i <= argc; i++) {
		printf("argv[%d]:%s\n", i, argv[i]);
	}
	*/
	int num1 = atoi(argv[1]);
	int num2 = atoi(argv[3]);
	char c = argv[2][0];
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
	//printf("%d\n", output);
	return output;
}
