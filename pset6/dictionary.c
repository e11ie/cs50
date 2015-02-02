/****************************************************************************
 * dictionary.c
 *
 * Computer Science 50
 * Problem Set 6
 *
 * Implements a dictionary's functionality.
 ***************************************************************************/

#include <stdbool.h>
#include <ctype.h>
#include <stdio.h>
#include <cs50.h>
#include <string.h>
#include <stdlib.h>

#include "dictionary.h"

#define LIMIT 27


    
// trie struct
typedef struct node
{
    bool is_word;
    struct node* slinky[LIMIT]; // one pointer for every alphabet letter and a possible apostrope
}
node;
// set index pointer to root
struct node* root = NULL;
 
struct node*  create_node()
{
    // make memory for pointer
    struct node* pointer = malloc(LIMIT * sizeof(node));
    if (pointer == NULL)
    {
        printf("Could not get node pointer array.\n");
    }
    // initialize pointer
    pointer->is_word = false;
    for (int i = 0; i < LIMIT; i++)
    {
        pointer->slinky[i] = NULL;  
    }
    return pointer;
}



 

//count every word in the dict    
int all_words = 0;
    
// function declarations    
int getArrayN(int t);
int isLast (node* dummy);
node* get_node(void);


/**
 * Returns true if word is in dictionary else false.
 */
bool check(const char* word)
{
    // only passed alphabet and/or apostrophes
    node* search = create_node();
    search = root;
    int i = 0;
    for (int index = 50;  word[i] != '\0'; i++)
    {
        index = getArrayN(word[i]);
        if(index != 50)
        {
            // if the pointer extist for the char, keep it
            if (search->slinky[index] != NULL)
            {
                //printf("\nfollowing index %d and char %c", index, c);
                search = search->slinky[index];
            }
            else if(search->slinky[index] == NULL)
            {
                //printf(" Ohno! ");
                return false;
            }
        }
        else
        {
            printf("\nindex error\n");
            return false;
        }
    }
    if (word[i] == '\0')
    {
        // check if end of word
        if (search->is_word == true)
        {
            return true;
        }
        else if (search->is_word == false)
        {
            return false;
        }
    }
    // catch errors
    printf("search error");
    return false;
}

int getArrayN(int t)
{
    if (t == '\'')
    {
        return (LIMIT - 1);
    }
    else if (isalpha(t) && isupper(t) == 0)
    {
        return (t - 'a');
    }
    else if (isalpha(t) && isupper(t) != 0) // case insensitive
    {
        return (t - 'A');
    }
    // else error
    return 50;
}

/**
 * Returns a node.  Returns NULL if not.
 */
node* get_node(void)
{
    // make memory for pointer
    struct node* pointer = malloc(LIMIT * sizeof(node));
    if (pointer == NULL)
    {
        printf("Could not get node pointer.\n");
    }
    // initialize pointer
    pointer->is_word = false;
    for (int i = 0; i < LIMIT; i++)
    {
        pointer->slinky[i] = NULL;  
    }
    return pointer;
}


/**
 * Loads dictionary into memory.  Returns true if successful else false.
 */
bool load(const char* dictionary)
{
    // TODO
    // open file
    
    FILE* d = malloc(sizeof(dictionary));
    d = fopen(dictionary, "r");
    if (d == NULL)
    {
        printf("Could not open %s.\n", dictionary);
        unload();
        return false;
    }
    
    //inititalize the trie node for the first time, set all the pointers to NULL
    
    // keep track of the path of the root arrows
    // use root first
    if (root == NULL)
    {
        root = create_node();
        
    }
    node* path = create_node();
    path = root;
    // only will be lower case letters and apostrophe
    // keep track of how many words there are
    int arrayN = 50;
    int c = fgetc(d);
    for (int word_length = 0; c != EOF; c = fgetc(d))
    {
        
        if (isalpha(c) || c == '\'')
        {
            // convert the char to the position in the array getArrayN(error is int 50)
            arrayN = getArrayN(c);
            if (arrayN == 50)
            {
                printf("Could not get array index");
            }
            // if the node for the letter does not exist, make it
            if(path->slinky[arrayN] == NULL)
            {
                path->slinky[arrayN] = create_node();
            }
            
            if(path->slinky[arrayN] != NULL)
            {
                //printf("\nValue of var[%d]\n", arrayN);
                //printf("%c", c);
            }
            // the letter and node exist
            path = path->slinky[arrayN];
        }
        else if (c == '\n')
        {
            // change the last path pointer slinky[]->is_word = true
            path->is_word = true;
            // changpath to root again to start the word over
            path = root;
            // count words in dictionary
            all_words++;
        }
        
        word_length++;
    }  
    if (c == EOF)
    {
        //printf("END LOAD: count of words is %d\n", all_words);
    }
    // check whether there was an error
    if (ferror(d))
    {
        fclose(d);
        printf("Error reading %s.\n", dictionary);
        unload();
        return false;
    }

    // close text
    fclose(d);
    
    
    return true;
}

/**
 * Returns number of words in dictionary if loaded else 0 if not yet loaded.
 */
unsigned int size(void)
{
    return all_words;
}

/**
 * Checks the node to see if it is the last in the trie tree.  
 * Returns 50 if error else if successful else returns the index of the next pointer.
 */
int isLast (node* dummy)
{
    int all_null = 0;
    for(int i = 0; i < LIMIT; i++)
    {
        if (dummy->slinky[i] == NULL)
        {
            all_null++;
        }
        else if (dummy->slinky[i] != NULL)
        {
            //printf("\n%c not null\n", (i + 'a'));
            return i;
        }
    }
    if (all_null == LIMIT && dummy->is_word == true)
    {
        //printf("This is the last node of this branch and last letter of a word\n");
        
        free(dummy);
        return 100;
    }
    //printf("error with isLast function?\n");
    return 50;
}

/**
 * Unloads dictionary from memory.  Returns true if successful else false.
 */
bool unload(void)
{
    // TODO
    node* path = create_node();
    // go through the root array of pointers
    
    for (int arraycount = 0; arraycount < LIMIT; arraycount++)
    {
        if (root->slinky[arraycount] != NULL)
        {
            // start the path
            path = root;
            // keep track of levels of the trie, if more than LENGTH, then abort
            for (int word_length = 0;  word_length < LENGTH; word_length++)
            {
                if (isLast(path) < 30)// meaning it returns an index #
                {
                    path = path->slinky[isLast(path)];
                }
                else if (isLast(path) > 30) // meaning all indexes are null
                {
                    free(path);
                }
            }
        }
            
    }
    //while(isLast(path) != 100 || isLast(path) != 50)
    
        // follow path
        //path = path->slinky[isLast(path)];
    
        //while(isLast(root) != NULL)
        
            //printf("...\n");
            
        // is the node is the last
        //if(path->is_word == true) free(path);
    if (isLast(root) == 100 || isLast(root) == 50)
    {
        printf("\nroot is free now\n");
        // free root last
        free(root);
        free(path);
        return true;
    }
    return false;
}
