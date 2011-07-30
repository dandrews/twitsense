from random import choice
import sqlite3 as sqlite

connection = sqlite.connect('../db/twitter.db')

c = connection.cursor()

# c.execute('select * from tweets')
c.execute('select distinct u_id from tweets')

user = choice(c.fetchall())[0]

print user

c.execute('select data from tweets where u_id=%s' % user )

tweet = choice(c.fetchall())[0]

print tweet
