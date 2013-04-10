#include <iostream>
#include <cmath>
#include<string.h>
#include <GL/glut.h>
#include "glm2.h"
#include "glm2.cpp"
#include "imageloader.h"
#include "imageloader.cpp"
#include <assert.h>
#include <fstream>
//#include "text3d.cpp"
#include "text3d.h"
using namespace std;

#define PI 3.141592653589
#define DEG2RAD(deg) (deg * PI / 180)
int drop=0;
// Function Declarations
void drawScene();
void update(int value);
void update2(int value);
void update3(int value);
void drawBox(float len,float len2);
void drawball(float rad);
void drawTriangle();
void initRendering();
void handleResize(int w, int h);
void handleKeypress1(unsigned char key, int x, int y);
void handleKeypress2(int key, int x, int y);
void handleMouseclick(int x, int y);
void drawWorld();
void drawmiddle(float x,float y,float z);
void drawWorld2();
void drawWorld3();
void drawWorld4();
void drawWorld5();
void collision();
void conv();
void obj1();
int finish=0;
float str_x=0.5;
float coinrot=0.0f;
float xcoor=-2.0f,ycoor=-0.2f,zcoor=4.5f,centerx=0.0f,centery=0.0f,centerz=3.0f;
float ang=0;
float minh=0.0f;
float ydec=0,w,hi;
int flag=0,flags=1,flagx=1,flagsc=1,flagr=1,fobj1=0,fstair=0;
int flook=0;
void makejump(int value);
int jump=0;
int third=0;
int vtil=0;
float ti=-2.0f,tj=4.5f;
float h=0.0f,maxh=0.5f;
float health=1.0f;
// Global Variables
int walk=0;
char fi[100];
float ball_x = 1.0f;
float ball_y = 0.0f;
float ball_velx = 0.01f;
float ball_vely = 0.02f;
float ball_rad = 0.2f;
float box_len = 4.0f;
float tri_x = 0.0f;
float tri_y = 0.0f;
float theta = 0.0f; 
int seltile=0;
float lookx=0.0f,looky=0.0f,lookz=5.0f;
float strip_z=2.0f,strip_x=-2.5,rot_y=45,rots_z=4.05;

GLMmodel *mod = NULL ;
GLMmodel *mod1 = NULL ;
GLMmodel *wall = NULL ;
typedef struct tile{
	int type;
	float x,y,z;
}tile;
tile moving[5];
int flaggaze=0;
float towerx=0.0f,towery=5.0f,towerz=5.0f;
float camtilex,camtiley,camtilez;
tile fly[40];
tile coin[20];
float posx,posy=1.0f,posz=6.0f,scrollx,scrolly,scrollz;
float winwidth=1200,winheight=700,width=7.0f,height=4.0f;
float rotblock=0.0f;
float len;
void rotatecoin(int value)
{
	rotblock+=0.5f;
	coinrot+=5.0f;
	glutTimerFunc(10,rotatecoin,0);
}
float computeScale(const char* strs[4]) {
	float maxWidth = 0;
	for(int i = 0; i < 4; i++) {
		float width = t3dDrawWidth(strs[i]);
		if (width > maxWidth) {
			maxWidth = width;
		}
	}

	return 2.6f / maxWidth;
}


float _angle = -30.0f;
float _scale=2;
//The four strings that are drawn
//const char* STRS[3] = {"G ame Over", "Tutorials", "Rock"};
const char *STRS[3] = {"G ame Over", "C ongrats\nYou Win!", "Rock"};

void cleanup() {
		t3dCleanup();
}
void mouse(int button,int state,int x,int y)
{
	len=sqrt((centerx-towerx)*(centerx-towerx) + (centery-towery)*(centery-towery) + (centerz-towerz)*(centerz-towerz));
	printf("scroll\n");
	printf("towerx:%f posx:%f towerz:%f posz:%f\n",towerx,posx,towerz,posz);
	if(button==3)
	{
		posx=towerx+0.5*((centerx-towerx)/len);
		posy=towery+0.5*((centery-towery)/len);
		posz=towerz+0.5*((centerz-towerz)/len);
	}
	else if(button==4)
	{
		posx=towerx-0.5*((centerx-towerx)/len);
		posy=towery-0.5*((centery-towery)/len);
		posz=towerz-0.5*((centerz-towerz)/len);
	}
	else posy=towery;
}
GLuint loadTexture(Image* image) {
	GLuint textureId;
	glGenTextures(1, &textureId); //Make room for our texture
	glBindTexture(GL_TEXTURE_2D, textureId); //Tell OpenGL which texture to edit
	//Map the image to the texture
	glTexImage2D(GL_TEXTURE_2D,                //Always GL_TEXTURE_2D
			0,                            //0 for now
			GL_RGB,                       //Format OpenGL uses for image
			image->width, image->height,  //Width and height
			0,                            //The border of the image
			GL_RGB, //GL_RGB, because pixels are stored in RGB format
			GL_UNSIGNED_BYTE, //GL_UNSIGNED_BYTE, because pixels are stored
			//as unsigned numbers
			image->pixels);               //The actual pixel data
	return textureId; //Returns the id of the texture
}

GLuint _textureId; //The id of the texture
GLuint _textureId2; //The id of the texture
GLuint _textureId3; //The id of the texture
float winw,winh;
int main(int argc, char **argv) {

    // Initialize GLUT
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_DOUBLE | GLUT_RGB);

    int w = glutGet(GLUT_SCREEN_WIDTH);
    int h = glutGet(GLUT_SCREEN_HEIGHT);
    int windowWidth = w * 2 / 3;
    int windowHeight = h * 2 / 3;

    glutInitWindowSize(1200,700);
		   glutInitWindowPosition((w - windowWidth) / 2, (h - windowHeight) / 2);

		   glutCreateWindow("Bot Explorer");  // Setup the window
		   initRendering();

		   // Register callbacks
		   zcoor=0.0f;
		   glutDisplayFunc(drawScene);
		   glutIdleFunc(drawScene);
		   strcpy(fi,"orig.obj");
		   glutKeyboardFunc(handleKeypress1);
		   glutSpecialFunc(handleKeypress2);
		   glutMotionFunc(handleMouseclick);
		   glutMouseFunc(mouse);
		   glutReshapeFunc(handleResize);
		   glutTimerFunc(5, makejump, 0);
