import json
from uuid import uuid4
import os

volume_list={}
vol_id=0;
def Volume_Creation(name,size):
	global volume_list
	global vol_id;
	tot_size = int(float(size)*(1024**3));

	try:
		os.system("sudo rbd create " + str(name) + " --size " + str(tot_size) + " -k /etc/ceph/ceph.client.admin.keyring");
		os.system("sudo modprobe rbd");
		os.system("sudo rbd map " + str(name) + " --pool rbd --name client.admin -k /etc/ceph/ceph.client.admin.keyring");

		new_vol={}
		new_vol['name']=name;
		new_vol['size']=size;
		new_vol['status']="available";
		vol_id=vol_id+1;
		volume_list[vol_id]=new_vol;
		


		return { "volumeid" : vol_id };

	except:
		 return { "volumeid" : "0"};



