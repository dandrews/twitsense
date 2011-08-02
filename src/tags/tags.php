<?php
/*
Plugin Name: Twitsense Twitter Widget
Plugin URI: http://dandrewsify.com/twitsense-twitter-widget/
Description: Display the <a href="http://twitter.com/">Twitter</a> latest updates from a Twitter user inside your theme's widgets. Customize the number of displayed Tweets, filter out replies, and include retweets.
Version: 1.0.5
Author: Dandrewsify
Author URI: http://dandrewsify.com/
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// inits json decoder/encoder object if not already available
global $wp_version;
if ( version_compare( $wp_version, '2.9', '<' ) && !class_exists( 'Services_JSON' ) ) {
	include_once( dirname( __FILE__ ) . '/class.json.php' );
}

if ( !function_exists('wpcom_time_since') ) :
/*
 * Time since function taken from WordPress.com
 */

function wpcom_time_since( $original, $do_more = 0 ) {
        // array of time period chunks
        $chunks = array(
                array(60 * 60 * 24 * 365 , 'year'),
                array(60 * 60 * 24 * 30 , 'month'),
                array(60 * 60 * 24 * 7, 'week'),
                array(60 * 60 * 24 , 'day'),
                array(60 * 60 , 'hour'),
                array(60 , 'minute'),
        );

        $today = time();
        $since = $today - $original;

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
                $seconds = $chunks[$i][0];
                $name = $chunks[$i][1];

                if (($count = floor($since / $seconds)) != 0)
                        break;
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

        if ($i + 1 < $j) {
                $seconds2 = $chunks[$i + 1][0];
                $name2 = $chunks[$i + 1][1];

                // add second item if it's greater than 0
                if ( (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) && $do_more )
                        $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        }
        return $print;
}
endif;

if ( !function_exists('http_build_query') ) :
    function http_build_query( $query_data, $numeric_prefix='', $arg_separator='&' ) {
       $arr = array();
       foreach ( $query_data as $key => $val )
         $arr[] = urlencode($numeric_prefix.$key) . '=' . urlencode($val);
       return implode($arr, $arg_separator);
    }
endif;

class Twitsense_Twitter_Widget extends WP_Widget {

