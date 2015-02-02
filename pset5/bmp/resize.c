/**
 * copy.c
 *
 * Computer Science 50
 * Problem Set 5
 *
 * Copies a BMP piece by piece, just because.
 */
       
#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>

#include "bmp.h"

int main(int argc, char* argv[])
{
    // ensure proper usage
    if (argc != 4)
    {
        printf("Usage: ./resize n infile outfile\n");
        return 1;
    }
    int n = atoi(argv[1]);
    if (isdigit(n), n < 1 || n > 100)
    {
        printf("Usage: between 1 and 100");
    }

    // remember filenames
    char* infile = argv[2];
    char* outfile = argv[3];

    // open input file 
    FILE* inptr = fopen(infile, "r");
    if (inptr == NULL)
    {
        printf("Could not open %s.\n", infile);
        return 2;
    }

    // open output file
    FILE* outptr = fopen(outfile, "w+");
    if (outptr == NULL)
    {
        fclose(inptr);
        fprintf(stderr, "Could not create %s.\n", outfile);
        return 3;
    }

    // read infile's BITMAPFILEHEADER
    BITMAPFILEHEADER bf;
    fread(&bf, sizeof(BITMAPFILEHEADER), 1, inptr);

    // read infile's BITMAPINFOHEADER
    BITMAPINFOHEADER bi;
    fread(&bi, sizeof(BITMAPINFOHEADER), 1, inptr);

    // ensure infile is (likely) a 24-bit uncompressed BMP 4.0
    if (bf.bfType != 0x4d42 || bf.bfOffBits != 54 || bi.biSize != 40 || 
        bi.biBitCount != 24 || bi.biCompression != 0)
    {
        fclose(outptr);
        fclose(inptr);
        fprintf(stderr, "Unsupported file format.\n");
        return 4;
    }
    
                
    // save original image height and width, padding, SizeImage
    int oldHeight = abs(bi.biHeight);
    int oldWidth = bi.biWidth;
    //int oldpadding = (4-(oldWidth*sizeof(RGBTRIPLE)) % 4) % 4;
    int oldSizeImage = bi.biSizeImage;

    if (n != 1)
    {
        // edit outfile's BITMAPINFOHEADER to account for resize
        bi.biWidth = bi.biWidth * n;  
        bi.biHeight = bi.biHeight * n; 
        bi.biSizeImage = abs(bi.biHeight) * bi.biWidth * sizeof(RGBTRIPLE);
        
        // edit outfile's BITMAPFILEHEADER to account for resize
        bf.bfSize = bf.bfSize - oldSizeImage + bi.biSizeImage;
    }
    
    // write outfile's BITMAPINFOHEADER
    fwrite(&bi, sizeof(BITMAPINFOHEADER), 1, outptr);

    // write outfile's BITMAPFILEHEADER
    fwrite(&bf, sizeof(BITMAPFILEHEADER), 1, outptr);  
    
    // determine padding for scanlines
    int padding =  (4 - (bi.biWidth * sizeof(RGBTRIPLE)) % 4) % 4;
    // remember a whole line
    RGBTRIPLE *line = malloc(sizeof (RGBTRIPLE) * bi.biWidth);
       
    // iterate over infile's scanlines
    for (int i = 0; i < oldHeight; i++)
    {
        int pixel = 0;
        // iterate over pixels in scanline
        for (int j = 0; j < oldWidth; j++)
        {
            // temporary storage
            RGBTRIPLE triple;
            
                // read RGB triple from infile
                fread(&triple, sizeof(RGBTRIPLE), 1, inptr);
                
                for (int k = 0; k < n; k++, pixel++)
                {
                    line[pixel] = triple; // repeat pixel n times
                }
                
                // skip over padding, if any
                fseek(inptr, padding, SEEK_CUR); 
                
        }
            
        for (int l = 0; l < n; l++) 
        { 
            // write RGB triple to outfile (same line * n)
            fwrite(line, sizeof(RGBTRIPLE), bi.biWidth, outptr);
            
            // add padding back to end of line
            for (int p = 0; p < padding; p++) 
            {
                fputc(0x00, outptr); 
            }
        }
    }
    free(line);
    // close outfile
    fclose(outptr);
    // close infile
    fclose(inptr);

    // that's all folks
    return 0;
}
