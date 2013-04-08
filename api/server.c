#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <string.h>
#include <sys/types.h>
#include <time.h>

#include <dirent.h>
#include <sys/stat.h>
#include <string.h>


void listDir(char* dirname,int connectionFD)
{
    DIR *dirp;
    struct dirent *direntp;
    struct stat statbuff;
    char * dirStorage = calloc(1024,sizeof(char));
    
    dirp = opendir(dirname);
	
    while ( (direntp = readdir(dirp)) != NULL )
    {
        
        printf( "%s\n", direntp->d_name );
        strcat(dirStorage,direntp->d_name);
        strcat(dirStorage,"/");
        char pathname[1024];
        strcpy(pathname, dirname);
        strcat(pathname, "/");
        strcat(pathname, direntp->d_name);
        if (lstat(pathname, &statbuff) == -1)
        {
            perror("Failed to lstat");
		    
        }
    }
    
    printf("%s\n",dirStorage);
    write(connectionFD,dirStorage,strlen(dirStorage));
    free(dirStorage);
    closedir(dirp);
}

void GET(char* user,int connectionFD)
{
	//return the user
	
	//create the file dir
	
	char * fileName = calloc(strlen("./user/")+strlen(user)+strlen(user)+strlen("/.twitt"),sizeof(char));
	
	strcat(fileName,"./user/");
	strcat(fileName,user);
	strcat(fileName,"/");
	strcat(fileName,user);
	strcat(fileName,".twitt");
	
	printf("USER FILE NAME=>%s\n",fileName);
	//check if file exists in dir
	
	FILE * file = fopen(fileName,"r");
	fseek(file,0,SEEK_END);
	int fileSize = ftell(file);
	
	fseek(file,0,SEEK_SET);
	printf("File Size : %d\n\n",fileSize);
	char *content = malloc(fileSize);
	
	fread(content, fileSize,1, file);
	printf("USER FILE Content=>%s\n",content);
	write(connectionFD,content,strlen(content));
	fclose(file);
    
}

void CREATE(char* user,int connectionFD,char * content)
{
	char * fileName = calloc(strlen("./user/")+strlen(user)+strlen(user)+strlen("/.twitt"),sizeof(char));
	strcat(fileName,"./user/");
	strcat(fileName,user);
	
	printf("Checking Dir:%s\n\n",fileName);
	
	if(mkdir(fileName,S_IRGRP) != -1)
	{
		//mkdir(fileName);
		
		strcat(fileName,"/");
		strcat(fileName,user);
		strcat(fileName,".twitt");
		
		FILE * file;
		file = fopen(fileName,"w");
		fprintf(file,"%s",content);
		fclose(file);
		
		//free(fileName);
	}
	
	else
	{
		printf("Already Exists");
	}
}
void PUT(char* user,int connectionFD,char * content)
{
	char * fileName = calloc(strlen("./user/")+strlen(user)+strlen(user)+strlen("/.twitt"),sizeof(char));
	strcat(fileName,"./user/");strcat(fileName,user);strcat(fileName,"/");
	strcat(fileName,user);
	strcat(fileName,".twitt");
	printf("USER FILE NAME=>%s\n",fileName);
	printf("Writting=>%s\n",content);
	//check if file exists in dir
	
	FILE * file;
	file = fopen(fileName,"w");
	fprintf(file,"%s",content);
	fclose(file);
	
	//free(fileName);
}



void processBuffer(char* buffer, int connectionFD)
{
    
	
	//Command: GET POST PUT VIEW CREATE
    // char * api_get = "GET";
    
    
    char * method;
    char * user;
    //char * usr_content;
    
    char * result;
    
    result = strtok(buffer,"/");
    
    method = result;
    
    result = strtok(NULL,"/");
    user = result;
    
    
    
    printf("USER NAME=>%s\n",user);
    printf("SERVER=>%s\n",method);
    
    
    
    //method GET username returns a user.
    if(strcmp(method,"GET")==0)
    {
	  	GET(result,connectionFD);
    }
    if(strcmp(method,"VIEW")==0)
    {
    	char * userDir = "user/";
    	listDir(userDir,connectionFD);
    	
    }
    if(strcmp(method,"PUT")==0)
    {
	  	
	  	result = strtok(NULL,"/");
	  	printf("RESULT = >%s\n\n",result);
	  	
	  	char * usr_content = calloc(strlen(result)+4,sizeof(char));
	  	bzero(usr_content, strlen(result)+4);
	  	strcpy(usr_content, result);
	  	//usr_content = result;
	  	printf("Contntent=>%s\n",usr_content);
	  	
	  	PUT(user,connectionFD,usr_content);
    }
    //method CREATE username if the user dosent exist makes an instance of a user
    
    if(strcmp(method,"CREATE")==0)
    {
        
	  	result = strtok(NULL,"/");
	  	printf("RESULT = >%s\n\n",result);
	  	
	  	char * usr_content = calloc(strlen(result)+4,sizeof(char));
	  	bzero(usr_content, strlen(result)+4);
	  	strcpy(usr_content, result);
	  	//usr_content = result;
	  	printf("Contntent=>%s\n",usr_content);
	  	
	  	CREATE(user,connectionFD,usr_content);
	  	
    }
    
    //DELETE username removes and
    
}

int main(int argc, char * argv[])
{
	int listenFD =0;
	int connectionFD = 0;
	struct sockaddr_in serv_addr;
    
	char buffer[40240];
	
	
    
	listenFD = socket(AF_INET, SOCK_STREAM, 0);
	memset(&serv_addr, '\0', sizeof(serv_addr));
	memset(buffer, '\0', sizeof(buffer));
    
	serv_addr.sin_family = AF_INET;
    serv_addr.sin_addr.s_addr = htonl(INADDR_ANY);
    serv_addr.sin_port = htons(3000);
    
    bind(listenFD, (struct sockaddr*)&serv_addr, sizeof(serv_addr));
    listen(listenFD,10);
    
    puts("Starting Server");
    
    while(1)
    {
        
    	bzero(buffer,40240);
    	connectionFD = accept(listenFD,(struct sockaddr*)NULL, NULL);
    	read(connectionFD,&buffer,40240);
    	
        
        
        /* Write a response to the client */
        processBuffer(buffer,connectionFD);
        // write(connectionFD,buffer,strlen(buffer));
        
    	//printf("%s\n",buffer);
    	close(connectionFD);
    	sleep(1);
    }
}
