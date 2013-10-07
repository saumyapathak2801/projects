export LD_LIBRARY_PATH=/usr/local/lib:/home/LOCAL_USER_NAME/OpenCV/OpenCV-2.4.2/build/lib:$LD_LIBRARY_PATH
export PKG_CONFIG_PATH=/usr/local/lib/pkgconfig:$PKG_CONFIG_PATH
export CLASSPATH=/usr/share/java/mysql.jar:/usr/include/mysql++:$CLASSPATH
g++  -g -Wno-unused-function $(pkg-config --cflags --libs opencv)   prog1.cpp   -o opencv-test