_scale = computeScale(STRS);
glutTimerFunc(5,update,0);
glutTimerFunc(100,update3,0);

	glutTimerFunc(10,rotatecoin,0);
		   glutMainLoop();
		   return 0;
}
int ftower=0;
int flag2;
void drawcube(GLuint t)
{
	glEnable(GL_COLOR_MATERIAL);
/*	glBegin(GL_LINES);
	glVertex2f(-6.0,6.0);
	glVertex2f(6.0,6.0);
	glEnd();*/
	glBegin(GL_QUADS);

	glColor3f(1.0,1.0,1.0);
	glVertex3f(  0.2, -0.2, -0.2 );      // P1 is red
	glVertex3f(  0.2,  0.2, -0.2 );      // P2 is green
	glVertex3f( -0.2,  0.2, -0.2 );      // P3 is blue
	glVertex3f( -0.2, -0.2, -0.2 );      // P4 is purple

	glEnd();
	// White side - BACK
	glBegin(GL_POLYGON);
	glColor3f(1.0,1.0,1.0);
	glVertex3f(  0.2, -0.2, 0.2 );
	glVertex3f(  0.2,  0.2, 0.2 );
	glVertex3f( -0.2,  0.2, 0.2 );
	glVertex3f( -0.2, -0.2, 0.2 );
	glEnd();

	// Purple side - RIGHT
	glBegin(GL_POLYGON);
	glColor3f(1.0,1.0,1.0);
	glVertex3f( 0.2, -0.2, -0.2 );
	glVertex3f( 0.2,  0.2, -0.2 );
	glVertex3f( 0.2,  0.2,  0.2 );
	glVertex3f( 0.2, -0.2,  0.2 );
	glEnd();

	// Green side - LEFT
	glBegin(GL_POLYGON);

	glColor3f(1.0,1.0,1.0);
	glVertex3f( -0.2, -0.2,  0.2 );
	glVertex3f( -0.2,  0.2,  0.2 );
	glVertex3f( -0.2,  0.2, -0.2 );
	glVertex3f( -0.2, -0.2, -0.2 );
	glEnd();

	// Blue side - TOP
	glEnable(GL_TEXTURE_2D);
	glBindTexture(GL_TEXTURE_2D,t);
	glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MIN_FILTER, GL_LINEAR);
	glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MAG_FILTER, GL_LINEAR);
	glBegin(GL_QUADS);
	glNormal3f(0.0f, 0.0f, 1.0f);
	//	glTexCoord2f(0.0f, 0.0f);
	glTexCoord2f(0.0f, 0.0f);
	glVertex3f(  0.2,  0.2,  0.2 );
	glTexCoord2f(1.0f, 0.0f);
	glVertex3f(  0.2,  0.2, -0.2 );
	glTexCoord2f(1.0f, 1.0f);
	glVertex3f( -0.2,  0.2, -0.2 );
	glTexCoord2f(0.0f, 1.0f);
	glVertex3f( -0.2,  0.2,  0.2 );
	glEnd();
	glDisable(GL_TEXTURE_2D);