	function Twitsense_Twitter_Widget() {
		$widget_ops = array('classname' => 'widget_twitter', 'description' => __( 'Display public tweets from Twitter') );
		parent::WP_Widget('twitter', __('Twitsense'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title']);
		if ( empty($title) ) $title = __( 'Twitter Updates' );

		echo "{$before_widget}{$before_title}<a href='" . esc_url( "http://dandrewsify.com" ) . "'>" . esc_html($title) . "</a>{$after_title}";

		if ( !$tweets = wp_cache_get( 'widget-twitter-' . $this->number , 'widget' ) ) {

			/**
			 * The exclude_replies parameter filters out replies on the server. If combined with count it only filters that number of tweets (not all tweets up to the requested count)
			 * If we are not filtering out replies then we should specify our requested tweet count
			 */

            // $search_url = "http://search.twitter.com/search.json?q=%23friendship";

            // rice or beans and cheese: http://twitter.com/#!/search/rice%20or%20beans%20and%20cheese
            // fake latin fun: http://twitter.com/#!/search/fake%20latin%20and%20fun
            // ignore me please #friend: http://twitter.com/#!/search/ignore%20me%20please%20%23friend
            // $public_tweets = 'https://api.twitter.com/1/statuses/public_timeline.json';

            // $cached_tweets = 'http://atlatler.com/twitsense/tweets.json';
          // love%20OR%20hate

          $search_tweets_by_tags = "http://search.twitter.com/search.json?q=";

          $tags = get_tags();
          $tag_count = 0;
          foreach ($tags as $tag){
            $search_tweets_by_tags .= $tag->name . '%20OR%20';
            // echo $tag->name . "\n";
            if ($tag_count == 3){
              break;
            } else {
              $tag_count++;
            }
          }

          $search_json_url = esc_url_raw( $search_tweets_by_tags, array('http', 'https') );

          // echo $search_json_url;

          $response = wp_remote_get( $search_json_url, array( 'User-Agent' => 'Twitsense Twitter Widget' ));

            // echo "<p><b>DANDREWS</b></p>";

            // echo "<p>response"; 

            // print_r ($response);

            
            // echo "</p>";

			$response_code = wp_remote_retrieve_response_code( $response );

             // echo "<p>response code {$response_code}</p>";
            
			if ( 200 == $response_code ) {
				$tweets = wp_remote_retrieve_body( $response );
				$tweets = json_decode( $tweets, true );
				$expire = 900;
				if ( !is_array( $tweets ) || isset( $tweets['error'] ) ) {
					$tweets = 'error';
					$expire = 300;
				}
			} else {
				$tweets = 'error';
				$expire = 300;
				wp_cache_add( 'widget-twitter-response-code-' . $this->number, $response_code, 'widget', $expire);
			}

			wp_cache_add( 'widget-twitter-' . $this->number, $tweets, 'widget', $expire );
		}

        if ($response_code != 200 ) {
          
          $response = wp_remote_get( $cached_json_url );
          $response_code = wp_remote_retrieve_response_code( $response );            

          if ( 200 == $response_code ) {
              
            $tweets = wp_remote_retrieve_body( $response );
            $tweets = json_decode( $tweets, true );
            $expire = 900;
          } else {
            $tweets = 'error';
            $expire = 300;
            wp_cache_add( 'widget-twitter-response-code-' . $this->number, $response_code, 'widget', $expire);
          }
            
        }
        
		if ( 'error' != $tweets ) :
			$before_timesince = ' ';
			if ( isset( $instance['beforetimesince'] ) && !empty( $instance['beforetimesince'] ) )
				$before_timesince = esc_html($instance['beforetimesince']);
			$before_tweet = '';
			if ( isset( $instance['beforetweet'] ) && !empty( $instance['beforetweet'] ) )
				$before_tweet = stripslashes(wp_filter_post_kses($instance['beforetweet']));

			echo '<ul class="tweets">' . "\n";

			$tweets_out = 0;

			foreach ( (array) $tweets["results"] as $tweet ) {
				if ( $tweets_out >= 5 )
					break;

				if ( empty( $tweet['text'] ) )
					continue;

				$text = make_clickable( esc_html( $tweet['text'] ) );

				/*
				 * Create links from plain text based on Twitter patterns
				 * @link http://github.com/mzsanford/twitter-text-rb/blob/master/lib/regex.rb Official Twitter regex
				 */
				$text = preg_replace_callback('/(^|[^0-9A-Z&\/]+)(#|\xef\xbc\x83)([0-9A-Z_]*[A-Z_]+[a-z0-9_\xc0-\xd6\xd8-\xf6\xf8\xff]*)/iu',  array($this, '_wpcom_widget_twitter_hashtag'), $text);
				$text = preg_replace_callback('/([^a-zA-Z0-9_]|^)([@\xef\xbc\xa0]+)([a-zA-Z0-9_]{1,20})(\/[a-zA-Z][a-zA-Z0-9\x80-\xff-]{0,79})?/u', array($this, '_wpcom_widget_twitter_username'), $text);
				if ( isset($tweet['id_str']) )
					$tweet_id = urlencode($tweet['id_str']);
				else
					$tweet_id = urlencode($tweet['id']);

				if ( isset($tweet['from_user']) )
					$account = urlencode($tweet['from_user']);
                else
                    $account = "dandrewsify";

                // print out the individual user name and tweet
				echo "<li><a href=\"" . esc_url( "http://twitter.com/{$account}/" ) . '" class="user_account">' . $account . "</a><br />";
				echo "{$before_tweet}{$text}{$before_timesince}<a href=\"" . esc_url( "http://twitter.com/{$account}/statuses/{$tweet_id}" ) . '" class="timesince">' . str_replace(' ', '&nbsp;', wpcom_time_since(strtotime($tweet['created_at']))) . "&nbsp;ago</a></li>\n";
				unset($tweet_id);
				$tweets_out++;
			}

			echo "</ul>\n";
		else :
			if ( 401 == wp_cache_get( 'widget-twitter-response-code-' . $this->number , 'widget' ) )
				echo '<p>' . esc_html( sprintf( __( 'Error: Please make sure the Twitter account is <a href="%s">public</a>.'), 'http://support.twitter.com/forums/10711/entries/14016' ) ) . '</p>';
			else
				echo '<p>' . esc_html__('Error: Twitter did not respond. Please wait a few minutes and refresh this page.') . '</p>';
		endif;

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['beforetimesince'] = $new_instance['beforetimesince'];

		wp_cache_delete( 'widget-twitter-' . $this->number , 'widget' );
		wp_cache_delete( 'widget-twitter-response-code-' . $this->number, 'widget' );

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title' => '') );

		$title = esc_attr($instance['title']);

		echo '<p><label for="' . $this->get_field_id('title') . '">' . esc_html__('Title:') . '
		<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" />
		</label></p>';

		echo '<p><label for="' . $this->get_field_id('beforetimesince') . '">' . esc_html__('Text to display between tweet and timestamp:') . '
		<input class="widefat" id="' . $this->get_field_id('beforetimesince') . '" name="' . $this->get_field_name('beforetimesince') . '" type="text" value="' . $before_timesince . '" />
		</label></p>';
	}

	/**
	 * Link a Twitter user mentioned in the tweet text to the user's page on Twitter.
	 *
	 * @param array $matches regex match
	 * @return string Tweet text with inserted @user link
	 */
	function _wpcom_widget_twitter_username( $matches ) { // $matches has already been through wp_specialchars
		return "$matches[1]@<a href='" . esc_url( 'http://twitter.com/' . urlencode( $matches[3] ) ) . "'>$matches[3]</a>";
	}

	/**
	 * Link a Twitter hashtag with a search results page on Twitter.com
	 *
	 * @param array $matches regex match
	 * @return string Tweet text with inserted #hashtag link
	 */
	function _wpcom_widget_twitter_hashtag( $matches ) { // $matches has already been through wp_specialchars
		return "$matches[1]<a href='" . esc_url( 'http://twitter.com/search?q=%23' . urlencode( $matches[3] ) ) . "'>#$matches[3]</a>";
	}

}

add_action( 'widgets_init', 'twitsense_twitter_widget_init' );
function twitsense_twitter_widget_init() {
	register_widget('Twitsense_Twitter_Widget');
}
