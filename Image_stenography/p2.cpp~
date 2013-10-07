#include <stdlib.h>
#include <stdio.h>
#include <math.h>
#include <cv.h>
#include <highgui.h>

int main(int argc, char *argv[])
{
	IplImage *img = 0, *img2=0 ;
	int height,width,step,channels;
	uchar *data, *data2, *dst_data;
	int i,j,k;
	if(argc<3){
		printf("Usage: ./a.out <image-file-name> <watermarker image>\n");
		exit(0);
	}

	// load an image  
	img=cvLoadImage(argv[1]);
	if(!img){
		printf("Could not load image file: %s\n",argv[1]);
		exit(0);
	}

	// get the image data
	height    = img->height;
	width     = img->width;
	step      = img->widthStep;
	channels  = img->nChannels;
	int depth = img->depth;
	int nchannels = img->nChannels;
	data      = (uchar *)img->imageData;
	printf("Processing a %dx%d image with %d channels\n",height,width,channels); 

	/// Check for Watermark Image
	img2=cvLoadImage(argv[2]);
	if(!img2){
		printf("Could not load image file: %s\n",argv[2]);
		exit(0);
	}
	int height2=img2->height;
	int width2=img2->width;
	int step2=img2->widthStep;
	int channels2=img2->nChannels;
	int depth2 = img2->depth;
	data2  = (uchar *)img2->imageData;
	int flag=0;	
	for(i=0;i<height2;i++){
		for(j=0;j<width2;j++){
			if( (data2[i*step2+j*channels2]==255 && (data[i*step+j*channels+0] & 4)==4) || (data2[i*step2+j*channels2]==0 && (data[i*step+j*channels+0] & 4)==0) )
				continue;
			else
			{

				printf("No WaterMark %d %d %d\nWatermark=%d \n",i,j,data[i*step+j*channels+0],data2[i*step2+j*channels2]);
				flag=1;
				break;
			}
		}
		if(flag==1)
			break;

	}
	int a1,a2,a3;
	if(flag==0)
		printf("WaterMark Present\n");
	else
		return 0;
	int size[4]={0};
	for(i=0;i<4;i++)
	{
		a1=data[0+i*channels+0]&3;
		a2=data[0+i*channels+1]&7;
		a3=data[0+i*channels+2]&7;
		size[i]=a1|(a2<<2)|(a3<<5);
	}
	int bytes=size[0] | (size[1]<<8) | (size[2]<<16) | (size[3]<<24);
	printf("count=%d\n",bytes);
	FILE *fpw=fopen("new_audio.mp3","w");
	char ch;
	unsigned char uch;
	int value,count=0,flag2=0;
	for(i=1;i<height;i++){
		for(j=0;j<width;j++){
			if(count>=bytes)
			{
				flag2=1;
				break;
			}
			a1=data[i*step+j*channels+0]&3;
			a2=data[i*step+j*channels+1]&7;
			a3=data[i*step+j*channels+2]&7;
			value=a1|(a2<<2)|(a3<<5);
			uch=value;
			ch=uch;
			fprintf(fpw,"%c",ch);
			count++;
		}
		if(flag2==1)
			break;
	}
	fclose(fpw);
	return 0;
}
