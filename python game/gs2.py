#!/usr/bin/python
row=30
col=60
from curses import initscr,curs_set,noecho,start_color,newwin,endwin,KEY_RIGHT,KEY_LEFT,KEY_DOWN,KEY_UP,init_pair,COLOR_BLUE,COLOR_GREEN,COLOR_YELLOW,COLOR_BLACK,color_pair,A_BLINK,COLOR_RED
initscr()
noecho()
start_color()
init_pair(1,COLOR_GREEN,COLOR_BLACK)
init_pair(2,COLOR_YELLOW,COLOR_BLACK)
init_pair(3,COLOR_BLUE,COLOR_BLACK)
init_pair(4,COLOR_RED,COLOR_BLACK)
win=newwin(150,150,0,0);win.keypad(1);win.nodelay(1);
win.timeout(-1)
win.addstr(15,60,'Beware of @',color_pair(2))
key=win.getch()
while key!=10:
	win.touchwin()
	win.erase()
	win.refresh()
	win=newwin(150,150,0,0)
	win.timeout(-1)
	win.addstr(15,60,'Beware of @',color_pair(2))
	key=win.getch()
win.touchwin()
win.erase()
win.refresh()
endwin()
from random import randrange
curs_set(0);win = newwin(90,90,0,0);win.keypad(1);win.nodelay(1);win.border('|','|','-','-','+','+','+','+')
global flag
global fl
global level
global bndrys
global bombs
class game:
	pass
def ini(row,col,start,end,robodim,scoremul,difcod,win):
	self=game()
	global t
	global tot
	global score
	self.row=row
	self.nob=0
	self.difcod=difcod
	tot=0
	self.col=col
	self.start=start
	self.end=end
	self.robo=[[start,end]]
	self.key=KEY_RIGHT
	self.yold1=2
	self.xold1=2
	self.yold2=2
	self.xold2=2
	self.dim=robodim
	self.time_out=180
	self.i=1
	self.j=0
	self.score=scoremul
	self.dis=0
	self.i=2
	self.j=2
	def gen_bomb(level,win):
		self.nob=level
		j=0
		while j<level:
			q1=random.randrange(1,self.row-1)
			l1=random.randrange(1,self.col-1)
			win.addch(q1,l1,'*',color_pair(2))
			j=j+1
		j=0
		while j<difcod*level:
			q=random.randrange(1,self.row-1)
			l=random.randrange(1,self.col-1)
			if q!=q1 and l!=l1:
				win.addch(q,l,'D',color_pair(3))
				j=j+1
		        q1=q;l1=l
		j=0
	def addchar(y,x,win):
		if (win.inch(y,x) & 255)==ord('D'):
			self.time_out-=10
			global tot
			self.dis=self.dis+1
			tot+=1
		elif (win.inch(y,x) & 255)==ord('*'):
			if self.dis!=self.difcod:
				bombs=1
				flag=1
				return 0
			else:
				self.nob=self.nob-1
				self.dis=0
				if self.nob==0:
					fl=1
					return -1
		elif (win.inch(y,x)&255)==ord('@'):
			flag=1
			return 0

		win.addch(y,x,'R',color_pair(1))
	def addmine(win):
		y=randrange(1,self.row-1)
		x=randrange(1,self.col-1)
		if win.inch(y,x)&255==ord(' '):
			win.addch(y,x,'@',color_pair(4))
			win.addch(self.j,self.i,' ')
			self.j=y;self.i=x
	def addnerase(y,x,win,key):
		flag=0
		global tot
		fl=0
		while key!=27:
			win.addstr(0,2,' Diffuse codes: '+str(tot)+' ')
			win.addstr(0,30,'Codes needed per bomb: '+str(self.difcod)+' ')
			p=self.dim
			addmine(win)
			i=1
			j=0
			y=self.robo[0][0]
			x=self.robo[0][1]
			if (y+self.dim>=self.row or y<=0) or (x+self.dim>=self.col or x<1):
				bndrys=1
				return 0
			win.timeout(self.time_out)
			m=x
			n=y
			b=y
			a=x
			key2=win.getch()
			key3=key
			if key2!=-1:
			 	key=key2
			else:
			 	key=key
			while j<self.dim:
			 	g=addchar(b,a,win)
			 	if g==-1:
					fl=1
			 		break
				elif g==0:
					flag=1
					break
			 	while i<p:
			 		g=addchar(b,a+1,win)
			 		if g==-1:
