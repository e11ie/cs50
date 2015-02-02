#include<cs50.h>
#include<stdio.h>
#include<string.h>
#include<ctype.h>
#include<stdlib.h>

/**
* Ceasar will code a string with a key (being an int number) and display it.
* Each letter will be the key number away from its original number.
* Caesar has 2 commandline arguments. The 2nd being the key.
*/
int main(int argc, string argv[])
{

    // if the command line agruments is not 2, error!
    if (argc != 2)
    {
        printf("Please enter the correct number of arguments in the command line./.\n");
        return 1;
    }
    int key = atoi (argv[1]);
    
    // if the value of k isn't positive or an integer
    if (isdigit(key), key <= 0)
    {
        printf("Please enter a positive integer for the caesar cipher!\n");
        return 1;
    }
    
    // get string from user
    printf("Please enter the phrase you wish to encrypt using the Caesar Cypher:\n");
    string p = GetString();
    string c = p;
    
    // check every char until end of string
    for (int i = 0, n = strlen(p), shift = 0;  i < n; i++)
    {
    
        // shift all letters by key keeping upper and lower the same
        if (isalpha(p[i]))
        {
            if (isupper(p[i]))
                shift = 65;
            if (islower(p[i]))
                shift = 97;
            c[i] = (p[i] - shift + key)%26 + shift;
        }
        
        // print everything else normally
        else
            c[i] = p[i];
        printf("%c", c[i]);
    }
    printf("\n");
}
