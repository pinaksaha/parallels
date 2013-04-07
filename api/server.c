#include <stdio.h>
#include <sys/types.h> 
#include <sys/socket.h>
#include <netinet/in.h>
#include <string.h>
int main( int argc, char *argv[] )
{
    int sockfd, newsockfd, portno, clilen;
    char buffer[256];
    struct sockaddr_in serv_addr, cli_addr;
    int  n;

    /* First call to socket() function */
    sockfd = socket(AF_INET, SOCK_STREAM, 0);
    if (sockfd < 0) 
    {
        perror("ERROR opening socket");
        return 0;
    }
    /* Initialize socket structure */
    bzero((char *) &serv_addr, sizeof(serv_addr));
    portno = 3000;
    serv_addr.sin_family = AF_INET;
    serv_addr.sin_addr.s_addr = INADDR_ANY;
    serv_addr.sin_port = htons(portno);
 
    /* Now bind the host address using bind() call.*/
    if (bind(sockfd, (struct sockaddr *) &serv_addr,
                          sizeof(serv_addr)) < 0)
    {
         perror("ERROR on binding");
         return 0;
    }

    /* Now start listening for the clients, here process will
    * go in sleep mode and will wait for the incoming connection
    */
 
        listen(sockfd,5);
        clilen = sizeof(cli_addr);

        /* Accept actual connection from the client */
        newsockfd = accept(sockfd, (struct sockaddr *)&cli_addr, 
                                    &clilen);
        if (newsockfd < 0) 
        {
            perror("ERROR on accept");
            return 0;
        }
        /* If connection is established then start communicating */
        bzero(buffer,256);
        n = read( newsockfd,buffer,256);
        if (n < 0)
        {
            perror("ERROR reading from socket");
            return 0;
        }
        //printf("%s\n",buffer);

        int run = 3;
        char deliminator[] = " /";
        char * result = NULL;
        char * method;
        char *user;
        char *pass;
        result = strtok(buffer,deliminator);
        result = strtok(NULL,deliminator);
        method = result;
        result = strtok(NULL,deliminator);
        user = result;
        result = strtok(NULL,deliminator);
        pass = result;

        printf("Method:%s\n",method );
        printf("User:%s\n", user);
        printf("Password:%s\n", pass);
        /*
        while(run != 0)
        {
            printf("%s\n", result);
            result = strtok(NULL,deliminator);
            run--;
        }*/

       

        /* Write a response to the client */
        //n = write(newsockfd,"%s",50,buffer);

    return 0; 
}