#						print 'x'
						fl=1
			 			break
					elif g==0:
						flag=1
						break
			 		a=a+1
			 		i=i+1
			 	if flag==1 or fl==1:
			 		break
			 	i=1
			 	b=n
			 	a=m
			 	while i<p:
			 		g=addchar(b+1,a,win)
			 		if g==-1:
						fl=1
			 			break
					elif g==0:
						flag=1
						break
			 		b=b+1
			 		i=i+1
			 	if flag==1 or fl==1:
			 		break
			 	i=1
			 	b=n
			 	a=m
			 	if key3==KEY_LEFT or key3==KEY_RIGHT:
			 		self.yold1=y
			 		while i<=self.dim:
			 			win.addch(self.yold1,self.xold1,' ')#,curses.color_pair(1))
			 			self.yold1=self.yold1+1
			 			i=i+1
			 		i=1 
			 	elif key3==KEY_UP or key3==KEY_DOWN:
			 		self.xold2=x
			 		while i<=self.dim:
			 			win.addch(self.yold2,self.xold2,' ')#,curses.color_pair(1))
			 			self.xold2=self.xold2+1
			 			i=i+1
			 		i=1 
			 	n=n+1
			 	m=m+1
			 	j=j+1
			 	b=n
			 	p=p-1
			 	i=1
			 	a=m
			if flag==1 or fl==1:
				if flag==1:
					return 0
				else:
					return -1
			 	break
			if key==KEY_LEFT:
				self.robo.insert(0,[y,x-1])
				self.yold1=y
				self.xold1=x+self.dim-1
				self.yold2=y
				self.xold2=x
			elif key==KEY_RIGHT:
				self.robo.insert(0,[y,x+1])
				self.yold1=y
				self.xold1=x
				self.yold2=y
				self.xold2=x
			elif key==KEY_UP:
				self.robo.insert(0,[y-1,x])
				self.yold1=y
				self.xold1=x
				self.yold2=y+self.dim-1
				self.xold2=x
			elif key==KEY_DOWN:
				self.robo.insert(0,[y+1,x])
				self.yold1=y
				self.xold1=x
				self.yold2=y
				self.xold2=x
		if key==27:
			return 0
	gen_bomb(level,win)
	y=self.robo[0][0]
	x=self.robo[0][1]
	t=addnerase(y,x,win,KEY_RIGHT)
level=1
while level<=3:
 	from curses import initscr,curs_set,newwin,endwin,KEY_RIGHT,KEY_LEFT,KEY_DOWN,KEY_UP;from random import randrange;initscr();curs_set(0);win = newwin(row,col,0,0);win.keypad(1);win.nodelay(1);win.border('|','|','-','-','+','+','+','+')
	import random
	import curses
	initscr()
	row=30
	col=60
	start=12
	end=7
	dim=2
	score=10
	difcod=3
	ini(row,col,start,end,dim,score,difcod,win)
#	a.gen_bomb(level,win)
	j=0
	dis=0
	flag=0
	fl=0
#	y=a.robo[0][0]
#	x=a.robo[0][1]
#	t=a.addnerase(y,x,win,KEY_RIGHT)
	if t==-1:
		level=level+1
		if level!=3:
			win.erase()
			endwin()
			win=newwin(90,90,0,0)
			win.addstr(15,50,'Wanna play THE NEXT LEVEL??\n',curses.A_BOLD|color_pair(1))
			win.addstr(16,52,'Press y:yes,or n:no...\n',color_pair(2))
			key=win.getch()
#			if key==ord('n'):
#				break
#			elif key==ord('y'):
#				continue
#			else:
#				key=win.getch()
			while key!=ord('y') and key!=ord('n'):
				win.erase()
				endwin()
				win=newwin(90,90,0,0)
				win.addstr(15,50,'Wanna play THE NEXT LEVEL??\n',curses.A_BOLD|color_pair(1))
				win.addstr(16,52,'Press y:yes,or n:no...\n',color_pair(2))
				key=win.getch()
			if key==ord('n'):
#	win.erase()
#				endwin()
				break
			elif key==ord('y'):
				win.touchwin()
				win.erase()
				win.refresh()
				endwin()
				continue
		else:
			win.erase()
			endwin()
			win=newwin(90,90,0,0)
			win.timeout(-1)
			win.addstr(14,50,'YOU WIN :D !!!',curses.A_BOLD|color_pair(4))
			win.addstr(15,50,'Thanks for playing',curses.A_BOLD|color_pair(1))
			win.addstr(16,52,'Your score: '+str(tot*score)+' ',color_pair(2))
	#		win.addstr(16,52,'Press y:yes,or n:no...\n',color_pair(2))
			key=win.getch()
			while key!=10:
				win.erase()
				endwin()
				win=newwin(90,90,0,0)
				win.timeout(-1)
				win.addstr(14,50,'YOU WIN :D !!!',curses.A_BOLD|color_pair(4))
				win.addstr(15,50,'Thanks for playing',curses.A_BOLD|color_pair(1))
				win.addstr(16,52,'Your score: '+str(tot*score)+' ',color_pair(2))
				key=win.getch()
			endwin()
			break
	elif t==0:
		win.erase()
		endwin()
		win=newwin(90,90,0,0)
		win.timeout(-1)
		win.addstr(15,50,'You Fail\n',curses.A_BOLD|color_pair(1))
		win.addstr(16,52,'Your score: '+str(tot*score)+' ',color_pair(2))
		key=win.getch()
		while key!=10:
			win.erase()
			endwin()
			win=newwin(90,90,0,0)
			win.timeout(-1)
			win.addstr(15,50,'You Fail\n',curses.A_BOLD|color_pair(1))
			win.addstr(16,52,'Your score: '+str(tot*score)+' ',color_pair(2))
			key=win.getch()
		endwin()
		break
endwin()
print "\nThanks for playing"









