// Red side - BOTTOM
	glBegin(GL_POLYGON);
	glColor3f(1.0,1.0,1.0);

	glVertex3f(  0.2, -0.2, -0.2 );
	glVertex3f(  0.2, -0.2,  0.2 );
	glVertex3f( -0.2, -0.2,  0.2 );
	glVertex3f( -0.2, -0.2, -0.2 );
	glEnd();
	//	glDisable(GL_TEXTURE_2D);

}
float dim,dimy,yinc;
int flyi,flyj;
// Function to draw objects on the screen
void drawScene() {
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glMatrixMode(GL_MODELVIEW);
    glLoadIdentity();
    glEnable(GL_LIGHTING);
    glEnable(GL_DEPTH_TEST);
    GLfloat mat_specular[] = { 1.0, 1.0, 1.0, 1.0 };
       GLfloat mat_shininess[] = { 50.0 };
       GLfloat light_position[] = { xcoor, ycoor, zcoor, 0.0 };
//       glClearColor (0.0, 0.0, 0.0, 0.0);
 //         glShadeModel (GL_SMOOTH);
//    glPushMatrix();
  //  glTranslatef(0.0,0.0,0.0);
    glMaterialfv(GL_FRONT, GL_SPECULAR, mat_specular);
    glMaterialfv(GL_FRONT, GL_SHININESS, mat_shininess);
    glLightfv(GL_LIGHT2, GL_POSITION, light_position);
    glPushMatrix();
   glTranslatef(0.0,0.0,0.0);
    glEnable(GL_LIGHT2);

    glColorMaterial(GL_FRONT_AND_BACK, GL_AMBIENT_AND_DIFFUSE);
    glEnable(GL_CULL_FACE);
	GLfloat color[]={0.6f,0.6f,0.6f,1.0};
	GLfloat ambient[]={0.4f,0.4f,0.4f,1.0};
	glLightModelfv(GL_LIGHT_MODEL_AMBIENT,color);
    GLfloat lightpos[] = {-0.5, 0.5, 1.0, 0.0};
    glLightfv(GL_LIGHT0, GL_POSITION, lightpos);
    glLightfv(GL_LIGHT0, GL_DIFFUSE, color);
    //light1
    glEnable(GL_LIGHT0);
//    GLfloat lightpos1[] = {-1.0,0, 0, 0.0};
  //  glLightfv(GL_LIGHT1, GL_POSITION, lightpos1);*/
    int i,j;
/*    glPushMatrix();
    glRotatef(20.0f, 1.0f, 0.0f, 0.0f);
    glRotatef(-_angle, 0.0f, 1.0f, 0.0f);

    //Draw the strings along the sides of a square
    glScalef(_scale, _scale, _scale);
    glColor3f(0.3f, 1.0f, 0.3f);
    for(int i = 0; i < 4; i++) {
	    glPushMatrix();
    glScalef(0.1, 0.1, 0.1);
	    glRotatef(90 * i, 0, 1, 0);
	    glTranslatef(0, 0, 0.0f / _scale);
	    t3dDraw3D(STRS[i], 0, 0, 0.2f);
	    glPopMatrix();
    }
    glPopMatrix();*/
    glEnable(GL_LIGHT1);
    float r1,r2,r3;
	flyi=0;
	flyj=0;
    //	dim=-2.0f;dimy=4.0f;

    flag2=int(ang/90)%4;
  //  if(flook==1 || ftower==0)
//    {
//if(flaggaze!=1)

	    if(flag2==0)
	    {
		    lookx=xcoor;looky=ycoor;lookz=zcoor;
		    if(flook==1 || ftower==0)
		    {towerx=xcoor;towery=ycoor+0.2f;towerz=zcoor+1.5f;
		    centerx=towerx;centery=towery;centerz=towerz+2.0f;
		    }
		    if(third==1)
		    {
		   	towerx=xcoor;towery=ycoor+0.2f;towerz=zcoor-1.5f;
		    centerx=lookx;centery=looky;centerz=lookz;
		    }
	    }
	    if(flag2==1)
	    {
		    lookx=zcoor;looky=ycoor;lookz=-xcoor;
		    if(flook==1 || ftower==0)
		    {towerx=zcoor+1.5f;towery=ycoor+0.2f;towerz=-xcoor;
		    centerx=towerx+2.0f;centery=towery;centerz=towerz;//+2.0f;
		    }
		    if(third==1)
		    {towerx=zcoor-1.5f;towery=ycoor+0.2f;towerz=-xcoor;
		    centerx=lookx;centery=looky;centerz=lookz;//+2.0f;
		    }

	    }
	    if(flag2==2)
	    {
		    lookx=-xcoor;looky=ycoor;lookz=-zcoor;
		    if(flook==1 || ftower==0)
		    {towerx=-xcoor;towery=ycoor+0.2f;towerz=-zcoor-1.5f;
		    centerx=towerx;centery=towery;centerz=towerz-2.0f;
		    }
		    if(third==1)
		    {towerx=-xcoor;towery=ycoor+0.2f;towerz=-zcoor+1.5f;
		    centerx=lookx;centery=looky;centerz=lookz;
		    }
	    }
	    if(flag2==-1)
	    {
		    lookx=-zcoor;looky=ycoor;lookz=xcoor;
		    if(flook==1 || ftower==0)
		    {towerx=-zcoor-1.5f;towery=ycoor+0.2f;towerz=xcoor;
		    centerx=towerx-2.0f;centery=towery;centerz=towerz;//+2.0f;
		    }
		    if(third==1)
		    {towerx=-zcoor+1.5f;towery=ycoor+0.2f;towerz=xcoor;
		    centerx=lookx;centery=looky;centerz=lookz;//+2.0f;
		    }
	    }
	    printf("centx:%f centy:%f centz:%f\n",lookx,looky,lookz);






//}
	    /*	    if(ftower==0 && flook!=1)
	    {
				    centerx=towerx;centery=towery;centerz=towerz;//+2.0f;
    printf("centerx:%f centerx:%f\n",centerx,centerz);
		    towerx=0.0f;towery=1.0f;towerz=6.0f;
	    }*/
	    //		lookz+=0.01f;
//    }
    				if(ftower==0 && flook!=1 && third!=1 && flaggaze!=1)
				{centerx=lookx;centery=looky;centerz=lookz;
		    towerx=-2.0f;towery=4.0f;towerz=6.0f;
				}
				else if(ftower==1)
				    {towerx=1.0f;towery=5.0f;towerz=9.0f;
					    centerx=0.0f;centery=0.0f;centerz=0.0f;
				    }

    //    else if(ftower==0)
    //  {
    //	    lookx=0.0f;looky=0.0f;lookz=5.0f;
    //  	centerx=xcoor;centery=ycoor;centerz=zcoor;
	   // }	
			
				if(flaggaze==1)
				{towerx=posx;towery=posy;towerz=posz;centerx=lookx;centery=looky;centerz=lookz;}
 if(vtil==1 && seltile==1)
    gluLookAt(camtilex,camtiley,camtilez,centerx,centery,centerz,0.0,1.0,0.0);
				else
    gluLookAt(towerx,towery,towerz,centerx,centery,centerz,0.0,1.0,0.0);
 dim=-2.0f;dimy=4.0f;
		 glPushMatrix();
		 glRotatef(90,0,0,1);
		 glTranslatef(0.0f,0.0f,-5.0f);
		 glScalef(1.0,1,1.0);
	glEnable(GL_TEXTURE_2D);
	glBindTexture(GL_TEXTURE_2D,_textureId3);
	glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MIN_FILTER, GL_LINEAR);
	glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MAG_FILTER, GL_LINEAR);
		 glBegin(GL_QUADS);
		 glNormal3f(0.0,0.0,1.0);
		 glTexCoord2f(0.0f, 0.0f);
		 glVertex3f(-10.2,35.2,0);
		 glTexCoord2f(1.0f, 0.0f);
		 glVertex3f(-10.2,-35.0,0);
		 glTexCoord2f(1.0f, 1.0f);
		 glVertex3f(10.2,-35.0,0);
		 glTexCoord2f(0.0f, 1.0f);
		 glVertex3f(10.2,35.2,0);
		 glEnd();
		 glPopMatrix();
		 
		 
		 glPushMatrix();
		 glTranslatef(0.0f,-0.6f,0.0f);
		 glScalef(1.0,0.1,1.0);
	glEnable(GL_TEXTURE_2D);
	glBindTexture(GL_TEXTURE_2D,_textureId2);
	glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MIN_FILTER, GL_LINEAR);
	glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MAG_FILTER, GL_LINEAR);
		 glBegin(GL_QUADS);
		 glNormal3f(0.0,0.0,1.0);
		 glTexCoord2f(0.0f, 0.0f);
		 glVertex3f(-150.2,0.0,50.2);
		 glTexCoord2f(1.0f, 0.0f);
		 glVertex3f(150.2,0.0,50.2);
		 glTexCoord2f(1.0f, 1.0f);
		 glVertex3f(150.2,0.0,-4.2);
		 glTexCoord2f(0.0f, 1.0f);
		 glVertex3f(-150.2,0.0,-4.2);
		 glEnd();
		 glPopMatrix();
		 
		 
		 
		 
		 moving[0].x=-2.42;moving[0].y=-0.2;moving[0].z=strip_z;
		 moving[1].x=str_x;moving[1].y=-0.2;moving[1].z=-0.25;
		 moving[2].x=3.75;moving[2].y=-0.2;moving[2].z=strip_z;
		 moving[3].x=str_x;moving[3].y=-0.2;moving[3].z=5.3;
		 printf("strip_z:%f\n",strip_z);

		 drawWorld();
		 for(i=0;i<4;i++)
{
	printf("moving:%f\n",moving[i].z);
	if(i==1 || i==3)
	{glPushMatrix();
		glTranslatef(moving[i].x,moving[i].y,moving[i].z);	
		glScalef(1,.1,1);
		drawmiddle(moving[i].x,moving[i].y,moving[i].z);
		glPopMatrix();
	}
	else


	{	glPushMatrix();
		glTranslatef(moving[i].x,moving[i].y,moving[i].z);
		if(i==2)
		{glScalef(4.5,.1,1);}
		else 
		{glScalef(1,.1,1);}
		drawmiddle(moving[i].x,moving[i].y,moving[i].z);
		glPopMatrix();

	}
}





						
						drawWorld2();
						drawWorld3();
						drawWorld4();
						drawWorld5();
						obj1();
						collision();

						
		 for(i=-1.0;i<=10;i++)
		 {
			 dimy=4.5f;
			 for(j=10;j>=0;j--)
			 {
				 if(j%2==0)
				 {r1=1.0f;r2=0.0f;r3=0.0f;}
				 else{r1=0.0f;r2=1.0f;r3=0.0f;}
				 if(i%2==0)
					 r3=1.0f;
//				 if(!((i==1 && (j==7||j==2)) || (i==5 && (j==3 ||j==6)) || (i==9 && (j==-1||j==5)) || (i==13 && j==-5) || (i==17 && j==-9) && ((i==1 && (j==-7 || j==-2)) || (i==6 && (j==-5 || j==5)) || (i==17 && j==4) || (i==20 && j==1))))
if(!((i==1 && (j==7||j==2)) || (i==5 && (j==3 ||j==6)) || (i==9 && (j==-1||j==5)) || (i==7 && j==1) || (i==10 && j==9) || (i==1 && (j==0 || j==5)) || (i==6 && (j==1 || j==8)) || (i==7 && j==4) || (i==10 && j==5) || (i==-1 && j==10) || (i==5 && j==10) || (i==0 && j==3)))
				 {
				 glPushMatrix();
				 glTranslatef(dim,-0.2f,dimy);
					 glScalef(1.0,0.1,1.0);
					 printf("tile ti:%f tj:%f dimx:%f dimz:%f i:%d %d %d %d\n ",ti,tj,dim,dimy,i,dim==ti,dimy==tj,vtil==1);
					 if(fabs(dim-ti)<=0.000001 && fabs(dimy-tj)<=0.000001 && vtil==1)
					 {
						 printf("ontile\n");
						 drawcube(_textureId2);
						 camtilex=dim,camtiley=0.0f,camtilez=dimy;
					 }
					 else if(i==3 && j==8)
					 {
						 fly[flyi].type=-1;fly[flyi].x=dim;fly[flyi].y=-0.2f;fly[flyi].z=dimy;
						 flyi++;
						 drawcube(_textureId3);
					 }
					 else{
				 		drawcube(_textureId);
	/*					glPolygonMode(GL_FRONT_AND_BACK, GL_FILL);
						   GLfloat lightpos1[] = {-1.0,0, 0, 0.0};
						  glLightfv(GL_LIGHT1, GL_POSITION, lightpos1);
							glEnable(GL_LIGHT1);*/
							printf("flyi:%d flytype:%d\n",flyi,coin[flyi].type);
						if((i%3==0) && j%4==0){
							if(coin[flyi].type!=-2){
						 coin[flyi].type=2;coin[flyi].x=dim;coin[flyi].y=2.5f;coin[flyi].z=dimy;
						 fly[flyi].type=2;fly[flyi].x=dim;fly[flyi].y=-0.2f;fly[flyi].z=dimy;
						 flyi++;
						glPushMatrix();
						glRotatef(coinrot,0,1,0);
						glTranslatef(0.0,2.5,0.0);
						glColor3f(212.0/255.0,175.0/255.0,55.0/255.0);
						glScalef(1.0,10.0,1.0);
						 drawball(0.1f);
						 glPopMatrix();}
							else flyi++;
						}
					 }
				 	glPopMatrix();
				//	 glPopMatrix();
				//	 continue;
				 }
				 //		 else
		/*		 if((i==1 && (j==-7 || j==-2)) || (i==6 && (j==-5 || j==5)) || (i==17 && j==4) || (i==20 && j==1))
				 {
					 glPopMatrix();
					 continue;
				 }
				 //	 glScalef(1.0,5.0,1.0);
				 else*/
				 dimy=dimy-0.42f;

			 }
			 dim=dim+0.42f;
		 }
		 printf("dim=%f\n",dim);
		 glPushMatrix();
		 glRotatef(ang,0,1,0);
		 printf("bla xcoor%f ycoor %f zcoor %f\n",lookx,looky,lookz);
    glTranslatef(xcoor,ycoor,zcoor);
    if(!mod)
    {
	    mod = glmReadOBJ(fi);
	    glmUnitize(mod);
	    glmFacetNormals(mod);
	    glmVertexNormals(mod, 90.0);
    }
