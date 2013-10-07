import libvirt as lib
import random
from flask import Flask,abort,jsonify,make_response,request
import other
import create_vol
import destroy

def ret_query(vmid):
	return jsonify({ "query": other.vms[int(vmid)]});

def Volume_Query(vol_id):
	return jsonify({ "query": create_vol.volume_list[int(vol_id)]});
