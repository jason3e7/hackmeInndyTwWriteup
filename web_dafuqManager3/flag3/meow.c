#include <stdio.h>
#include <sys/stat.h>
#include <sys/types.h>
#include <unistd.h>
#include <fcntl.h>

int main(int argc, char *argv[])
{
	const char *exec = argv[0];
	const char *flag = argv[1];
	char buffer[4096];

	if(argc < 2) {
		printf("Usage: %s flag\n", argv[0]);
		puts("We have cat to read file, And the meow to cat flag.");
		return 0;
	}

	struct stat S;
	if(stat(exec, &S) != 0) {
		printf("Can not stat file %s\n", exec);
		return 1;
	}

	uid_t uid = S.st_uid;
	gid_t gid = S.st_gid;

	setuid(uid);
	seteuid(uid);
	setgid(gid);
	setegid(gid);

	int fd = open(flag, O_RDONLY);
	if(fd == -1) {
		printf("Can not open file %s\n", flag);
		return 2;
	}
	ssize_t readed = read(fd, buffer, sizeof(buffer) - 1);
	if(readed > 0) {
		write(1, buffer, readed);
	}
	close(fd);
}