glPushMatrix();
	    glScalef(0.3,0.3,0.3);
    glmDraw(mod,  GLM_COLOR );
  //  glmDelete(mod);
    glPopMatrix();
    glPopMatrix();
		 dim=-2.0f;
		 for(i=-1.0;i<=10;i++)
		 {
			 dimy=4.5f;
			 for(j=10;j>=0;j--)
			 {
				 glPushMatrix();
				 if((i==1 && (j==7||j==2)) || (i==5 && (j==3 ||j==6)) || (i==9 && (j==-1||j==5)) || (i==7 && j==1) || (i==10 && j==9))
				 {
					 fly[flyi].type=1;fly[flyi].x=dim;fly[flyi].y=yinc;fly[flyi].z=dimy;
					 flyi++;
					 glTranslatef(dim,yinc,dimy);
					 glScalef(1.0,0.1,1.0);
					 drawcube(_textureId);
				 }
				 if((i==1 && (j==0 || j==5)) || (i==6 && (j==1 || j==8)) || (i==7 && j==4) || (i==10 && j==5))
				{	 fly[flyi].type=0;fly[flyi].x=dim;fly[flyi].y=-0.2;fly[flyi].z=dimy;
					 flyi++;
					 glTranslatef(dim,-0.2f,dimy);
					 glScalef(1.0,1.0,1.0);
					 drawcube(_textureId2);
				 }
				 if((i==-1 && j==10) || (i==5 && j==10) || (i==0 && j==3))
				 {
					 fly[flyi].type=-4;fly[flyi].x=dim;fly[flyi].y=2.0f;fly[flyi].z=dimy;
					 flyi++;
				 }
					 glPopMatrix();
					 dimy=dimy-0.42f;
			 }
			 dim=dim+0.42f;
		 }





		 printf("dim:%f dimy:%f\n",dim,dimy);
		 glPushMatrix();
		 for(i=0;i<flyi;i++)
		 {
			 if(((lookx<=(fly[i].x+0.2) && (lookx>=(fly[i].x-0.2))) && ((lookz<=(fly[i].z+0.2)) && (lookz>=(fly[i].z-0.2)))) /*||(lookx<-2.5f || lookx>3.2 || lookz>5.0f || lookz<-0.15)*/)
			 {
				 if(fly[i].type==1 || (lookx<-2.5f || lookx>3.2 || lookz>5.0f || lookz<-0.15) || fly[i].type==-4)
				 {
					 drop=1;
				 }
				 printf("lookx:%f flyx:%f lookz:%f flyz:%f\n",centerx,fly[i].x,centerz,fly[i].z);
				 if((fly[i].type==0))// || (fly[i].type==1 && fly[i].y<looky && yinc!=ycoor))
				 {
					 zcoor=zcoor-0.05f;
				 	 break;
				 }
				 else if(fly[i].type==1 && /*(fly[i].y<looky ||*/ ((yinc<=-0.0f && ycoor>=-0.3f) || ycoor>-0.2f))// && yinc==ycoor)
				 {
					 ycoor=yinc;
					 break;
				 }
				 else if((fly[i].type==1 && fly[i].y>=looky) || (lookx<-2.5f || lookx>3.2 || lookz>5.0f || lookz<-0.15) || fly[i].type==-4)
				 {
					 glutTimerFunc(100, update2, 0);
					 ycoor=ydec;
					 health=0;
					 drop=-2;
					 break;
				 }
				 else if(fly[i].type==-1)
				 {
					 printf("teleport\n");
					 xcoor=-1.5f;ycoor=0.0f;zcoor=-0.1f;
					 break;
				 }
				 else if(fly[i].type==2)
				 {coin[i].type=-2;printf("coin taken\n");}
				 
			 }
		 }
