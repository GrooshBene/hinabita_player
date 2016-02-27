# coding : UTF-8
import MySQLdb
import sys
import glob
import os
from os import path
 
db = MySQLdb.connect("localhost", 'hinabita', 'prec', 'hinabita')

cursor = db.cursor()

id=0
cursor.execute("set names utf8")
cursor.execute("DROP TABLE IF EXISTS MUSICLIST")

tablequery = """CREATE TABLE MUSICLIST (
        apimusicurl CHAR(50) NOT NULL,
		musicurl CHAR(50) NOT NULL,
		musictitle CHAR(50) NOT NULL,
		musicid INT,
		thumbnail CHAR(50) NOT NULL)"""
cursor.execute(tablequery)

tree = glob.glob('*.mp3')
for i in tree:
    apimusictree = '../_/'+i.decode('utf8')
    musictree = './_/'+i.decode('utf8')
    thumbnail = '../__/'+i.decode('utf8')
    id+=1 
    musictitle = i.decode('utf8')
    print musictitle
    musicquery = "INSERT INTO MUSICLIST( \
    		apimusicurl ,musicurl, musictitle, musicid, thumbnail) \
    		VALUES ('"+apimusictree+"', '"+musictree+"', '"+musictitle+"', '"+str(id)+"', '"+thumbnail+"')"
    try:
    	cursor.execute(musicquery)
    	db.commit()
    	print 'complete'
    except:
    	db.rollback()

db.close()
