/**
 * recover.c
 *
 * Computer Science 50
 * Problem Set 5
 * JESSIE
 *
 * Recovers JPEGs from a forensic image.
 */
 
#include <stdio.h>
#include <stdlib.h>
#include <string.h>


int main(int argc, char* argv[])
{
    // TODO
    
    // open raw data
    FILE* raw_data = fopen("card.raw", "r");
    if (raw_data == NULL)
    {
        printf("Could not open raw data.\n");
        return 2;
    }
    
    // look for JPEG signature
    // open file for new pick (named with sprintf
    // detect EOF
    
    // &data = 512 bytes, inptr = data
    // write 512 bytes until a new jpeg is found
    // 1 byte = 8 bits (0 or 1)
    // 2 hex digits (prefixed by 0x) is 1 byte)
    // 1 char = 1 byte
    
    //variables
    int i = 0;
    char title[10];
    char buffer[512];
    char header1[4] = {'\xff','\xd8','\xff','\xe0'};
    char header2[4] = {'\xff', '\xd8', '\xff', '\xe1'};
    FILE* img = NULL;
    
    
    while(1)
    {
        // read card data
        fread(&buffer, sizeof buffer, 1, raw_data);
    
        // check for EOF
        if (feof(raw_data))
        {
            printf ("EOF ");
            break;
        }
        
        // look for start of a JPEG
        if (strncmp (buffer,  header1, 4) == 0  || strncmp (buffer,  header2, 4) == 0 )
        {
            // check for open img
            if (img != NULL)
            {
                // close open img
                fclose(img);
            }
            
            // open new img
            sprintf (title,"%03d.jpg", i);
            img = fopen(title, "w");
                        
            // write to img
            fwrite( &buffer, sizeof buffer, 1, img);
            
            // next title
            i++;
        }
        else
        {
            if (img != NULL)
            {
                fwrite( &buffer, sizeof buffer, 1, img);
            }
        }
    }
    
    // close card data
    fclose(raw_data);

    // close recovered JPEG img
    fclose(img);
}