if(drop==0 && health!=0)
{
	if(ycoor>-0.2f)
	{health=health-0.2f;}
	ycoor=-0.2f;
}
	drop=0;


	/*	 glRotatef(ang,0,1,0);
    glTranslatef(xcoor,ycoor,zcoor);
    if(!mod)
    {
	    mod = glmReadOBJ(fi);
	    glmUnitize(mod);
	    glmFacetNormals(mod);
	    glmVertexNormals(mod, 90.0);
    }  
	    glScalef(0.3,0.3,0.3);
    glmDraw(mod, GLM_SMOOTH | GLM_TEXTURE | GLM_COLOR | GLM_MATERIAL);
//    }*/
        glPopMatrix();
    glPopMatrix();
   glPushMatrix();
  glTranslatef(-3.0f,1.8f,-5.0f);
    glPolygonMode(GL_FRONT_AND_BACK, GL_LINE);
    glBegin(GL_QUADS);
    w=1.0f;hi=0.18f;
    glVertex2f(-w / 2, -hi / 2);
    glVertex2f(w / 2, -hi / 2);
    glVertex2f(w / 2, hi / 2);
    glVertex2f(-w / 2, hi / 2);
    glEnd();
    glPopMatrix();
   glPushMatrix();
  glTranslatef(-3.5f,1.71f,-5.0f);
   drawBox(health,0.18f);
   glPopMatrix();
if(lookx<=(3.04+0.4) && (lookx>=(3.04-0.4)) && (lookz<=(4.5+0.4)) && (lookz>=(4.5-0.4)))
{
	finish=1;
	printf("finish:%d\n",finish);
}
/*if(health<=0.0)
{
	i=0;
const char *STRS[3] = {"G ame Over", "Congrats\nYou Win!", "Rock"};
}*/
if(finish==1)
{
	i=1;
const char *STRS[3] = {"Congrats\nYou Win!", "Tutorials", "Rock"};
}

  /*  if(health<=0.0 || finish==1)
{
   glPushMatrix();
   glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
   glMatrixMode(GL_MODELVIEW);
   glLoadIdentity();
   glPushMatrix();
   glTranslatef(-2,0.5,-4.0);
   glScalef(0.412, 0.412, 0.412);
   glColor3f(0, 1.0f, 0);
   glPushMatrix();
   //glRotatef(180 , 0, 1, 0);
   glRotatef(-30,1,0,0);
   t3dDraw3D(STRS[i], -1, 0, 0.05f);
   glPopMatrix();
glPopMatrix();}
*/
    glutSwapBuffers();
}

// Function to handle all calculations in the scene
// updated evry 10 milliseconds
int nofly=0;
void update(int value) {
    
    // Handle ball collisions with box
    if(ball_x + ball_rad > box_len/2 || ball_x - ball_rad < -box_len/2)
        ball_velx *= -1;
    if(ball_y + ball_rad > box_len/2 || ball_y - ball_rad < -box_len/2)
        ball_vely *= -1;
    
    // Update position of ball
    		ball_x += ball_velx;
    		ball_y += ball_vely;
		if(yinc<maxh && nofly==0)
			yinc+=0.05f;
		else if(yinc>=maxh && nofly==0)
			nofly=1;
		else if(nofly==1 && yinc>=-0.2f)
		{
			printf("decr\n");
			yinc-=0.05f;
		}
		else if(yinc<=-0.2f)
		{
			printf("neeche\n");
	//		jump=0;
			nofly=0;
		}
ydec-=0.05f;
	//	zcoor+=0.05f;
//    if(yinc<1.0)
//	yinc=yinc+0.1f;
    glutTimerFunc(100, update, 0);
}
void update2(int value)
{ydec=ydec-0.05f;
    glutTimerFunc(100, update2, 0);
}

void update3(int value)
{
if(flags==1)
{strip_z+=.05;}
if(flags==-1)
{strip_z-=.05;}
if(strip_z>3.5)
{strip_z-=.05;
flags=-1;}
if(strip_z<1)
{strip_z+=.05;
flags=1;}

if(flagx==1)
{str_x+=.05;}
if(flagx==-1)
{str_x-=.05;}
if(str_x>2)
{str_x-=.05;
flagx=-1;}
if(str_x<-1)
{str_x+=.05;
flagx=1;}

if(flagsc==1)
{rot_y+=1;}
if(flagsc==-1)
{rot_y-=1;}
if(rot_y>90)
{rot_y-=1;
flagsc=-1;}
if(rot_y<0)
{rot_y+=1;
flagsc=1;}


if(flagr==1)
{rots_z+=.05;}
if(flagr==-1)
{rots_z-=.05;}
if(rots_z>6)
{rots_z-=.05;
flagr=-1;}
if(rots_z<4.05)
{rots_z+=.05;
flagr=1;}



    glutTimerFunc(100, update3, 0);
}

void drawBox(float w,float h) {
    glPolygonMode(GL_FRONT_AND_BACK, GL_FILL);
    glBegin(GL_QUADS);
   glColor3f(1,0,0);
    glVertex2f(0.0, 0.0);
    glVertex2f(w, 0);
    glVertex2f(w, h);
    glVertex2f(0, h);
    glEnd();
    glColor3f(1,1,1);
    glPolygonMode(GL_FRONT_AND_BACK, GL_FILL);
}

void drawBall(float rad) {
    
   glBegin(GL_TRIANGLE_FAN);
   for(int i=0 ; i<360 ; i++) {
       glVertex2f(rad * cos(DEG2RAD(i)), rad * sin(DEG2RAD(i)));
   }
   glEnd();
}

void drawTriangle() {

    glBegin(GL_TRIANGLES);
    glColor3f(0.0f, 0.0f, 1.0f);
    glVertex3f(0.0f, 1.0f, 0.0f);
    glColor3f(0.0f, 1.0f, 0.0f);
    glVertex3f(-1.0f, -1.0f, 0.0f);
    glColor3f(1.0f, 0.0f, 0.0f);
    glVertex3f(1.0f, -1.0f, 0.0f);
    glEnd();
}

// Initializing some openGL 3D rendering options
void initRendering() {

    glEnable(GL_DEPTH_TEST);        // Enable objects to be drawn ahead/behind one another
    glEnable(GL_COLOR_MATERIAL);    // Enable coloring
    glClearColor(0.0f, 0.0f, 0.0f, 1.0f);   // Setting a background color
    glEnable(GL_CULL_FACE);
    glEnable(GL_LIGHTING);
    glEnable(GL_LIGHT0);
    glEnable(GL_LIGHT1);
    glEnable(GL_NORMALIZE);
glShadeModel(GL_SMOOTH);
	t3dInit();
    glClearColor(1.0f, 1.0f, 1.0f, 1.0f);   // Setting a background color
    Image* image = loadBMP("grass.bmp");
    _textureId = loadTexture(image);
    delete image;
    Image* image2 = loadBMP("water.bmp");
    _textureId2 = loadTexture(image2);
    delete image2;
    Image* image3 = loadBMP("mount.bmp");
    _textureId3 = loadTexture(image3);
    delete image3;
    // gluPerspective(45.0f, (float)w / (float)h, 0.1f, 200.0f);
}

