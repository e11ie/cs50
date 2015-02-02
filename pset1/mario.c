#include <cs50.h>
#include <stdio.h>

int main(void)
{
    int height;

    do 
    {
        printf("What is the desired height?: ");
        height = GetInt();

        if (height > -1 && height < 24)
        {
           string a[height];
           int la;
            
            for (la = 0; la < height; la++)
             {
               a[la] = " ";
            }
           
            for (int line = 0; line < height; line++)
            {
                for (int i = 0; i < height; i++)
               {
                   a[height - (line + 1)] = "#";
        
                   printf("%s", a[i]);
                    
                 }
               printf("#\n");
            }
        }
        else
        {
            printf("This is not a valid heit.  Please try again or type 0 to quit.\n(HINT: try integers between 0 & 24)\n");
        }
    } while (height != 0);
  
}
