import urllib2,urllib
from BeautifulSoup import BeautifulSoup,BeautifulStoneSoup
from urlparse import urljoin
import json
import pymongo
from pymongo import MongoClient

article_num=0;
final={};
visited=[]
url="http://www.bloomberg.com";
def install_proxy(proxy={'http':'proxy.iiit.ac.in:8080'}):
        urllib2.install_opener(urllib2.build_opener(urllib2.ProxyHandler(proxy)))
        return

def strip( html ):
	if html is None:
		 return None
	return ''.join( BeautifulSoup( html ).findAll( text = True ) ) 

def fetch(url,add_base=False):
        Base_url='http://www.bloomberg.com'
        if add_base is True:
                url=Base_url+url
       	page_request = urllib2.Request(url)
       	return urllib2.urlopen(page_request).read()

def extract(doc):
	l1=[]
	l2=[]
	urls=[];
        soup=BeautifulSoup(doc)
	div = soup.findAll('ul',{'class':'drop_nav'})
	for i in div:
		j=i.findAll('a',{'class':'has_submenu'});
		for p in j:
			l1.append(p);
		j=i.findAll('a');
		for p in j:
			if p in l1:
				continue;
			else:
				if p['href'][0]=='/':
					if(p['href']=='/quickview/'):
						continue;
					l2.append(url+urllib.quote(p['href']));
#				else:
#					l2.append(p['href']);
#	print l2;
	for i in l2:
		readPage(i);
		if i not in visited:
			visited.append(i);
	print final;
	print len(final);
	#store()
def readPage(link):
	article_num=0;
	l=[]
	if link in visited:
		return
	#print "hell"
	print link; 
	soup=BeautifulSoup(fetch(link))
	a=soup.findAll('a',{'data-type':'Story'});
	#print link
	for i in a:
		if(url+i['href'] not in visited):
			l.append(url+urllib.quote(i['href']));
			visited.append(url+i['href']);
	for i in l:
		dictn={}
		cont=""
		s=BeautifulSoup(fetch(i))
		print i;
		a=s.find('h1');
		print a.text
		dictn['title']=a.text;
		story=s.find('div',{'class':'entry_content'});
		if(story is None):
			continue;
		para=story.findAll('p')
		for j in para:
			cont+=" "+j.text
		dictn['content']=cont;
		dictn['url']=i;
		store(dictn);
		final[str(article_num)]=dictn;
		article_num=article_num+1;
	#store()
def store(dictn):
	post=dictn
	client = MongoClient()
	db = client['new']
	posts = db.posts
	post_id = posts.insert(post)

def control(url,apply_proxy=False):
        first=True
        if apply_proxy is True:
                install_proxy()
        
        while url is not None:
		print url;
                if first is True:
                        url = extract(fetch(url,False))
                        first=False
                else:
                        url = extract(fetch(url))
        return
control('http://www.bloomberg.com')