// Function called when the window is resized
void handleResize(int w, int h) {

    glViewport(0, 0, w, h);
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluPerspective(45.0f, (float)w / (float)h, 0.1f, 200.0f);
    glMatrixMode(GL_MODELVIEW);
    glLoadIdentity();
}
//int flag2;//flag=int(ang/90)%4;
//int flook=0;
void handleKeypress1(unsigned char key, int x, int y) {

    if (key == 27) {
        exit(0);     // escape key is pressed
    }
    if(key==106)
    {
	    printf("jump:%d\n",jump);
	if(jump==1)
		jump=0;
	else jump=1;
    }
    if(key==102)
    {
	    if(flook==0)
		    flook=1;
	    else flook=0;
/*	    if(flook==1)
	    {
		    if(flag2==0)
		    {
		    	lookx=xcoor;looky=ycoor;lookz=zcoor+5.0f;
//	    		centerx=lookx;centery=looky;centerz=lookz+3.0f;
		    }
	    }
	    else
	    {lookx=0.0f;looky=0.1f;lookz=0.5f;
	    centerx=xcoor;centery=ycoor;centerz=zcoor;}*/
    }
    if(key==116)
    {
	    if(ftower==1)
		    ftower=0;
	    else
		    ftower=1;
	    if(ftower==1)
	    {printf("ftower:\n");
		    lookx=3.0f;looky=5.0f;lookz=7.0f;}
		    // centerx=0.0f;centery=0.0f;centerz=0.0f;}

}
if(key==13)
{
	if(seltile==0)
		seltile=1;
	else seltile=0;
}
if(key==104)
{
	if(flaggaze==0)
	flaggaze=1;
	else flaggaze=0;
}
if(key==112)
{
	if(third==1)
		third=0;
	else
		third=1;
}
if(key==118)
{
	if(vtil==0)
		vtil=1;
	else vtil=0;
}
if(key==119)
{
	printf("wkey\n");
	if(vtil==1)
		tj-=0.42;
					 printf("view ti:%f tj:%f\n",ti,tj);
}
if(key==97)
{
	if(vtil==1)
		ti-=0.42;
					 printf("view ti:%f tj:%f\n",ti,tj);
}
if(key==115)
{
	if(vtil==1)
		ti+=0.42;
					 printf("view ti:%f tj:%f\n",ti,tj);
}
if(key==122)
{
	if(vtil==1)
		tj+=0.42;
					 printf("view ti:%f tj:%f\n",ti,tj);
}
}
int nojump=0;
void makejump(int value)
{
	if(jump==1)
	{
		printf("heght:%f\n",h);
		if(h<maxh && nojump==0)
			h+=0.05f;
		else if(h>=maxh && nojump==0)
			nojump=1;
		else if(nojump==1 && h>0.0f)
		{
			printf("decr\n");
			h-=0.05f;
		}
		else if(h<=minh)
		{
			printf("neeche\n");
			jump=0;
			nojump=0;
		}
		zcoor+=0.05f;
		ycoor=h;
	}

    glutTimerFunc(1, makejump, 0);
}
float temp;
void handleKeypress2(int key, int x, int y) {
	
//	printf("xcoor:%f zcoor:%f\n",xcoor,zcoor);
	if (key == GLUT_KEY_LEFT)
	{
	/*	if(walk%2==0)
	    strcpy(file,"./fwdfiles/orig2.obj");
	//		mod = glmReadOBJ("./fwdfiles/orig2.obj");
		else
	    strcpy(file,"./fwdfiles/orig1.obj");
		xcoor-=0.01f;
		walk+=1;*/
		flag=int(ang/90)%4;
		ang=-90.0f;
		if(walk%2==0)
	    strcpy(fi,"Robots1.obj");
//			mod = glmReadOBJ("./fwdfiles/orig2.obj");
		else
	    strcpy(fi,"Robots2.obj");
			mod = glmReadOBJ(fi);
			if(flag==1)
			{
				zcoor=-zcoor;
				xcoor=-xcoor;
			}
			else if(flag==2)
			{
				temp=xcoor;
				xcoor=-zcoor;
				zcoor=temp;

				
//				zcoor=0;
			}
			else if(flag==0)
			{
				temp=xcoor;
				xcoor=zcoor;
				zcoor=-temp;
//				zcoor=0;
			}
		glmUnitize(mod);
		glmFacetNormals(mod);
		glmVertexNormals(mod, 90.0);
//		glPushMatrix();
//		glTranslatef(xcoor,ycoor,zcoor);
if(fstair==1)
		{zcoor+=.6f;}
		else
		{zcoor+=0.2f;}
		walk+=1;
//		GLfloat lightPos1[] = {-1.0f, 0.5f, 0.5f, 0.0f};
//		wLfloat lightpos[] = {0.5, 1.0, 1.0, 0.0};
//		glLightfv(GL_LIGHT0, GL_POSITION, lightpos);
	//		mod = glmReadOBJ("./fwdfiles/orig1.obj");
/*		glmUnitize(mod);
		glmFacetNormals(mod);
		glmVertexNormals(mod, 90.0);
		walk=walk+1;
		glPushMatrix();
		glTranslatef(xcoor,0.0f,0.0f);
		xcoor-=0.01f;
		GLfloat lightPos1[] = {-1.0f, 0.5f, 0.5f, 0.0f};
		GLfloat lightpos[] = {0.5, 1.0, 1.0, 0.0};
		glLightfv(GL_LIGHT0, GL_POSITION, lightpos);
		glPushMatrix();
		ang=-90.0f;
		glRotatef(-90,0,1,0);
		glmDraw(mod, GLM_SMOOTH | GLM_TEXTURE | GLM_COLOR);*/
//		glPopMatrix();
//		glPopMatrix();
	}//   tri_x -= 0.1;
	if (key == GLUT_KEY_RIGHT)
	{
//		if(walk%2==0)
//	    strcpy(file,"./fwdfiles/orig2.obj");
	//		mod = glmReadOBJ("./fwdfiles/orig2.obj");
//		else
//	    strcpy(file,"./fwdfiles/orig1.obj");
		flag=int(ang/90)%4;
		ang=90.0f;
		if(walk%2==0)
	    strcpy(fi,"Robots2.obj");
//			mod = glmReadOBJ("./fwdfiles/orig2.obj");
		else
	    strcpy(fi,"Robots1.obj");
			mod = glmReadOBJ(fi);
		glmUnitize(mod);
			if(flag==-1)
			{
				zcoor=-zcoor;
				xcoor=-xcoor;
			}
			else if(flag==0)
			{
				temp=xcoor;
				xcoor=-zcoor;
				zcoor=temp;
//				zcoor=0;
			}
			else if(flag==2)
			{
				temp=xcoor;
				xcoor=zcoor;
				zcoor=-temp;
//				zcoor=0;
			}
		glmFacetNormals(mod);
		glmVertexNormals(mod, 90.0);
//		glPushMatrix();
//		glTranslatef(xcoor,ycoor,zcoor);
if(fstair==1)
{zcoor+=0.6f;}
else
		{zcoor+=0.2f;}
		walk+=1;
//		GLfloat lightPos1[] = {-1.0f, 0.5f, 0.5f, 0.0f};
//		GLfloat lightpos[] = {0.5, 1.0, 1.0, 0.0};
//		glLightfv(GL_LIGHT0, GL_POSITION, lightpos);
/*		if(walk%2==0)
			mod = glmReadOBJ("./fwdfiles/orig2.obj");
		else
			mod = glmReadOBJ("./fwdfiles/orig1.obj");
		glmUnitize(mod);
		glmFacetNormals(mod);
		glmVertexNormals(mod, 90.0);
		walk=walk+1;
		glPushMatrix();
		glTranslatef(xcoor,0.0f,0.0f);
		xcoor+=0.01f;
		ang=90.0f;
		printf("xero:%f\n",xcoor);


		GLfloat lightPos1[] = {-1.0f, 0.5f, 0.5f, 0.0f};
		GLfloat lightpos[] = {0.5, 1.0, 1.0, 0.0};
		glLightfv(GL_LIGHT0, GL_POSITION, lightpos);
		glPushMatrix();
		ang=90.0f;
		glRotatef(90,0,1,0);
		glmDraw(mod, GLM_SMOOTH | GLM_TEXTURE | GLM_COLOR);
		glPopMatrix();
		glPopMatrix();*/
	}
	if (key == GLUT_KEY_UP)
	{
		flag=int(ang/90)%4;
		ang=180.0;
		if(walk%2==0)
	    strcpy(fi,"Robots2.obj");
//			mod = glmReadOBJ("./fwdfiles/orig2.obj");
		else
	    strcpy(fi,"Robots1.obj");
			mod = glmReadOBJ(fi);
		glmUnitize(mod);
			if(flag==0)
			{
				zcoor=-zcoor;
				xcoor=-xcoor;
			}
			else if(flag==1)
			{
				temp=xcoor;
				xcoor=-zcoor;
				zcoor=temp;
//				zcoor=0;
			}
			else if(flag==-1)
			{
				temp=xcoor;
				xcoor=zcoor;
				zcoor=-temp;
//				zcoor=0;
			}
		glmFacetNormals(mod);
		glmVertexNormals(mod, 90.0);
//		glPushMatrix();
//		glTranslatef(xcoor,ycoor,zcoor);
		zcoor+=0.2f;
		walk+=1;
//		GLfloat lightPos1[] = {-1.0f, 0.5f, 0.5f, 0.0f};
//		GLfloat lightpos[] = {0.5, 1.0, 1.0, 0.0};
//		glLightfv(GL_LIGHT0, GL_POSITION, lightpos);
/*		glPushMatrix();
//		ang=90.0f;
		glRotatef(ang,0,1,0);
		glmDraw(mod, GLM_SMOOTH | GLM_TEXTURE | GLM_COLOR);
		glPopMatrix();
		glPopMatrix();*/
	}
	//	tri_y += 0.1;
	if (key == GLUT_KEY_DOWN)
		{
flag=int(ang/90)%4;
		ang=0.0;
		if(walk%2==0)
	    strcpy(fi,"Robots2.obj");
//			mod = glmReadOBJ("./fwdfiles/orig2.obj");
		else
	    strcpy(fi,"Robots1.obj");
			mod = glmReadOBJ(fi);
		glmUnitize(mod);
			if(flag==2)
			{
				zcoor=-zcoor;
				xcoor=-xcoor;
			}
			else if(flag==-1)
			{
				temp=xcoor;
				xcoor=-zcoor;
				zcoor=temp;
//				zcoor=0;
			}
			else if(flag==1)
			{
				temp=xcoor;
				xcoor=zcoor;
				zcoor=-temp;
//				zcoor=0;
			}
		glmFacetNormals(mod);
		glmVertexNormals(mod, 90.0);
//		glPushMatrix();
//		glTranslatef(xcoor,ycoor,zcoor);
		zcoor+=0.2f;
		walk+=1;
//		GLfloat lightPos1[] = {-1.0f, 0.5f, 0.5f, 0.0f};
//		GLfloat lightpos[] = {0.5, 1.0, 1.0, 0.0};
//		glLightfv(GL_LIGHT0, GL_POSITION, lightpos);
}
}
void drawball(float rad) {
	    
	glBegin(GL_TRIANGLE_FAN);
	for(int i=0 ; i<360 ; i++) {
		glVertex2f(rad * cos(DEG2RAD(i)), rad * sin(DEG2RAD(i)));
	}
	glEnd();
}
void handleMouseclick(int xp,int yp) {
	/*		GLint viewport[4];
			GLdouble modelview[16];
			GLdouble projection[16];
			GLfloat winX, winY, winZ;

			GLdouble posX, posY, posZ;
			glGetDoublev( GL_MODELVIEW_MATRIX, modelview );
			glGetDoublev( GL_PROJECTION_MATRIX, projection );
			glGetIntegerv( GL_VIEWPORT, viewport );

			winX = (float)xp;
			winY = (float)viewport[3] - (float)yp;
			glReadPixels( xp, int(winY), 1, 1, GL_DEPTH_COMPONENT, GL_FLOAT, &winZ );

			gluUnProject( winX, winY, winZ, modelview, projection, viewport, &posX, &posY, &posZ);
			posx=posX;//x-coordinate
			posy=posY;//y-coordinate
			posz=posZ;//z-coordinate*/
	posx=xp/(winwidth)*(width)-width/2.0;
	posy=(1-yp/winheight)*height-height/2.0;
	//	printf("posx=%lf posy:%lf\n",posX,posY);
	if(flaggaze==1)
	{towerx=posx;towery=posy;}
}




