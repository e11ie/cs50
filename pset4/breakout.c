//
// breakout.c
//
// Computer Science 50
// Problem Set 4
//

// standard libraries
#define _XOPEN_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>

// Stanford Portable Library
#include "gevents.h"
#include "gobjects.h"
#include "gwindow.h"

// height and width of game's window in pixels
#define HEIGHT 600
#define WIDTH 400

// number of rows of bricks
#define ROWS 5

// number of columns of bricks
#define COLS 10

// radius of ball in pixels
#define RADIUS 10

// lives
#define LIVES 3

// prototypes
void initBricks(GWindow window);
GOval initBall(GWindow window);
GRect initPaddle(GWindow window);
GLabel initScoreboard(GWindow window);
void updateScoreboard(GWindow window, GLabel label, int points);
GObject detectCollision(GWindow window, GOval ball);

int main(int argc, string argv[])
{
    //cheat
    string cheat = argv[1];
    
    // seed pseudorandom number generator
    srand48(time(NULL));

    // instantiate window
    GWindow window = newGWindow(WIDTH, HEIGHT);

    // instantiate bricks
    initBricks(window);

    // instantiate ball, centered in middle of window
    GOval ball = initBall(window);

    // instantiate paddle, centered at bottom of window
    GRect paddle = initPaddle(window);
    
    // label of lives left
    GLabel lively = newGLabel("Lives Left: ");
    setColor(lively, "gray");
    setFont(lively, "SansSerif-22");
    double xl = 5;
    double yl = 35;
    setLocation(lively, xl, yl);
    add(window, lively);
    
    GLabel lively_num = newGLabel("3");
    setColor(lively_num, "gray");
    setFont(lively_num, "SansSerif-22");
    double xln = 5 + getWidth(lively);
    double yln = 35;
    setLocation(lively_num, xln, yln);
    add(window, lively_num);
    
    // label of bricks left
    GLabel bricksy = newGLabel("Bricks Left: ");
    setColor(bricksy, "gray");
    setFont(bricksy, "SansSerif-22");
    double xb = WIDTH / 2;
    double yb = 35;
    setLocation(bricksy, xb, yb);
    add(window, bricksy);
    
    GLabel bricksy_num = newGLabel("50");
    setColor(bricksy_num, "gray");
    setFont(bricksy_num, "SansSerif-22");
    double xbn = (WIDTH / 2) + getWidth(bricksy);
    double ybn = 35;
    setLocation(bricksy_num, xbn, ybn);
    add(window, bricksy_num);
      
     
    // instantiate scoreboard, centered in middle of window, just above ball
    GLabel label = initScoreboard(window);
    
    // label click!
    GLabel click = newGLabel("Click to Start!");
    setColor(click, "gray");
    setFont(click, "SansSerif-32");
    double xc = (WIDTH - getWidth(click)) / 2;
    double yc = (HEIGHT - getFontAscent(click)) / 2 + 90;
    setLocation(click, xc, yc);
    add(window, click);

    // number of bricks initially
    int bricks = COLS * ROWS;
    // initial brick # label
    char bricky[4];
    sprintf(bricky, "%i", bricks);
    setLabel(bricksy_num, bricky); 

    // number of lives initially
    int lives = LIVES;

    // number of points initially
    int points = 0;
    
    // initial velocity
    double velocity_y = 2.0;
    double velocity_x = 2.0 + drand48();
    
    
   
    // keep playing until game over
    while (lives > 0)
    {
        // start game when window is clicked!
        GEvent m_event = getNextEvent(MOUSE_EVENT);
        if (m_event != NULL)
        {
            if (getEventType(m_event) == MOUSE_CLICKED)
            {
                setVisible(click, false);
                bool lifelost = false;
                while(lifelost == false)
                {                
                    // move paddle with cursor
                    // check for mouse event, and if we heard one...
                    
                    if(argc == 2 && strcmp(cheat, "GOD") == 0)
                    {
                        double y = HEIGHT - 100;
                        setLocation(paddle, (getX(ball) - getWidth(paddle)/2 + getWidth(ball)/2), y);
                    }
                    else
                    {
                        GEvent m_event = getNextEvent(MOUSE_EVENT);
                        if (m_event != NULL)
                        {
                            if (getEventType(m_event) == MOUSE_MOVED)
                            {
                                double x = getX(m_event) - getWidth(paddle) / 2;
                                double y = HEIGHT - 100;
                                setLocation(paddle, x, y);
                            }
                        }
                    }
                    
                    // COLISION
                    GObject object = detectCollision(window, ball);
                    if(object != NULL)
                    {
                        if (strcmp(getType(object), "GLine") == 0)
                        {
                            printf("%f\n", getY(object));
                        }
                        if (object == paddle && (getY(ball) + getWidth(ball)) <= (HEIGHT - 50))
                        {
                            velocity_y = -velocity_y;
                        }
                        if (strcmp(getType(object), "GLine") == 0 && getY(ball) <= 45)
                        {
                            velocity_y = -velocity_y;
                        }
                        if (strcmp(getType(object), "G3DRect") == 0 || (strcmp(getType(object), "GRect") == 0 && object != paddle))
                        {
                            velocity_y = -velocity_y;
                            removeGWindow(window, object);
                            printf("got it!\n");
                            // make bricks label count down
                            bricks--;
                            sprintf(bricky, "%i", bricks);
                            setLabel(bricksy_num, bricky);
                            if (bricks == 0)
                            {
                                setLabel(click, "Perfect Score!");
                                break;
                            }   
                            
                            // set score 
                            if(getY(object) <= 110)
                            {
                                points += 5;
                                updateScoreboard(window, label, points);
                            }
                            if(getY(object) <= 95)
                            {
                                points += 5;
                                updateScoreboard(window, label, points);
                            }
                            if(getY(object) <= 80)
                            {
                                points += 15;
                                updateScoreboard(window, label, points);
                            }
                            if(getY(object) <= 65)
                            {
                                velocity_y = 2.;
                                velocity_x = 2. + drand48();
                                points += 25;
                            }
                            if(getY(object) <= 50)
                            {
                                points += 25;
                                updateScoreboard(window, label, points);
                            }
                         }   
                            
                    }
                    
                    
                    // move circle along x-axis
                    move(ball, velocity_x, velocity_y);

                    // bounce off edges of window
                    if (getX(ball) + getWidth(ball) >= getWidth(window))
                    {
                        velocity_x = -velocity_x;
                    }
                    else if (getX(ball) <= 0)
                    {
                        velocity_x = -velocity_x;
                    }         
                    else if (getY(ball) <= 45)
                    {
                        velocity_y = -velocity_y;
                    }
                    else if (getY(ball) + getWidth(ball) >= HEIGHT - 25)
                    {
                        lives--;
                        lifelost = true;
                        removeGWindow(window, ball);
                        setLabel(click, "Oh no! Try again?");
                        ball = initBall(window);
                        // make live label count down
                        char liv [1];
                        sprintf(liv, "%d", lives);
                        setLabel(lively_num, liv);
                    }
                    // linger before moving again
                    pause(10);
                    
                    
                }
                setVisible(click, true);
                
                
                
            }
        }
    }   
    // relabel click
    setLabel(click, "Perfect Score!");

    // wait for click before exiting
    waitForClick();

    // game over
    closeGWindow(window);
    return 0;
}

