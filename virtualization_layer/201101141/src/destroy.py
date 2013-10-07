import libvirt as lib
import random
from flask import Flask,abort,jsonify,make_response,request
import other
import create
import create_vol

def destroyvm(vmid):
	#n=int(vmid);
	name=other.vms[int(vmid)][1];
	# name=other.vms[vmid][1];
	connect = lib.open(other.make_path(create.user, create.ip,create.image_id))
	dom=connect.lookupByName(name);
	try:
		dom.destroy();
		return 1;
	except:
		return 0;

def Volume_Destroy(vid):
	try:
		# print create_vol.mydir[int(vid)-1]['name']
		os.system("sudo rbd unmap /dev/rbd/rbd/" + create_vol.volume_list[int(vid)-1]['name'])
		os.system("sudo rbd rm " + create_vol.volume_list[int(vid)-1]['name'])
		create_vol.volume_list[int(vid)-1]['status']="deleted";
		return {"status":"1"}
		
	except:
		return {"status":"0"}

