from xml.etree import ElementTree as ET
 
import libvirt as lib
import create
import other
import os
import create_vol

DISK_TEMPLATE= \
'''<disk type='network' device='disk'> 
        	<source protocol='rbd' name='rbd/chakka'>
                	<host name='meenal-pc' port='6789'/>
        	</source>
        	<target dev='hdb' bus='scsi'/>
		</disk> 
'''
# def make_xml(image_name,hostname):

# 	xml = "<disk type='network' device='disk'> \
#                <source protocol='rbd' name='rbd/"+image_name+r"'>\
#                        <host name='"+hostname+r"' port='6789'/>\
#                </source>\
#                <target dev='hdb' bus='scsi'/>\
#                </disk> ";
#     return xml;

 
def Volume_Attach(vmid,vol_id):
	name=other.vms[int(vmid)];
	# vmid=request.args.get('vmid');
	# name=other.vms[int(vmid)][1];
	connect = lib.open(other.make_path(create.user, create.ip,create.image_id))
	dom=connect.lookupByName(name);
	hostname=os.system('hostname');
    # conn = libvirt.open('remote+ssh://girish@10.1.97.7/')
#    os.system("scp ./try1.xml girish@10.1.97.7:/home/girish/abc.xml")
 #   os.system("ssh girish@10.1.97.7 sudo virsh attach-device somia /home/girish/abc.xml")
    # dom = conn.lookupByName(domain)
    image_name=create_vol.volume_list[vol_id]['name'];
    xml = "<disk type='network' device='disk'> \
               <source protocol='rbd' name='rbd/"+image_name+r"'>\
                       <host name='"+hostname+r"' port='6789'/>\
               </source>\
               <target dev='hdb' bus='scsi'/>\
               </disk> ";
    template = xml;#make_xml(create_vol.volume_list[vol_id]['name'],hostname);
    dom.attachDevice(template)
 
attach_disk('somia', '/mnt/check-disk', 'hdb')