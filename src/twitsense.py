from random import choice

users = ["the_dan_bot","dandrewsify"]

tweets = {'the_dan_bot':['Working with the twitter API',
                         'The Twitter API is easy',
                         'Good times with the twitter API'],
          'dandrewsify':['Not Working with the twitter API',
                         'The Twitter API is hard',
                         'Bad times with the twitter API']
          }

user = choice(users)
tweet = choice(tweets[user])

frame_content = "<div><a target='_parent' href='https://twitter.com/#!/" + user + "'>'" + tweet + "'</a> -" + user + "</div>"

print frame_content
