/* tcpserver.c */

#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <string.h>
#include <netdb.h>
#include<sys/sendfile.h>
#include<fcntl.h>
#include<sys/stat.h>
#include<sys/types.h>
#include<dirent.h>
#include<time.h>


int main()
{
	int flags1,flags2;
	char ch1,ch2;
	char temp1[400],temp2[400];
								char send[1024],hash[1024];
		int sersock=-1,clisock=-1;
		int sock, connected, bytes_recieved , true = 1;  
		char send_data [1024] , recv_data[1024];       
		struct sockaddr_in server_addr,client_addr;    
		int sin_size,sockval=1;
		struct stat file_stat;
		int sock1, bytes_recieved1;
		char send_data1[1024],recv_data1[1024];
		struct hostent *host1;
		struct sockaddr_in server_addr1;
		char size[256];
		printf("Enter the port no of socket you want to open ");
		scanf("%d",&sersock);
		pid_t pid;
		pid=fork();
		socklen_t socklen=sizeof(server_addr);
	if(pid==0)
	{
		if ((sock = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP)) == -1) {
			perror("Socket");
			exit(1);
		}
		setsockopt(sock,SOL_SOCKET,SO_REUSEADDR,&sockval,sizeof(int));
//		FILE *fp1;
//		fp1= fopen ("str","r");
//		fseek(fp1,0L,SEEK_END);
//		char size[256];//=ftell(fp1);
		//      printf("size:%d\n",size);
//		fseek(fp1, 0L, SEEK_SET);
//		fclose(fp1);
//		int fp=open("cold.mp3",O_RDONLY);
//		fstat(fp, &file_stat);
//		sprintf(size, "%d", file_stat.st_size);

		//      printf("\nTCPServer Waiting for client on port 5000");
		fflush(stdout);
		off_t off=0;


		server_addr.sin_family = AF_INET;         
		server_addr.sin_port = htons(sersock);     
		server_addr.sin_addr.s_addr = INADDR_ANY; 
		bzero(&(server_addr.sin_zero),8); 

		if (bind(sock, (struct sockaddr *)&server_addr, sizeof(struct sockaddr))
				== -1) {
			perror("Unable to bind");
			exit(1);
		}

/*		if (listen(sock, 5) == -1) {
			perror("Listen");
			exit(1);
		}*/
		int none=0;
//		flags1 = fcntl(sock, F_GETFL, 0);
//		fcntl(sock, F_SETFL, flags1 | O_NONBLOCK);
		while(1)
		{  

			sin_size = sizeof(struct sockaddr_in);

		//	connected = accept(sock, (struct sockaddr *)&client_addr,&sin_size);
			printf("\n I got a connection from (%s , %d)",
					inet_ntoa(client_addr.sin_addr),ntohs(client_addr.sin_port));

//			int l=send(connected,size,sizeof(size),0);
//			int r_data=file_stat.st_size;

/*			while(((l=sendfile(connected,fp ,&off, 1024))>0) && r_data>0)
			{
				fsync(fp);
				r_data-=l;
			}
			printf("l:%d\n",l);
			//      send(connected, "done",strlen("done"), 0);  
			close(connected);
			break;*/

			while (1)
			{
				printf("in parent\n");
				fflush(stdout);
			none=0;
				send_data[0]='\0';hash[0]='\0';
				//	strcpy(send_data,"hello i am");
	/*				gets(send_data);
					if (strcmp(send_data , "q") == 0 || strcmp(send_data , "Q") == 0)
					{
						write(connected,send_data,strlen(send_data));
				//	send(connected, send_data,strlen(send_data), 0); 
					close(connected);
					break;
					}

					else
						write(connected,send_data,strlen(send_data));
*/					
			//		send(connected, send_data,strlen(send_data), 0);  
					recv_data[0]='\0';
					bytes_recieved=recvfrom(sock,recv_data,1024,0,(struct sockaddr *)&server_addr,&socklen);
					//bytes_recieved = recv(connected,recv_data,1024,0);
		//			bytes_recieved = read(connected,recv_data,strlen(recv_data));

					recv_data[bytes_recieved] = '\0';
					printf("recv data:%s\n",recv_data);
					fflush(stdout);

					if (strcmp(recv_data , "q") == 0 || strcmp(recv_data , "Q") == 0)
					{
					close(sock);
					break;
					}

					else// if(recv_data[0]!='\0')
					{
						char *s2,*s3,*s4,*s5;
						char *s1=strtok(recv_data," ");
						if(s1!=NULL)
							s2=strtok(NULL," ");
						if(s2!=NULL)
							s3=strtok(NULL," ");
						if(s3!=NULL)
							s4=strtok(NULL," ");
						if(s4!=NULL)
							s5=strtok(NULL," ");
						
						char t1[50],min[50];
						strcpy(min,"Thu Apr  2 17:45:45 2013");
						fflush(stdout);
						send_data[0]='\0';
						if(strcmp(s1,"IndexGet")==0)
						{//printf("aaa\n");
						//	fflush(stdout);
							if(strcmp(s2,"LongList")==0)
							{     DIR *dir;
								printf("long\n");
								fflush(stdout);
								struct dirent *fil;
								struct tm *foo;
								struct stat mystat;
								dir=opendir(".");
								memset(send,0,1024);
								if(dir)
								{
									while((fil=readdir(dir))!=NULL)
									{
										strcat(send_data,fil->d_name);
										strcat(send_data," ");
										stat(fil->d_name,&mystat);
										strcat(send_data,ctime(&mystat.st_mtime));
										 strcat(send_data,"\n");
										 //	printf("sendinglong:%s\n",send);
									}
									closedir(dir);
								}
								//printf("send-send %s\n",send);
								//		strcpy(send_data,send);
								//printf("longsend:%s\n",send_data);
								//			printf("out of long\n");
								fflush(stdout);
							}
							else if(strcmp(s2,"ShortList")==0)
							{
								DIR *dir;
								fflush(stdout);
								struct dirent *fil;
								struct tm *foo;
								struct stat mystat;
								dir=opendir(".");
								memset(send,0,1024);
								char *s31=strtok(s3,"-");
										int day1=atoi(s31);
										char *s32=strtok(NULL,"-");
										int month1=atoi(s32);
										char *s33=strtok(NULL,"-");
										int date1=atoi(s33);
										char *s34=strtok(NULL,"-");
										time_t time1=atoi(s34);
										char *s35=strtok(NULL,"-");
										int year1=atoi(s35);
								char *s41=strtok(s4,"-");
										int day2=atoi(s41);
										char *s42=strtok(NULL,"-");
										int month2=atoi(s42);
										char *s43=strtok(NULL,"-");
										int date2=atoi(s43);
										char *s44=strtok(NULL,"-");
										time_t time2=atoi(s44);
										char *s45=strtok(NULL,"-");
										int year2=atoi(s45);


								if(dir)
								{   
									while((fil=readdir(dir))!=NULL)
									{   
										strcat(send_data,fil->d_name);
										strcat(send_data," ");
										stat(fil->d_name,&mystat);
										strcat(send_data,ctime(&mystat.st_mtime));
										foo = gmtime(&(mystat.st_mtime));
										int day=foo->tm_mday;
										int month=foo->tm_mon;
										int year=foo->tm_year;
										if(year2<year1)
										{continue;}
										else if(year1>year && year <year2)
										{
										strcat(send_data,fil->d_name);
										strcat(send_data," ");
										stat(fil->d_name,&mystat);
										strcat(send_data,ctime(&mystat.st_mtime));
											
											}
										else if(year1==year2)
										{
											if(month2<month1)
											{continue;}
											else if(month1>month && month<month2)
										{
										strcat(send_data,fil->d_name);
										strcat(send_data," ");
										stat(fil->d_name,&mystat);
										strcat(send_data,ctime(&mystat.st_mtime));
											
											
											}
											else if(month1==month2)
											{if(day2<day1)
												{continue;}
												else if(date1>day && day<date2)
										{
										strcat(send_data,fil->d_name);
										strcat(send_data," ");
										stat(fil->d_name,&mystat);
										strcat(send_data,ctime(&mystat.st_mtime));
										
										}
											}
										}

										strcat(send_data,"\n");
										//      printf("sendinglong:%s\n",send);
									}   
									closedir(dir);

								}
								fflush(stdout);
							}
							else if(strcmp(s2,"REGEX")==0)
							{
								strcpy(send,"ls ");
								strcat(send,s3);
								strcat(send," >out");
								system(send);
								send[0]='\0';
								FILE *fp4;
								fp4=fopen("out","r");
								while(fgets(send,sizeof(send),fp4) !=NULL)
								{
									strcat(send_data,send);
									strcat(send_data,"\n");
								}
								fclose(fp4);

								fflush(stdout);
							}
			//			printf("send data : %s\n",send_data);
						fflush(stdout);
						}
						else if(strcmp(s1,"FileHash")==0)
						{
							if(strcmp(s2,"Verify")==0)
							{
								FILE *fp5=fopen(s3,"rb");

								if (fp5 == NULL) {
									printf ("%s can't be opened.\n", s3);
									return 0;
								}
								strcpy(send,"md5sum ");
								strcat(send,s3);
								strcat(send," > out1");

								system(send);
								fclose (fp5);

								fp5=fopen("out1","r");
								while(fgets(send,sizeof(send),fp5) !=NULL)
								{strcat(send_data,send);
								}
								printf(" %s\n",s3);
								fclose(fp5);
								fflush(stdout);
							}

							if(strcmp(s2,"CheckAll")==0)
							{
								DIR *dir1;
								struct dirent *fil1;
								struct stat mystat1;
								dir1=opendir(".");
								memset(send,0,1024);
								FILE *fp6;
								//			FILE *fp7=fopen("check","w");
								if(dir1)
								{
									send_data[0]='\0';
									while((fil1=readdir(dir1))!=NULL)
									{   
										strcpy(send,"md5sum ");
										strcat(send,fil1->d_name);
										strcat(send," > out2");
										if(strcmp(fil1->d_name,".")!=0 && strcmp(fil1->d_name,"..")!=0)
										{system(send);
											//printf("send:%s hash for %s\n",send,fil1->d_name);
											send[0]='\0';
											fp6=fopen("out2","r");
											fgets(hash,sizeof(hash),fp6);
											strcat(send_data,hash);
											//		strcat(send_data," ");
											//		strcat(send_data,fil1->d_name);
											strcat(send_data," ");
											stat(fil1->d_name,&mystat1);
											strcat(send_data,ctime(&mystat1.st_mtime));
											strcat(send_data,"\n");
										}

									}
									send[0]='\0';
								}

							}
							//							printf("sending chk:%s\n",send_data);

						}


						else if((strcmp(s1,"FileDownload")==0) || strcmp(s1,"FileUpload-Allow")==0)
						{   
						char send_file[1024];
							printf("in download\n");
							int fp=open(s2,O_RDONLY);
						
							fstat(fp, &file_stat);
							sprintf(size, "%d", file_stat.st_size);
							//              write(connected,size,sizeof(size));
							strcat(size,"\n");
							strcat(size,s2);strcat(size,"\n");
							int l=sendto(sock,size,sizeof(size),0,(struct sockaddr *)&server_addr,sizeof(server_addr));
							//int l=write(connected,size,sizeof(size));
							int r_data=file_stat.st_size;
							struct stat mystat1;
							stat(s2,&mystat1);
							strcat(size,ctime(&mystat1.st_mtime));strcat(size,"\n");
							close(fp);
							strcpy(send,"md5sum ");
							strcat(send,s2);
							strcat(send," > out2");
							system(send);
							FILE *f=fopen("out2","r");
							FILE *fp1=fopen(s2,"r");
							fgets(hash,sizeof(hash),f);
							strcat(size,hash);
							strcpy(send_data,size);
							while(!feof(fp1))
							{
							l=fread(send_file,1,1024,fp1);
					//		printf("send file %s\n",send_file);
							sendto(sock,send_file,1024,0,(struct sockaddr *)&server_addr,sizeof(server_addr));
							//write(connected,send_file,1024);
							}
						/*	while(fread(send_file,1,1024,fp1)>0 && r_data>0);
							{
								l=write(connected,send_file,1024);
					//			fsync(fp);
								r_data-=l;
							}*/
							fclose(f);
							fclose(fp1);
							size[0]='\0';
							//printf("l:%d\n",l);
							//      send(connected, "done",strlen("done"), 0);  */

						}

					/*	else if(strcmp(s1,"FileUpload")==0)
						{
							printf("FileUpload-Allow or FileUpload-Deny?\n");
							//scanf("%s",send_data);
							//printf("allowed or not %s\n",send_data);
						*/	/*if(strcmp(send_data,"FileUpload-Deny")==0)
							{
								strcpy(send_data,"Denied");
							}
							else
							{
								strcpy(send_data,"Accepted");
							}
							printf("upload prblm:%s\n",send_data);*/
						/*	strcpy(send_data,"Permission Pending\n");
						}
						//      write(connected,send_data,sizeof(send_data));
						else if(strcmp(s1,"Sending")==0)
						{
							printf("receiving\n");
							FILE *fp1;
							bytes_recieved=recv(connected,hash,1024,0);
							char *size2=strtok(hash,"\n");
							int file_size =atoi(size2);
							int r_data=file_size;
							char *name=strtok(NULL,"\n");
							fp1=malloc(size2);
							fp1=fopen(name,"w");
							printf("size2:%s\n",size2);
							while((bytes_recieved=recv(connected,recv_data,sizeof(recv_data),0))>0 && (r_data>0))
							{
								//   printf("hello\n");
								fwrite(recv_data,sizeof(char),bytes_recieved,fp1);
								r_data-=bytes_recieved;
							}
								      printf("rec\n");
								      bytes_recieved=recv(connected,recv_data,sizeof(recv_data),0);
							printf("\n RECIEVED DATA server = %s\n" , recv_data);
							strcpy(send_data,"File Uploaded Succesfully\n");
							fclose(fp1);
							//                      recv_data1[bytes_recieved1] = '\0';
						}*/
						else{
						none=1;
						}











						fflush(stdout);
					}
					//printf("send_data:%s\n",send_data);
					FILE *fp7=fopen("check","w");
					fprintf(fp7,"%s",send_data);
					fclose(fp7);
					//			printf("abcdf\n");
					fflush(stdout);


					if (strcmp(send_data , "q") == 0 || strcmp(send_data , "Q") == 0)
					{   
					//	write(connected,send_data,sizeof(send_data));
						sendto(sock,send_data,sizeof(send_data),0,(struct sockaddr *)&server_addr,sizeof(server_addr));
						//      send(connected, send_data,strlen(send_data), 0); 
						close(sock);
						break;
					}   

					else if(none==0)
					{
/*					off_t off1=0;
						int fp8=open("check",O_RDONLY);
						fstat(fp8, &file_stat);
						sprintf(size, "%d", file_stat.st_size);
						printf("jagah:%s send_data:%s\n",size,send_data);
						int l=write(connected,size,sizeof(size));
						                      int r_data=file_stat.st_size;
								      close(fp8);
							//		printf("l:%d r_data:%d\n",l,r_data);
								
					                      while((l=write(connected,send_data,sizeof(send_data)))>0 && r_data>0)
									{
										printf("aaaa\n");
									fsync(fp8);
									r_data-=l;
									}
							      //close(fp8);
							    //  printf("bahar\n");
						//      send(connected, "done",strlen("done"), 0);  
					//	close(connected);
					//	break;
					
*/
printf("writtenserver:%s\n",send_data);
							//write(connected,send_data,sizeof(send_data));
						sendto(sock,send_data,sizeof(send_data),0,(struct sockaddr *)&server_addr,sizeof(server_addr));
						
					}

			}
		}      
		//close(fp);
//		fflush(stdout);


		close(sock);
	}
	else
	{
		printf("Enter the port no you want to connect to ");
		scanf("%d",&clisock);
		host1 = gethostbyname("127.0.0.1");

		if ((sock1 = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP)) == -1) {
			perror("Socket");
			exit(1);
		}

		server_addr1.sin_family = AF_INET;
		server_addr1.sin_port = htons(clisock);
		server_addr1.sin_addr = *((struct in_addr *)host1->h_addr);
		bzero(&(server_addr1.sin_zero),8);
