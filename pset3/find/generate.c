/**
 * generate.c
 *
 * Computer Science 50
 * Problem Set 3
 *
 * Generates pseudorandom numbers in [0,LIMIT), one per line.
 *
 * Usage: generate n [s]
 *
 * where n is number of pseudorandom numbers to print
 * and s is an optional seed
 */
       
#include <cs50.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>

#define LIMIT 65536

int main(int argc, string argv[])
{
    // if there is not 2 or 3 commandline arguments print directions
    if (argc != 2 && argc != 3)
    {
        printf("Usage: ./generate n [s]\n");
        return 1;
    }

    // set n to the 2nd line argument and an integer
    int n = atoi(argv[1]);

    // 3rd argument is cast as a pos int and seeded into the random function
    // if there is no 3rd argument, then seed in the current time instead which always changes
    if (argc == 3)
    {
        srand((unsigned int) atoi(argv[2]));
    }
    else
    {
        srand((unsigned int) time(NULL));
    }

    // print every number on a new line
    for (int i = 0; i < n; i++)
    {
        printf("%i\n", rand() % LIMIT);
    }

    // that's all folks
    return 0;
}