void drawWorld()
{
	float sx=-2.84;
	float sz=1.98;
	int i;
	for(i=1;i<=6;i++)
	{
		glPushMatrix();
		glTranslatef(sx,-.2,sz);
		glScalef(1,.1,1.0);
		if(fabs(sx-ti)<=0.1 && fabs(sz-tj)<=0.1 && vtil==1)
		{camtilex=ti;camtiley=0.0;camtilez=tj;
			drawcube(_textureId2);}
		else
		drawcube(_textureId);
		sx=sx-.42;
		glPopMatrix();
	}
	printf("sx=%f\n",sx);
}


void drawmiddle(float x, float y, float z)
{
	//glPiushMatrix();
//	glTranslatef(x,y,z);
		if(fabs(x-ti)<=0.1 && fabs(z-tj)<=0.1 && vtil==1)
		{camtilex=ti;camtiley=0.0;camtilez=tj;
			drawcube(_textureId2);}
		else
		drawcube(_textureId);
//	drawcube(_textureId);
//	glPopMatrix();
}

void drawWorld2() // 7*7 world in -x
{
	float sx=-2.4;
	float sz=3.2;
	for(int j=1;j<=7;j++)
	{
		sx=-5.36;
		for(int i=1;i<=7;i++)
		{
			glPushMatrix();
			glTranslatef(sx,-.2,sz);
			glScalef(1.0,.1,1.0);
		if(fabs(sx-ti)<=0.1 && fabs(sz-tj)<=0.1 && vtil==1)
		{camtilex=ti;camtiley=0.0;camtilez=tj;
			drawcube(_textureId2);}
		else
		drawcube(_textureId);
		//	drawcube(_textureId);
			sx=sx-.42;
			glPopMatrix();
		
		}
		printf("sx==%f sz:%f\n",sx,sz);
		sz=sz-.42;
	}
	printf("sz==:%f\n",sz);
}