/*		if (connect(sock1, (struct sockaddr *)&server_addr1,
					sizeof(struct sockaddr)) == -1) 
		{   
			perror("Connectify");
			exit(1);
		
		}*/
//		flags2 = fcntl(sock1, F_GETFL, 0);
//		fcntl(sock1, F_SETFL, flags2 | O_NONBLOCK);:
//		FILE *fp1;
//		fp1=fopen("colplaymp","w");
//		recv(sock1, size, sizeof(size), 0); 
//		int file_size =atoi(size);
//		int r_data=file_size;
//		printf("r_data:%d\n",r_data);
		FILE *fp1;
			char t[50];
			int socklen1;
		while(1)
		{
			printf("in child\n");
			fflush(stdout);
			recv_data1[0]='\0';
			send_data1[0]='\0';
			hash[0]='\0';
			t[0]='\0';
/*			while((bytes_recieved1=recv(sock1,recv_data1,sizeof(recv_data1),0))>0 && (r_data>0))
			{   
				//      printf("hello\n");
				fwrite(recv_data1,sizeof(char),bytes_recieved1,fp1);
				r_data-=bytes_recieved1;
			}   
			fflush(fp1);
			break;
*/

	/*			bytes_recieved1=recv(sock1,recv_data1,1024,0);
//				bytes_recieved1=read(sock1,recv_data1,strlen(recv_data1));
				recv_data1[bytes_recieved1] = '\0';
				if (strcmp(recv_data1 , "q") == 0 || strcmp(recv_data1 , "Q") == 0)
				{
				close(sock1);
				break;
				}

				else// if(recv_data1[0]!='\0')
				printf("\nRecieved data client= %s " , recv_data1);*/

			char temp3[1024];			
			send_data1[0]='\0';
			printf("\n Send data:\n");
			scanf("%s",temp2);
			printf("temp2:%s\n",temp2);
			while(strcmp(temp2,"done")!=0)
			{
				printf("sneding in loop:%s\n",send_data1);
				strcat(send_data1," ");
				strcat(send_data1,temp2);
				scanf("%s",temp2);
			}





			//strcpy(temp3,send_data1);
/*			if(strcmp(strtok(temp3," "),"FileUpload")==0)
			{
				printf("Grant permission?: ");
				send_data1[0]='\0';
				scanf("%s",temp2);
				while(strcmp(temp2,"done")!=0)
				{
		//		printf("sneding in loop:%s\n",send_data1);
				strcat(send_data1," ");
				strcat(send_data1,temp2);
				scanf("%s",temp2);
				}
			}
*/
				
			if (strcmp(send_data1 , "q") != 0 && strcmp(send_data1 , "Q") != 0)
			{//write(sock1,send_data1,strlen(send_data1));
				sendto(sock1,send_data1,strlen(send_data1),0,(struct sockaddr *)&server_addr1,sizeof(server_addr1));
				printf("written:%s\n",send_data1);}

			//				send(sock1,send_data1,strlen(send_data1), 0);
			else
			{
				//write(sock1,send_data1,strlen(send_data1));
				sendto(sock1,send_data1,strlen(send_data1),0,(struct sockaddr *)&server_addr1,sizeof(server_addr1));
				//send(sock1,send_data1,strlen(send_data1), 0);
				close(sock1);
				break;
			}
			socklen1=sizeof(server_addr1);
			strcpy(t,send_data1);
			if(strcmp(strtok(t," "),"FileUpload-Allow")==0 || strcmp(strtok(send_data1," "),"FileDownload")==0)
			{
				printf("downclinet\n");
				bytes_recieved1=recvfrom(sock1,hash,1024,0,(struct sockaddr *)&server_addr1,&socklen1);
				//bytes_recieved1=recv(sock1,hash,1024,0);
				char *size2=strtok(hash,"\n");
				int file_size =atoi(size2);
				int r_data=file_size;
				char *name=strtok(NULL,"\n");
				fp1=malloc(size2);
				fp1=fopen(name,"w");
				while((bytes_recieved1=recvfrom(sock1,recv_data1,sizeof(recv_data1),0,(struct sockaddr *)&server_addr1,&socklen1))>0 && (r_data>0))
				{   
					  // printf("hello\n");
					fwrite(recv_data1,sizeof(char),bytes_recieved1,fp1);
					//      printf("rec:%s\n",recv_data1);
					r_data-=bytes_recieved1;
				}   
				printf("File Recieved\n");
				fclose(fp1);
				recv_data1[bytes_recieved1] = '\0';
				bytes_recieved1=recvfrom(sock1,recv_data1,sizeof(recv_data1),0,(struct sockaddr *)&server_addr1,&socklen1);
			//	bytes_recieved1=recv(sock1,recv_data1,sizeof(recv_data1),0);
			}


//recv_data1[0]='\0';
else{
			bytes_recieved1=recvfrom(sock1,recv_data1,sizeof(recv_data1),0,(struct sockaddr *)&server_addr1,&socklen1);
			//bytes_recieved1=recv(sock1,recv_data1,sizeof(recv_data1),0);
}
/*if(strcmp(temp3,"FileUpload-Allow")==0)
strcpy(recv_data1,"Accepted");
else if(strcmp(temp3,"FileUpload-Deny")==0)
strcpy(recv_data1,"Denied");
*/
/*char *s1=strtok(temp3," ");
char *s2=strtok(NULL," ");
char size[256];
off_t off=0;
*/
/*			printf("mila:%d recv:%s\n",bytes_recieved,recv_data1);
			int r_data=atoi(recv_data1);
			printf("size:%d\n",r_data);
			recv_data1[0] = '\0';
	//		printf("truth:%d\n",((r_data>0) && (bytes_recieved1=recv(sock1,recv_data1,sizeof(recv_data1),0))>0));
			while((r_data>0) && (bytes_recieved1=recv(sock1,recv_data1,sizeof(recv_data1),0))>0)
			{   
				//      printf("hello\n");
			printf("\nRecieved data client= %s " , recv_data1);
				r_data-=bytes_recieved1;
		//	recv_data1[0]='\0';				
			printf("bytes_recv:%d r_data:%d\n",bytes_recieved1,r_data);
			recv_data1[bytes_recieved1] = '\0';
			}
			printf("how\n");


			                      bytes_recieved1=recv(sock1,recv_data1,1024,0);
			//                              bytes_recieved1=read(sock1,recv_data1,strlen(recv_data1));*/
//			recv_data1[bytes_recieved1] = '\0';
			if (strcmp(recv_data1 , "q") == 0 || strcmp(recv_data1 , "Q") == 0)
			{   
			close(sock1);
			break;
			}   
/*			else if(strcmp(recv_data1,"Accepted")==0)
{
        int l=write(sock1,"Sending",sizeof("Sending"));
        printf("sent sending\n");
	char send_file[1024];
        int fp=open(s2,O_RDONLY);
        fstat(fp, &file_stat);
        sprintf(size, "%d", file_stat.st_size);
        //              write(connected,size,sizeof(size));
        strcat(size,"\n");
        strcat(size,s2);strcat(size,"\n");
        l=write(sock1,size,sizeof(size));
        int r_data=file_stat.st_size;
        struct stat mystat1;
        stat(s2,&mystat1);
        strcat(size,ctime(&mystat1.st_mtime));strcat(size,"\n");
	close(fp);
	FILE *fp1=fopen(s2,"r");
        strcpy(send,"md5sum ");
        strcat(send,s2);
        strcat(send," > out2");
        system(send);
        FILE *f=fopen("out2","r");
        fgets(hash,sizeof(hash),f);
        strcat(size,hash);
        strcpy(send_data1,size);
	while(!feof(fp1))
	{
	l=fread(send_file,1,1024,fp1);
	write(sock1,send_file,1024);
	r_data-=l;
	}
	write(sock1,send_data1,1024);
*/	/*
        while(((l=sendfile(sock1,fp ,&off, 1024))>0) && r_data>0)
        {
                fsync(fp);
                r_data-=l;
        }*/
  /*      fclose(fp1);
        fclose(f);
        size[0]='\0';


}*/

			else// if(recv_data1[0]!='\0')
			printf("\nRecieved data client= %s " , recv_data1);


		}
			close(sock1);

	}
	return 0;
} 
