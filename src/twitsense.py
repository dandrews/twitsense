import sqlite3 as sqlite
from random import choice

def tweet():

    connection = sqlite.connect('../db/twitter.db')

    c = connection.cursor()

    c.execute('select distinct u_id from tweets')

    user = choice(c.fetchall())[0]

    c.execute('select data from tweets where u_id=%s' % user )

    tweet = choice(c.fetchall())[0]

    # users = ["the_dan_bot","dandrewsify"]

    # tweets = {'the_dan_bot':['Working with the twitter API',
    #                          'The Twitter API is easy',
    #                          'Good times with the twitter API'],
    #           'dandrewsify':['Not Working with the twitter API',
    #                          'The Twitter API is hard',
    #                          'Bad times with the twitter API']
    #           }

    # user = choice(users)
    # tweet = choice(tweets[user])

    frame_content = "<html><body><div><a target='_parent' href='https://twitter.com/#!/%s'>'%s'</a> - @%s</div></body></html>" % (user,tweet,user)

    print frame_content

tweet()    
