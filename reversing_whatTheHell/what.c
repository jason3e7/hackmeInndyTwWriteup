#include <stdio.h>

unsigned int num[10000000] = {0};

int what(int x) {
  if (x <= 1) 
    return num[x];
  if (num[x] == 0) 
    num[x] = what(x - 1) + what(x - 2);
  return num[x];
}

int main() {
  num[0] = 0;
  num[1] = 1;
  
  // 1063030705, 3210514353 not prime
  unsigned int a1[2] = {2136772529, 4284256177};
  unsigned int a2 = 1234567890;
  
  int i;
  for(i = 0; i <= 9999998; i++) {
    // overflow 
    //printf("%d %u\n", what(i), what(i));
    if(what(i) == a1[0]) {
      printf("hit 0!\n");
      printf("%d\n", i);
      printf("%u\n", a2 * i + 1);
      break;
    }
    if(what(i) == a1[1]) {
      printf("hit 1!\n");
      printf("%d\n", i);
      printf("%u\n", a2 * i + 1);
      break;
    }
  }
}

