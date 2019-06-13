#include <stdio.h>
#include <time.h>

int main(int argc, char *argv[], char *envp[])
{
  printf("argc %d\n",argc);
  printf("argv[0] %s\n",argv[0]);
  printf("argv[0][0] %c\n",argv[0][0]);
  printf("envp[0] %s\n",envp[0]);
  printf("envp[0][0] %c\n",envp[0][0]);
 
  /*
  printf("argv all\n"); 
  while(argc)
    printf("  %s\n",argv[--argc]);

  printf("envp all\n"); 
  for (char **env = envp; *env != 0; env++) {
    char *thisEnv = *env;
    printf("  %s\n", thisEnv);    
  }
  */

  time_t timer;
  char buffer[26];
  struct tm* tm_info;

  time(&timer);
  tm_info = localtime(&timer);

  strftime(buffer, 26, "%Y-%m-%d %H:%M:%S", tm_info);
  puts(buffer);

  return 0;
}