/**
 * Initializes window with a grid of bricks.
 */
void initBricks(GWindow window)
{
    int height_top = 80;
    int side = 2;
    int width = 34;
    int height = 10;
    G3DRect bricks[ROWS][COLS];
    
    for(int row = 0; row < ROWS; row++)
    {
        for(int col = 0; col < COLS; col++)
        {
            bricks[row][col]= newG3DRect(side, height_top, width, height, true);
            setFilled(bricks[row][col], true);
            add(window, bricks[row][col]);
            side += 40;
            //set color of bricks
            if(row == 0)
            {
                setColor(bricks[row][col], "blue");
            }
            if(row == 1)
            {
                setColor(bricks[row][col], "green");
            }
            if(row == 2)
            {
                setColor(bricks[row][col], "yellow");
            }
            if(row == 3)
            {
                setColor(bricks[row][col], "orange");
            }
            if(row == 4)
            {
                setColor(bricks[row][col], "red");
            }
        }
        
        side = 2;
        height_top += 15;
    }
    
    //set upper boundary line
    add(window, newGLine(0, 45, getWidth(window), 45));
}

/**
 * Instantiates ball in center of window.  Returns ball.
 */
GOval initBall(GWindow window)
{
    //make ball add to middle of window
    GOval ball = newGOval((WIDTH / 2) - (RADIUS / 2), (HEIGHT / 2) - (RADIUS / 2), RADIUS, RADIUS);
    setFilled(ball, true);
    setColor(ball, "black");
    add(window, ball);
    
    
    return ball;
}

/**
 * Instantiates paddle in bottom-middle of window.
 */
GRect initPaddle(GWindow window)
{
    int pwidth = RADIUS*4;
    GRect Paddle = newGRect((WIDTH / 2) - (pwidth / 2), HEIGHT - 100, pwidth, 5);
    setFilled(Paddle, true);
    setColor(Paddle, "black");
    add(window, Paddle);
    
    return Paddle;
}

/**
 * Instantiates, configures, and returns label for scoreboard.
 */
GLabel initScoreboard(GWindow window)
{
    
    
           
    GLabel label = newGLabel("0");
    setColor(label, "gray");
    setFont(label, "SansSerif-32");
    double x = (WIDTH - getWidth(label)) / 2;
    double y = (HEIGHT - getFontAscent(label)) / 2 - 30;
    setLocation(label, x, y);
    add(window, label);
        
    return label;
}

/**
 * Updates scoreboard's label, keeping it centered in window.
 */
void updateScoreboard(GWindow window, GLabel label, int points)
{
    // update label
    char s[12];
    sprintf(s, "%i", points);
    setLabel(label, s);

    // center label in window
    double x = (getWidth(window) - getWidth(label)) / 2;
    double y = (getHeight(window) - getHeight(label)) / 2;
    setLocation(label, x, y);
}

/**
 * Detects whether ball has collided with some object in window
 * by checking the four corners of its bounding box (which are
 * outside the ball's GOval, and so the ball can't collide with
 * itself).  Returns object if so, else NULL.
 */
GObject detectCollision(GWindow window, GOval ball)
{
    // ball's location
    double x = getX(ball);
    double y = getY(ball);

    // for checking for collisions
    GObject object;

    // check for collision at ball's top-left corner
    object = getGObjectAt(window, x, y);
    if (object != NULL)
    {
        return object;
    }

    // check for collision at ball's top-right corner
    object = getGObjectAt(window, x + 2 * RADIUS, y);
    if (object != NULL)
    {
        return object;
    }

    // check for collision at ball's bottom-left corner
    object = getGObjectAt(window, x, y + 2 * RADIUS);
    if (object != NULL)
    {
        return object;
    }

    // check for collision at ball's bottom-right corner
    object = getGObjectAt(window, x + 2 * RADIUS, y + 2 * RADIUS);
    if (object != NULL)
    {
        return object;
    }
    // no collision
    return NULL;
}
