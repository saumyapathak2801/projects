import libvirt as lib
import random
from flask import Flask,abort,jsonify,make_response,request
from uuid import uuid4
import other
import os
import query
import subprocess
img_name="";
pmid_rr=0;
user=""
ip=""
ram=""
cpu=""
image_id = "VM-linux-0.2.2.img";
uuid=""
def create_xml(vm_name, instance_type,image_id):
	global ram
	global cpu
	global img_name
	xml = r"<domain type='" + instance_type + 			\
	    r"'><name>" + vm_name + r"</name>				\
	      <memory>100428</memory>					\
	      <vcpu>1</vcpu>						\
	      <os>							\
	        <type arch='x86_64' machine='pc'>hvm</type>		\
		<boot dev='hd'/>					\
	      </os>							\
	      <features>						\
	        <acpi/>							\
          	<apic/>							\
	      	<pae/>							\
	      </features>						\
	      <on_poweroff>destroy</on_poweroff>			\
  	      <on_reboot>restart</on_reboot>				\
	      <on_crash>restart</on_crash>				\
	      <devices>							\
	        <emulator>/usr/bin/qemu-system-x86_64</emulator>	\
	        <disk type='file' device='disk'>			\
  	        <driver name='qemu' type='raw'/>			\
		<source file='"+other.remotefile+img_name+"'/>		\
		<target dev='hda' bus='ide'/>				\
		<address type='drive' controller='0' bus='0' unit='0'/>	\
		</disk>							\
	      </devices>						\
   	      </domain>"

	return xml;
#VM-linux-0.2.img
def abc(attrs):
	flag=-1;
	#print "hello";
	global img_name;global image_id;
	global pmid_rr;
	global user;global ip;global cpu;global ram;
	try:
		name = attrs['name'];
		#name="vm2";
		instance_type = attrs['instance_type']
		#instance_type = 1;#int(attrs["instance_type"])
		for i in other.type_list['types']:
			for k in i.keys():
				# print k
				# print i[k]
				# if(int(k['tid']) is instance_type):
				if(int(i[k])==int(instance_type)):
					# print "blah"
					cpu=i["cpu"];
					ram=i["ram"];
		image = int(attrs['image_id']);
		print cpu
		print ram
		#img_name = "image.img";
		# user = other.img_list[image][0];
		# ip = other.img_list[image][1];
		# image_id = other.img_list[image][2];
		# img_name = image_id.split('/');
		# img_name = img_name[-1];
		# os.system('scp "%s:%s" "%s" ' % (user+'@'+ip,image_id, '/home/saumya/' ) )
		# image_id = "/home/saumya/padhai/sem5/cloud/project/image.img";
		#mage_id = "image1.img";
		# print user;
		pmid_initial=pmid_rr;
		machine=other.machine_list[pmid_rr];
		user=machine[0];
		ip=machine[1];
		# status,mac_space=commands.getstatusoutput("ssh "+ user+"@"+ip+" free -m");
		# status,mac_cpu=commands.getstatusoutput("ssh "+ user+"@"+ip+" nproc");
		#mach_cpu=int(subprocess.check_output("ssh "+user+"@"+ip+" nproc",shell=True));
		#mach_space=subprocess.check_output("ssh "+user+"@"+ip+" free -m",shell=True);
		os.system("ssh "+ user+"@"+ip+" free -m | head -n2 | tail -n1  > ramspace");
		os.system("ssh "+user+"@"+ip+" nproc > cp");
		space=[]
		cpval=[];
		mach_space=[];
		fp1=open("ramspace");
		for line in fp1.readlines():
			space=line.split();
			mach_space=space[3];
			#print mach_space
		fp2=open("cp");
		for line in fp2.readlines():
			#print line
			cpval=line[0];
			#print cpval
		# print mach_space
		# print mach_cpu
		free=int(mach_space);
		mach_cpu=int(cpval[0])
		#print free 
		#print mach_cpu
		#mac1=mach_space.split('\n');
		# mac2=mac1[1].split();
		# free=int(mac2[3]);
		# print free;print ram;print mac_cpu;
		# sys.stdout.flush()
		# print cpu
		# print cpu
		# print ram
		# print mach_cpu
		# print free
		while(mach_cpu<int(cpu) or int(ram)> free):
			pmid_rr=pmid_rr+1;
			print "hell";
			# sys.stdout.flush()
			if(pmid_rr%len(other.machine_list)==pmid_initial%len(other.machine_list)):
				flag=1;
				break;
			else:
				flag=0;
			machine=other.machine_list[pmid_rr];
			user=machine[0];
			ip=machine[1];
			os.system("ssh "+ user+"@"+ip+" free -m | head -n2 | tail -n1  > ramspace");
			os.system("ssh "+user+"@"+ip+" nproc > cp");
			# space=[]
			# mach_cpu=[];
			# mach_space=[];
			fp1=open("ramspace");
			print pmid_rr%len(other.machine_list)
			for line in fp1.readlines():
				space=line.split();
				mach_space=space[3];
			#print line
			fp2=open("cp");
			for line in fp2.readlines():
				mach_cpu=line[0];
			free=int(mach_space);
			print mach_space,mach_cpu
			#print "sp"+mac_space
			#print "ram"+mac_cpu
			# mac1=mach_space.split('\n');
			# mac2=mac1[1].split();
			# free=mac2[3];
			# mac2=mac1[2].split();
			# ram=mac2[2];
			# if(int(mac_cpu) < int(cpu) or int(ram) > int(free)):
		if(flag==1):
			return "not created";
				
			
		user = other.img_list[image][0];
		ip = other.img_list[image][1];
		image_id = other.img_list[image][2];
		img_name = image_id.split('/');
		img_name = img_name[-1];
		# print 'scp %s:%s %s ' % (user+'@'+ip,image_id, '~/' )
		os.system('scp %s:%s %s ' % (user+'@'+ip,image_id, '~/' ) );
		machine = other.machine_list[pmid_rr%len(other.machine_list)]
		user = machine[0]
		ip = machine[1]
		# user='girish';
		# ip='10.1.97.7';
		#print user + ip
		image_id = "~/"+img_name;
		other.remotefile="/home/"+user+"/";
		# print 'scp "%s" "%s:%s"' % ('~/'+img_name, user+'@'+ip,other.remotefile )
		os.system('scp %s %s:%s' % ('~/'+img_name, user+'@'+ip,other.remotefile ) )
		connect = lib.open(other.make_path(user, ip,image_id))
		#connect = lib.open("qemu:///system");
		req = connect.defineXML(create_xml(name, connect.getType().lower(),image_id))
		#req = connect.defineXML(create_xml(name,"kvm",image_id))
		try:
			req.create()
		except:
			return "byeerror"
		vmid = other.next_vmid();
		#vmid=1;
		pmid=machine[2];
		#other.vms.append(int(vmid),name, instance_type,pmid);
		other.vms[vmid] = [vmid, name, instance_type,pmid];
		pmid_rr= pmid_rr + 1;
	#	vmid=1;
		#print vmid;
		image_id = other.img_list[image][2];
		return jsonify({ "vmid": vmid });
	except:
		 return "kasjdhskjderror";
# print "bye";
