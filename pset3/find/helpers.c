/**
 * helpers.c
 *
 * Computer Science 50
 * Problem Set 3
 *
 * Helper functions for Problem Set 3.
 */
       
#include <cs50.h>
#include <stdio.h>
#include <stdlib.h>

#include "helpers.h"

/**
 * Returns true if value is in array of n values, else false.
 */
bool search(int value, int values[], int n)
{
    // a binary searching algorithm
    
    // variables
    int lbound = 0;
    int hbound = n - 1; // bc n is the size!
    int index = (hbound - lbound)/2;
            
    while(lbound != hbound)
    {
        printf("Searching...\nvar: index = %i  lb = %i and hb = %i\n", index, lbound, hbound);
        if(values[index] == value)
        {
            // found it!
            return true;
        }
        if(values[index] > value) // search the lower half, change the higher bound accordingly
        {
            // check the lowest bound
            if (index == 0)
            {
                return false;
            }
            // change index and higher bound
            hbound = index;
            index = hbound - (hbound - lbound)/2 - 1; // make it dependent on the higher bound
            printf("var: index = %i  lb = %i and hb = %i\n", index, lbound, hbound);
        }
        else // search the higher half, change the lower bound accordingly
        {
            // check highest bound
            if (index == (n - 1))
            {
                return false;
            }
            // change index and lower bound
            lbound = index + 1;
            index = (hbound - lbound)/2 + lbound; // shift it higher
            printf("var: index = %i  lb = %i and hb = %i\n", index, lbound, hbound);
            
        }
    } 
    if(values[index] == value)
        {
            // found it!
            return true;
        }
    return false;
}

/**
 * Sorts array of n values.
 */
void sort(int values[], int n) // haystack, index of haystack
{
    // an O(n^2) sorting algorithm -- Selection Sort
    
    int holder = 0;
    for(int i = 0; i < n - 1; i++) // eliminate all numbers of haystack already sorted
    {
        for(int j = i + 1; j < n; j++) // compare the i index # with all the rest
        {
            //find the smallest value
            if(values[i] > values[j])  
            {
                holder = values[i];
                values[i] = values[j]; 
                values[j] = holder;
            }
        } 
    }
    
    return;
}
