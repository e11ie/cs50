#include<cs50.h>
#include<stdio.h>
#include<math.h>

int main(void)
{
    float money;
    int d;
    
    printf("This is a program to count how many coins (in quarters, dimes, nickes and penneys)\nare owed for a certain dollar value.  Type letters to exit this program.\n");
        while (true)
        {
            printf("How much change is owed: $");
            money = GetFloat();
                       
            if (money==0 || money>0)
            {
                money*=100;
                d = round(money);
                int i=0;
                
                for (int x=0; d>24; i++, x++)
                {
                    d-=25;
                }
                for (int x2=0; d>9; i++, x2++)
                {
                    d-=10;
                }
                for (int x3=0; d>4; i++, x3++)
                {
                    d-=5;
                }
                for (int x4=0; d>0; i++, x4++)
                {
                    d-=1;
                }
                printf("%i coins\n", i);
            }
           
            else
            {
                printf("This is nat a valid dollar number.  Please try again.\n");
            } 
          
    }
}
