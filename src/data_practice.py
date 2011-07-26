import sqlite3 as sqlite

connection = sqlite.connect('../db/twitter.db')

c = connection.cursor()

c.execute('select * from tweets')

for row in c:
    print row
