#include<stdio.h>
#include<string.h>
#include<cs50.h>
#include<stdlib.h>
#include<ctype.h>

/**
* Will encode a string with the vigenere cipher
* and print the result.
*/
int main(int argc, string argv[])
{

    // if the commandline arg don't equal 2
    string key = argv[1];
    if (argc != 2)
    {
        printf("Please enter the correct amount of commandline arguments!\n");
        return 1;
    }
    
    // check the key for non alphabet char
    for (int i = 0, n = strlen (key); i < n; i++)
    {
        if (isalpha (key[i]) == 0)
        {
            printf("Please enter a key that is alphebetic!\n");
            return 1;
        }
    }
    
    // get string from user
    printf("Please enter the phrase you wish to encrypt using the Vigenere Cypher:\n");
    string p = GetString();
    string c = p;
    
    // check each char in p one by one and decide to cypher or not
    for (int j = 0, k = 0, l = strlen (p), shiftp = 0, shiftk = 0;  j < l; j++)
    {
    
        // print everything else normally
        if (isalpha (p[j]) == 0)
            c[j] = p[j];
        
        else
        {
        
            // set shift for key and p
            if (isupper (p[j]))
                shiftp = 65;
            else
                shiftp = 97;
            if (isupper (key[k]))
                shiftk = 65;
            else
                shiftk= 97;
            
            //cypher alg
            c[j] = (p[j] - shiftp + key[k] - shiftk)%26 + shiftp;
            
            //after cypher, go to next letter in key, start over if done
            int m = strlen(key);
            k++;
            if (k == m)
                k = 0;
        }
        printf("%c", c[j]);
    }
    printf("\n");
}
