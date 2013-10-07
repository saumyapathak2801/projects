#include <stdlib.h>
#include <stdio.h>
#include <math.h>
#include <cv.h>
#include <highgui.h>
#include<string.h>


int main(int argc, char *argv[])
{
	IplImage *img = 0, *img2=0 ;
	int height,width,step,channels;
	uchar *data, *data2;
	int i,j,k;

	if(argc<4){
		printf("Usage: ./a.out <image-file-name> <watermarker image> <audio file>\n");
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
	int nchannels = img->nChannels;
	data      = (uchar *)img->imageData;
	printf("Processing a %dx%d image with %d channels:%d\n",height,width,channels); 

	/// Load Watermark Image
	img2=cvLoadImage(argv[2]);
	if(!img2){
		printf("Could not load image file: %s\n",argv[2]);
		exit(0);
	}
	int height2=img2->height;
	int width2=img2->width;
	int step2=img2->widthStep;
	int channels2=img2->nChannels;
	data2  = (uchar *)img2->imageData;
	
	///// Inserting Watermark
	for(i=0;i<height2;i++){
		for(j=0;j<width2;j++){
			data[i*step+j*channels+0]= (data[i*step+j*channels+0] & 251);
			if(data2[i*step2+j*channels2])
			{
				data[i*step+j*channels+0]= (data[i*step+j*channels+0] | 4 );
				//count
			}
		}
	}

	//Read an audio file and write into the image
	FILE *fp=fopen(argv[3],"r");
	if(fp==NULL){
		printf("Could not load audio file: %s\n",argv[3]);
		exit(0);
	}
	char ch;int count1=0,col_count=0,row_count=1;
	unsigned char uch;
	int a1,a2,a3,a4,val1,val2;
	while(fscanf(fp,"%c",&ch)!=EOF)
	{
		count1++;
		uch=ch;
		//printf("uch:%c\n",uch);
		int val=uch;
		if(col_count>=width)
		{
			col_count=0;
			row_count++;
		}
		a1=val%4;
		a2=val%32;
		a3=val%256;
		val1=(a2-a1)>>2;
		val2=(a3-a2)>>5;
//		printf("seg %d\n",row_count*step+col_count*channels);
//		printf("seg %d\n",data[row_count*step+col_count*channels+0]);
		//printf("val:%d\n",val);
		data[row_count*step+col_count*channels+0]= (data[row_count*step+col_count*channels+0] &252);
		data[row_count*step+col_count*channels+1]= (data[row_count*step+col_count*channels+1] &248);
		data[row_count*step+col_count*channels+2]= (data[row_count*step+col_count*channels+2] &248);
		data[row_count*step+col_count*channels+0]= (data[row_count*step+col_count*channels+0] |a1);
		data[row_count*step+col_count*channels+1]= (data[row_count*step+col_count*channels+1] |val1);
		data[row_count*step+col_count*channels+2]= (data[row_count*step+col_count*channels+2] |val2);
		col_count++;
	}
	fclose(fp);


	//printf("%d row=%d col=%d \n",count1,row_count,col_count);

	// Extract bit form count of total no. of Bytes which are presence in audio file 
	a1=count1%256;
	a2=count1%65536;
	a3=count1%16777216;
	a4=count1%4294967296;
	//printf("%d %d %d %d\n",a1,(a2-a1)>>8,(a3-a2)>>16,(a4-a3)>>24);
	int size[4]={0};
	size[0]=a1;
	size[1]=(a2-a1)>>8;
	size[2]=(a3-a2)>>16;
	size[3]=(a4-a3)>>24;

	printf("bytes=%d\n", size[0] | (size[1]<<8) | (size[2]<<16) | (size[3]<<24));
/*number of count inser in to the image  */


	for(i=0;i<4;i++)
	{
		a1=size[i]%4;
		a2=size[i]%32;
		a3=size[i]%256;
		val1=(a2-a1)>>2;
		val2=(a3-a2)>>5;
		data[0+i*channels+0]= (data[0+i*channels+0] &252);
		data[0+i*channels+1]= (data[0+i*channels+1] &248);
		data[0+i*channels+2]= (data[0+i*channels+2] &248);
		data[0+i*channels+0]= (data[0+i*channels+0] |a1);
		data[0+i*channels+1]= (data[0+i*channels+1] |val1);
		data[0+i*channels+2]= (data[0+i*channels+2] |val2);

	}
	cvSaveImage("new_image.png", img );
	 // create a window
	cvNamedWindow("mainWin", CV_WINDOW_AUTOSIZE); 
	cvMoveWindow("mainWin", 100, 100);

	// show the image
	cvShowImage("mainWin", img );

	// wait for a key
	cvWaitKey(0);

	// release the image
	cvReleaseImage(&img );
	return 0;
}
