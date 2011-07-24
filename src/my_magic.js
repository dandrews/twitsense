MyXssMagic = new function() {
        
        var BASE_URL = 'http://atlatler.com/twitsense/';
        var STYLESHEET = BASE_URL + "xss_magic.css";
        // var CONTENT_URL = BASE_URL + 'people_list.js';
        var CONTENT_URL = BASE_URL + 'magic.php';
        var ROOT = 'my_xss_magic';

        function requestStylesheet(stylesheet_url) {
            stylesheet = document.createElement("link");
            stylesheet.rel = "stylesheet";
            stylesheet.type = "text/css";
            stylesheet.href = stylesheet_url;
            stylesheet.media = "all";
            document.lastChild.firstChild.appendChild(stylesheet);
        }

        function requestContent( local ) {
            var script = document.createElement('script');
            // How you'd pass the current URL into the request
            // script.src = CONTENT_URL + '&url=' + escape(local || location.href);
            script.src = CONTENT_URL;
            // IE7 doesn't like this: document.body.appendChild(script);
            // Instead use:
            document.getElementsByTagName('head')[0].appendChild(script);
        }

        this.serverResponse = function( data ) {
            // if (!data) return;
            var div = document.getElementById(ROOT);
            var txt = '';
            // for (var i = 0; i < data.length; i++) {
            //     if (txt.length > 0) { txt += ", "; }
            //     txt += data[i];
            // }
            div.innerHTML = '<iframe name="twit_ads_frame"'
            + " width='80'"
            + " height='80'"
            + " frameborder='no'"
            + " src='https://twitter.com/#!/the_dan_bot'"
            + ' marginwidth="0" marginheight="0" vspace="0" hspace="0" '
            + ' allowtransparency="true" scrolling="no">'
            + "</iframe>";
            // assign new HTML into #ROOT
            
            div.style.display = 'block'; // make element visible

            // doc.write('<iframe name="twit_ads_frame"'
            //           + " width='80'"
            //           + " height='80'"
            //           + " frameborder='no'"
            //           + " src='https://twitter.com/#!/the_dan_bot'"
            //           + ' marginwidth="0" marginheight="0" vspace="0" hspace="0" '
            //           + ' allowtransparency="true" scrolling="no">');
            // doc.write("</iframe>");
        }

        requestStylesheet(STYLESHEET);
        document.write("<div id='" + ROOT + "' style='display: none'></div>");
        requestContent();
    }