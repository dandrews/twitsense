import twitter

# client = twitter.Api(consumer_key='jW2fTJyPktYZTiyKDC1GkQ'
#                   ,consumer_secret='xbDiMW43X7Qd3pZlTTEdk0CgeCL8Y5pOwghY9exOg'
#                   ,access_token_key='43567574-6FcIg1u3O1Bd6TABc5sXjtN1zlfy9qkL4c5xfMqQA'
#                   ,access_token_secret='xCXd7fScCdQiefKlnhfrLY3jH6P8BOI054hYV6J6F1M')


# latest_posts = client.GetUserTimeline("the_dan_bot")

# Request Token:
#     - oauth_token        = MiCcrMqH3K0w9oduFst1j45A1HY8slXh5p8uBwYdtdo
#     - oauth_token_secret = LS5CSmglAlQ2p7xJQk31YR3B9WXO9bhZQQ8xp0NLipw

# Go to the following link in your browser:
# http://twitter.com/oauth/authorize?oauth_token=MiCcrMqH3K0w9oduFst1j45A1HY8slXh5p8uBwYdtdo

# Have you authorized me? (y/n) y
# What is the PIN? YXRNHLBowf9mkOs29nnhcKaLT4h8zDvUpWMPYJPnLgI
# Access Token:
#     - oauth_token        = 330118333-VHa7nvEJvkm7GypYyMrlei8vOgK8UqFTt9rSNLW6
#     - oauth_token_secret = F27EyQ9rFla5Kihj7XXqoLkov7sOt4r0aMZ7l2NMH0

# You may now access protected resources using the access tokens above.



# client = twitter.Api(consumer_key='jW2fTJyPktYZTiyKDC1GkQ'
#                    ,consumer_secret='xbDiMW43X7Qd3pZlTTEdk0CgeCL8Y5pOwghY9exOg'
#                    ,access_token_key='330118333-VHa7nvEJvkm7GypYyMrlei8vOgK8UqFTt9rSNLW6'
#                    ,access_token_secret='F27EyQ9rFla5Kihj7XXqoLkov7sOt4r0aMZ7l2NMH0')

# update = client.PostUpdate('Good times with the twitter API')

# latest_posts = client.GetUserTimeline("the_dan_bot")

# print [s.text for s in latest_posts]


client = twitter.Api()
latest_posts = client.GetUserTimeline("the_dan_bot")
print [s.text for s in latest_posts]
