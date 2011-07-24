MyXssMagic = new function() {
        
        var BASE_URL = 'http://atlatler.com/twitsense/';
        var STYLESHEET = BASE_URL + "xss_magic.css";
        var CONTENT_URL = BASE_URL + 'people_list.js';
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
            if (!data) return;
            var div = document.getElementById(ROOT);
            var txt = '';
            for (var i = 0; i < data.length; i++) {
                if (txt.length > 0) { txt += ", "; }
                txt += data[i];
            }
            div.innerHTML = "<strong>Names:</strong> " + txt;  // assign new HTML into #ROOT
            div.style.display = 'block'; // make element visible
        }

        requestStylesheet(STYLESHEET);
        document.write("<div id='" + ROOT + "' style='display: none'></div>");
        requestContent();
    }