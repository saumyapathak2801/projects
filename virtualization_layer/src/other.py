import json
from uuid import uuid4
import os

machine_list = []
def create_machine_list(filename):
	global machine_list;
	fp = open(filename)
	for line in fp.readlines():
		line = line[:-1]
		if line:
			machines = line.split("@")
			machine_list.append(machines + [str(uuid4())]);
		#print machine_list
	
img_list = []
def create_image_list(filename):	
	global img_list
	imgf = open(filename)
	for line in imgf.readlines():
		line = line[:-1]
		if line:
			img1 = line.split("@")
			img2 = img1[1].split(":")
			img = []
			img.append(img1[0])
			img.append(img2[0])
			img.append(img2[1])
			img_list.append(img)

type_list={};
def create_types(filename):
	global type_list;
	fp = open(filename);
	type_list=json.load(fp);

next_id=0
remotefile="~/";
def next_vmid():
	global next_id
	next_id=next_id+1
	return next_id

vms={}

def make_path(user,ip,image_id):
	#path='qemu:///system';
	#print path
	#user='arpita'
	#print user
	#print ip
	#ip='10.1.97.143'
	#os.system('scp "%s" "%s:%s"' % (image_id, user+'@'+ip,remotefile ) )
	path = 'remote+ssh://' + user + '@' + ip + '/'
	#print path
	return path