import libvirt as lib
import other
from flask import Flask,abort,jsonify,make_response,request
import create
import sys
import query
import destroy
import create_vol
#import attach

app = Flask(__name__);

@app.route('/vm/create')
def parse():
	response={};
	name = request.args.get('name');
	instance_type = request.args.get('instance_type');
	image_id = request.args.get('image_id');
	response['name'] = name;
	response['instance_type'] = instance_type;
	response['image_id'] = image_id;
	r=create.abc(response); 
	return r;

@app.route('/vm/query')
def query_response():
	req={}
	vmid=request.args.get('vmid');
	r=query.ret_query(vmid);
	return r;

@app.route('/vm/destroy')
def mac_destroy():
	req={}
	vmid=request.args.get('vmid');
	name=other.vms[int(vmid)][1];
	connect = lib.open(other.make_path(create.user, create.ip,create.image_id))
	dom=connect.lookupByName(name);
	try:
		dom.destroy();
		dom.undefine();
		return "1";
	except:
		return "0";

@app.route('/vm/types')
def VM_Type():
	return jsonify(other.type_list);

@app.route('/image/list')
def list_images():
	t={}
	l=[]
	for i in range(len(other.img_list)):
		name=other.img_list[i][2].split('/');
		name=name[-1];
		l.append({"id":i,"name":name});
	return jsonify({"images":l});

@app.route('/volume/create')
def vol_create():
	name=request.args.get('name');
	size=request.args.get('size');
	r=create_vol.Volume_Creation(name,size);
	return jsonify({"volumeid":r});
	# return r;

@app.route('/volume/destroy')
def vol_destroy():
	vol_id=request.args.get('volumeid');
	r=destroy.Volume_Destroy(vol_id);
	return jsonify({"status":r});
	# return r;

@app.route('/volume/query')
def vol_query():
	vol_id=request.args.get('volumeid');
	r=query.Volume_Query(vol_id);
	# return jsonify({"volumeid":r});
	return r;

@app.route('/volume/attach')
def vol_attach():
	vmid=request.args.get('vmid');
	vol_id=request.args.get('volumeid');
	r=attach.Volume_Attach(vmid,vol_id);
	return jsonify({"status":r});
	

if __name__ == "__main__":
	other.create_machine_list(sys.argv[1]);
	other.create_image_list(sys.argv[2]);
	other.create_types(sys.argv[3]);
	app.run(debug = True);

