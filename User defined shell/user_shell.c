#include<stdio.h> 
#include<unistd.h>
#include<stdlib.h>
#include<sys/types.h>
#include<errno.h>
#include<string.h>
#include <fcntl.h>
#include <signal.h>
#include <wait.h>
void sig_handler(int signum){
	if(signum == 2 || signum == 20){
	}
	signal(SIGINT, sig_handler);
	signal(SIGTSTP, sig_handler);
	return;
}

typedef struct pidall{
	char st[40];
	int id;
	int fb;
}pidall;
pidall arr[200];
int glob,fg=0;
void child_handler(int signum){
	int pid,k;
	pid = waitpid(WAIT_ANY, NULL, WNOHANG);
	for(k=0;k<glob;k++)
	{
	//	printf("hell\n");
	//	printf("%d\n",arr[k].id);
		if(arr[k].id==pid)
		{
			arr[k].fb=0;
			break;
		}
	}
	if(pid>0){
//		printf("%s %d exited normally\n",arr[k].st,pid);
	}
	signal(SIGCHLD, child_handler);
	return;
}
int main(int argc, char *argv[], char *envp[])
{
	signal(SIGINT,  sig_handler);
	signal(SIGTSTP, sig_handler);
	signal(SIGCHLD, child_handler);
	char c='\0';
	pid_t pid,pid1;
	char s[50],s2[50];
	s[0]='\0';
	s2[0]='\0';
	char *pch1,*pch2;
	char *user=getlogin();
	char *path=get_current_dir_name();
	char *p2,*p1,*p3,*p4;
	int b=100;
	p3=(char *)malloc(sizeof(char)*30);
	p2=(char*)malloc(sizeof(char)*30);
	p1=(char*)malloc(sizeof(char)*40);
	p4=(char*)malloc(sizeof(char)*40);
	p1[0]='\0';
	char *comm[50],*redi[50];
	char store[100][50];
	char hist[100][50];
	  char  *sPtr, *aPtr = NULL, *pipeComms[5], *cmdArgs[10];
	          int newPipe[2], oldPipe[2],pidname[2], pCount, aCount, status,buff1,buff2;
	 sPtr=(char *)malloc(sizeof(char)*100);
//	int id[100];
	char *na=(char *)malloc(sizeof(char)*50);
	int i=0,j,n=0,flag=0,in=0,counter=0,y=0,red=0,k=0;
	int inp,out;
	strcat(p1,path);
	char *dypath=(char *)malloc(sizeof(char)*50);
	printf("\n<%s@my_pc:~> ",user);
	while(c!=EOF) 
	{
		if(flag!=1)
		{
			c=getchar();
//			printf("c:%d\n",c);

		}
		if(c=='\n' || flag==1)
		{
//			printf("c1:%c\n",c);
	 		sPtr=(char *)malloc(sizeof(char)*100);
			strcpy(hist[n],s);
			strcpy(s2,s);
			strcpy(sPtr,s);
			pCount = -1;
			do {
				aPtr = strsep(&sPtr, "|");

				if(aPtr != NULL) {
					if(strlen(aPtr) > 0) {
						pipeComms[++pCount] = aPtr;
//						printf("p:%s\n",aPtr);
					}
				}
			} while(aPtr);
			cmdArgs[++pCount] = NULL;

			redi[red]=pch2;
			n++;
			pch1=strtok(s," 	");
			while(pch1!=NULL)
			{
				comm[counter]=pch1;
				counter++;
				pch1=strtok(NULL," 	");
			}
			comm[counter]=pch1;
			if(comm[0]!=NULL && strcmp(comm[0],"cd")==0)
			{
				in=1;
				int l;
				if(comm[1]==NULL)
					comm[1]="/home/saumya/padhai/os";
				l=chdir(comm[1]);
				path=get_current_dir_name();
				dypath=&path[strlen(p1)];
			}
			else if(comm[0]!=NULL && strcmp(comm[0],"pid")==0)
			{
				in=1;
				p2=NULL;
				p2=(char *)malloc(sizeof(char)*10);
				pid=fork();
				if(pid==0 && comm[1]==NULL)
				{
					p2=getppid();
					//			strcpy(hist[n],s);
					//			n++;
					printf("command name: ./a.out process id:%d\n",p2);
					exit(0);
				}
				else if(pid==0 && strcmp(comm[1],"all")==0)
				{
					//				strcpy(hist[n],s);
					//				n++;
					//	printf("lol:%d\n",k);
					for(j=0;j<glob;j++)
					{
					//	printf("lol\n");
						printf("command name:%s process id:%d\n",arr[j].st,arr[j].id);
					}
					exit(0);
				}
				else if(pid==0 && strcmp(comm[1],"current")==0)
				{
					for(j=0;j<glob;j++)
					{
						if(arr[j].fb==1)
						printf("command name:%s process id:%d\n",arr[j].st,arr[j].id);
					}
				}

				else wait(NULL);
			}
			else if(comm[0]!=NULL && comm[1]==NULL && strcmp(comm[0],"quit")==0)
			{
				in=1;
				while(strcmp(comm[0],"quit")==0)
					exit(0);
			}
			else if(comm[0]!=NULL && strstr(comm[0],"hist")!=NULL)
			{
				in=1;
				if(comm[1]!=NULL)
				{
					printf("Invalid command\n");
				}
				else
				{
				//	printf("pi:%c\n",pch1[0]);
				if(strcmp(comm[0],"hist")==0)
				{
					for(j=0;j<n;j++)
					{
						printf("%d.%s\n",j+1,hist[j]);
					}
					//				strcpy(hist[n],s);
					//				n++;
				}
				else if(strstr(comm[0],"!hist")!=NULL)
				{
					//					printf("hello\n");
					p4=&comm[0][5];
					b=atoi(p4);
					flag=1;
					strcpy(s,hist[b-1]);
					//				strcpy(hist[n],s);
					//				n++;
					counter=0;
					*comm=(char *)NULL;
					continue;
					//					printf("str:%s\n",s);
				}
				else
				{
					p4=&comm[0][4];
					b=atoi(p4);
					//				strcpy(hist[n],s);
					//					n++;
					for(j=n-b;j<n;j++)
						printf("%d.%s\n",j-(n-b)+1,hist[j]);
					//	printf("b:%d\n",b);
				}
				}

			}
			else if(comm[0]!=NULL && comm[1]!=NULL && strcmp(comm[1],"&")==0)
			{
				fg=1;
				in=1;
//				printf("fff\n");
				pid=fork();
				strcpy(p4,"/usr/bin/");
				strcat(p4,comm[0]);
//				printf("p4:%s\n",p4);
				if(pid==0)
				{
					execve(p4,argv,envp);
				}
				else
				{
					strcpy(arr[glob].st,comm[0]);
					arr[glob].id=pid;
					arr[glob].fb=1;
					glob++;
					printf("command name:%s process id:%d\n",comm[0],pid);
				}
				p4[0]='\0';
			}
			else// && strcmp(pch1,"ls")==0)
			{
				flag=1;
//				printf("else\n");
				in=1;
		//		pid=fork();
		//		if(pid==0)
		//		{
					for(i = 0; i < pCount; i++)
					{
						aCount = -1;

						do {
				//			printf("p2:%s i:%d\n",pipeComms[i],i);
							aPtr = strsep(&pipeComms[i], " ");
				//			printf("aptrit:%s\n",aPtr);
							if(aPtr!=NULL && strcmp(aPtr,"<")==0)
							{
//								pid=fork();
								aPtr = strsep(&pipeComms[i], " ");
//								printf("fin:%s\n",aPtr);
//								if(pid==0)
//								{
								fflush(stdin);
								buff1=dup(0);
					//			cmdArgs[++aCount]=aPtr;
								inp = open(aPtr, O_RDONLY);
								if(inp>0)
								{dup2(inp, STDIN_FILENO);
								close(inp);}
								else
								{
								//	printf("File not found\n<terminal>\n");
									break;
								}
//								}
//								else wait(NULL);
							}
							else if( aPtr!=NULL && strcmp(aPtr,">")==0)
							{
//								printf("output\n");
								aPtr = strsep(&pipeComms[i], " ");
//								printf("fout:%s\n",aPtr);
//								pid=fork();
//								if(pid==0)
//								{
								fflush(stdout);
								buff2=dup(1);
								out = open(aPtr,O_RDWR | O_TRUNC | O_CREAT,S_IRUSR | S_IRGRP | S_IWGRP | S_IWUSR);
								dup2(out, STDOUT_FILENO);
								close(out);
//								}
//								else wait(NULL);
							}


							else if (aPtr!=NULL){
								if(strlen(aPtr) > 0) {
									cmdArgs[++aCount] = aPtr;
				//					printf("aptr:%s\n",aPtr);
				//					printf("cmdargs[%d]:%s\n",aCount,cmdArgs[aCount]);
								}
							}
						} while(aPtr);
						cmdArgs[++aCount] = NULL;

						if(i < pCount-1) {
							pipe(newPipe);
						}
	//					pipe(pidname);	
						pid1 = fork();
						if(pid1 == 0) 
						{
							//							printf("cmd:%s\n",cmdArgs[0]);
							//							printf("in\n");
							if(i > 0) {
//								printf("i >0\n");
								close(oldPipe[1]);
								dup2(oldPipe[0], 0);
								close(oldPipe[0]);
							}

							if(i < pCount-1) {
//								printf("i<0\n");
								close(newPipe[0]);
								dup2(newPipe[1], 1);
								close(newPipe[1]);
							}
				//			printf("cmd:%s\n",cmdArgs[0]);
							int ex=execvp(cmdArgs[0], cmdArgs);
							if(ex==-1)
							{
								printf("Invalid command\n");
								exit(1);
							}
						} 
						else 
						{
							strcpy(arr[glob].st,cmdArgs[0]);
							arr[glob].id=pid1;
							arr[glob].fb=0;
							glob++;
				//			printf("pid:%d cmdarg:%s\n",arr[glob-1].id,arr[glob-1].st);
							if(i > 0) {
								close(oldPipe[0]);
								close(oldPipe[1]);
							}

							if(i < pCount-1) {
								oldPipe[0] = newPipe[0];
								oldPipe[1] = newPipe[1];
							}
					//		printf("pid of first child:%d\n",pid1);
							if(i == pCount-1) {
								wait(NULL);
							}

						}
						fflush(stdin);
						dup2(buff1,0);
						fflush(stdout);
						dup2(buff2,1);

					}

				in=1;
		//		exit(0);
		//		}
		//		else
		//		{	
		//			wait(NULL);
			//		close(pidname[1]);
		//			read(pidname[0],na,25);
		//			close(pidname[0]);
		//			printf("name:%s\n",na);
//					printf("main parent:%d\n",pid);
		//		}
				*comm=(char *)NULL;
				*redi=(char *)NULL;
				*pipeComms=(char *)NULL;
				*cmdArgs=(char *)NULL;
				counter=0;
				red=0;
			}
			counter=0;
			red=0;
				*pipeComms=(char *)NULL;
				*cmdArgs=(char *)NULL;
			*comm=(char *)NULL;
				*redi=(char *)NULL;
				s[0]='\0';
			s2[0]='\0';
			flag=0;
			in=0;
//			printf("c:%d\n",c);
			printf("<%s@my-pc:~%s>",user,dypath);
		}
		else
		{
			strncat(s,&c,1);
		}
	}
	printf("\n");
	return 0;
}