void drawWorld3() //rotating tile in -x
{
	float sx=-6.4;
	glPushMatrix();
	glTranslatef(sx,-.2,rots_z);
	glScalef(3,.1,3);
	if(rots_z<4.1 || rots_z>5.3)
	{rot_y=0;}
	glRotatef(rot_y,0,1,0);
	drawcube(_textureId);
	glPopMatrix();

}
// world in -z direction
void drawWorld4()
{
	int i,r;
	float sz,sx;
	sz=-0.7f;sx=2.5f;
	for(i=0;i<3;i++)
	{
//		r=rand()%10;
		if((int(strip_z)%2==0 && i==2) || i!=2)
		{
			glPushMatrix();
			glTranslatef(sx,-0.2,sz);
			glScalef(1.0,0.1,1.0);
		if(fabs(sx-ti)<=0.1 && fabs(sz-tj)<=0.1 && vtil==1)
		{camtilex=ti;camtiley=0.0;camtilez=tj;
			drawcube(_textureId2);}
		else
		drawcube(_textureId);
		//	drawcube(_textureId);
			glPopMatrix();
		}
			sz=sz-0.42f;
	}
//			sz=sz-0.1f;
	for(i=0;i<3;i++)
	{
		//		r=rand()%10;
		if((int(str_x)%2==0 && i==2) || i!=2)
		{
			glPushMatrix();
			glTranslatef(sx,-0.2,sz);
			glScalef(1.0,0.1,1.0);
			if(fabs(sx-ti)<=0.1 && fabs(sz-tj)<=0.1 && vtil==1)
			{camtilex=ti;camtiley=0.0;camtilez=tj;
				drawcube(_textureId2);}
			else
				drawcube(_textureId);
			//	drawcube(_textureId);
			glPopMatrix();
		}
		sx=sx-0.42f;
	}
		sx=sx-0.5f;
/*	glPushMatrix();
	glTranslatef(sx,-0.2,sz);
	glRotatef(rotblock,0,1,0);
	glPushMatrix();
	//		xcoor=sx;zcoor=sz;
	glScalef(3.0,0.1,3.0);
	drawcube(_textureId);
	glPopMatrix();
	mod1 = glmReadOBJ("./Gun.obj");
	glPushMatrix();
	glmUnitize(mod1);
	glTranslatef(0.0,0.6,0.0);
	glmFacetNormals(mod1);
	glmVertexNormals(mod1, 90.0);
	glScalef(0.4,0.4,0.4);
	glmDraw(mod1, GLM_SMOOTH | GLM_TEXTURE | GLM_COLOR);
	glPopMatrix();
	glPopMatrix();

*/
}

void obj1()
{    //   float sz=7;
//	float sx=-6.4;
	float sz=6;
	float sx=-5.35;
	glPushMatrix();
	glTranslatef(sx,-.2,sz);
	glScalef(2,.1,2);
	drawcube(_textureId);
	glPopMatrix();
/*	mod1 = glmReadOBJ("./Gun.obj");
	glPushMatrix();
	glmUnitize(mod1);
	glTranslatef(sx,0.6,sz);
	glmFacetNormals(mod1);
	glmVertexNormals(mod1, 90.0);
	glScalef(0.2,0.2,0.2);
	if(fobj1==0)
	{glmDraw(mod1, GLM_SMOOTH | GLM_TEXTURE | GLM_COLOR);}
	glPopMatrix();*/
}


void collision()
{
	printf("epic %f %f\n",lookx,lookz);
	if(lookx>-2.42-.25 && lookx<-2.42+.2)//moving tile in -x 
	{if((lookz > (moving[0].z+.25)) || (lookz < (moving[0].z-.25)))
		{printf("fall %f %f\n",lookx,lookz);
			drop=1;
			ycoor=-10;}
			else
			{
				lookz=moving[0].z;
				conv();
				/*if(flag==-1)
				  {xcoor=moving[0].z;}
				  else if(flag==1)
				  {xcoor=-moving[0].z;}
				  else
				  {printf("flag=%d\n",flag);}
				 */

			}
	}

	if(lookx > 3.75-.8 && lookx<3.75+.9 )
	{if(lookz > moving[2].z+.25 || lookz < moving[2].z-.25)
	{drop=1;
	ycoor=-10;
	}
	else
	{lookz=moving[0].z;
	conv();
	}
	}


	if(lookx < -2.42-.25/*-3.8+.41*/ && lookx > -5.36+.25)//6 tiles in -x direc
	{if(lookz>1.98+.22 || lookz <1.98-.25)
		{drop=1;
			ycoor=-10;
		}
	}


	if(lookx < -6.4+.65 && lookx>-6.4-.65)//rot tile on -x direc
	{
		if(lookz <= rots_z+.65 && lookz > rots_z-.65)
		{
			lookz=rots_z;
			conv();
		}
		else if(lookz >3.4)
		{drop=1;
			ycoor=-10;}
	}

	if(lookx>-5.35-.45 && lookx<-5.35+.45)// tile on which obj1 is placed
	{if(lookz>6+.45 || (lookz<6-.45 && lookz>3.4))
	{drop=1;
	ycoor=-10;
	}
	}

	if(lookz>3.4 &&((lookx>-5.35+.45 && lookx<-5.36+.25) || lookx<-6.4-.65))// fall outside 7*7 world
	{drop=1;
		ycoor=-10;
	}

	if(lookx==-5.35 && lookz==6)
	{fobj1=1;}
	
 if(lookz<-0.12-0.4)
        {    
                if(lookz<-2.5)
                {    
                        drop=1;
                        ycoor=-10;
                }    
                else if(((lookx<2.2-0.5 || lookx >2.2+0.5) && !(lookx<0.44+0.3 && lookx>0.44-0.3) ) && lookz > -1.8)
                {    
                        drop=1;
                        ycoor=-10;
                }    
                else if((lookx<2.2 && lookx>2.2-5.0) && (lookz>-2.0+0.5 || lookz<-2.0-0.5 ))
                {    
                        drop=1;
                        ycoor=-10;
                        printf("girgya x:%f y:%f z:%f\n",lookx,looky,lookz);

                }    
        }    

/*	if(lookx>4.5-.25 && lookx<6.6-.2 && lookz<3.65 && lookz > 3-.65)
	{if(flag2==1)
	{ycoor=ycoor+.08;
	fstair=1;}
	else if(flag2==-1)
	{ycoor=ycoor-.08;
	fstair=1;}
	}
	else
	{fstair=0;
	ycoor=-.2;}
*/

}


void conv()
{
	if(flag2==0)
	{ycoor=looky,zcoor=lookz;}
	if(flag2==1)
	{xcoor=-lookz,ycoor=looky;}
	if(flag2==2)
	{ycoor=looky,zcoor=-lookz;}
	if(flag2==-1)
	{xcoor=lookz,ycoor=looky;}
}



void drawWorld5()//final destination
{
float sx=4.5;
float sz=3;
for(int i=1;i<=5;i++)
{glPushMatrix();
glTranslatef(sx,.08*i,sz);
glScalef(1,.2,3);
drawcube(_textureId);
glPopMatrix();
sx=sx+.42;
}
}
