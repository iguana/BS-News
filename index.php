<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>BS News | Bootstrap Experiment</title>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script src="http://scripts.embed.ly/jquery.embedly.min.js"></script>
    <script src="js/bootstrap-all.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/global.css">
    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>
    <script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAAASuG55HAjaFHnhlBruw2fBSoungv015IYEzgeKj7JRxtW_Hq_xTFr7nHrRF-Yp_SDaJdOLA0GWRTww"></script>
    <script type="text/javascript">

    google.load("feeds", "1");
    var BS = {};
    BS.currentLayout = 'span16';

    function initialize(feed) {
      //var feed = new google.feeds.Feed("http://blog.vipepower.com/feed/");
      //var feed = new google.feeds.Feed("http://news.ycombinator.com/rss");
      var feed = new google.feeds.Feed(feed);
      feed.setNumEntries(100);
      feed.includeHistoricalEntries();
      feed.load(function(result) {
        if (!result.error) {

          var container = $('div#content');
          container.empty();
          var itemList = $('div.sidebar');
          var wrap = $("<div id='items' class='row'/>");
          container.append(wrap);
          for (var i = 0; i < result.feed.entries.length; i++) {
            var entry = result.feed.entries[i];
            $.embedly(entry.link, {success:gotSummaries,maxwidth:340,key:'7064475c0cca11e1858e4040d3dc5c07'});
          }

        }
        else {
          alert(result.error);
        }
      });
    }

    function gotSummaries(oembed, dict) {
      var elem = $(dict.node);
      if (! (oembed) ) { return null; }
      //var provider = oembed.provider_name ? '<small><a href="'+oembed.provider_url+'" class="provider">'+oembed.provider_name+'</a></small> - ' : '';
      var provider = '<small>'+oembed.provider_name+'</small>' || '';
      if(!oembed.description) {
        oembed.description = '';
      }
      var img = ''; 
      var hasImg = '';
      if(oembed.thumbnail_url) {
        //img = "<img style='float:left;width:100px;' src='" +oembed.thumbnail_url+ "'>";
        hasImg = 'hasImg';
      }
      var item = $("<div class='"+BS.currentLayout+" item'><div class='title note'><a href='"+
        dict.url+"'>"+oembed.title+"</a></div>" + img +
        "<blockquote class='"+hasImg+"'><p>" + oembed.description + "</p>" + 
        provider + "</blockquote></div>"
      );
      $('div#items').append(item);
      //return elem.replaceWith(item);
      //return elem.replaceWith(oembed.code); 
    }

    function setLayout(span) {
      $('.' + BS.currentLayout).addClass(span); 
      if(span != BS.currentLayout) {
        $('.' + BS.currentLayout).removeClass(BS.currentLayout);
      }
      BS.currentLayout = span;
    }

    function setBackground(bg) {
      $('body').css('background-image','url(images/'+bg+')');
    }

    function setFeed(feed) {
      initialize(feed);
    }
    
    function setCustomFeed() {
      var customFeed = $('#i-custom-feed').val();
      if(customFeed) {
        $('#custom-feed').modal('hide');
        initialize(customFeed);
      }
    }

  var feedlist = Array('http://news.ycombinator.com/rss', 'http://www.reddit.com/.rss');
    $(function() {
      $('form').submit(function(e) { e.preventDefault(); });

      initialize(feedlist[0]);

      var bglist = Array('light_alu.png','brushed_alu_dark.png','concrete_wall_2.png','project_papper.png','random_grey_variations.png','light_honeycomb.png','old_mathematics.png','batthern.png','polonez_car.png','dark_mosaic.png');
      for(i=0;i<bglist.length;i++){
      var bgItem = $('<li><a href="#" onclick="setBackground(\''+bglist[i]+'\')">'+bglist[i]+"</a></li>");
        $('ul#backgrounds').append(bgItem);
      }

      for(i=0;i<feedlist.length;i++){
        var feedItem = $('<li><a href="#" onclick="setFeed(\''+feedlist[i]+'\')">'+feedlist[i]+"</a></li>");
        $('ul#feeds').prepend(feedItem);
      }

    });

    </script>
  </head>

  <body>
    <div class="topbar" data-dropdown="dropdown">
      <div class="fill">
        <div class="container">
          <a class="brand" href="#">BS News <sup><span class="label notice">Beta</span></sup></a>
          <ul class="nav">
            <li class="dropdown">
              <a class="dropdown-toggle right" href="#">Feeds</a>
              <ul class="dropdown-menu" id="feeds">
                <li class="divider"></li>
                <li><a href="#custom-feed" data-controls-modal="custom-feed" data-backdrop="static">Custom Feed...</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle right" href="#">Layouts</a>
              <ul class="dropdown-menu">
                <li><a href="#" onclick="setLayout('span4');">4 Columns</a></li>
                <li><a href="#" onclick="setLayout('span-one-third');">3 Columns</a></li>
                <li><a href="#" onclick="setLayout('span8');">2 Columns</a></li>
                <li><a href="#" onclick="setLayout('span16');">List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" href="#">Backgrounds</a>
              <ul class="dropdown-menu" id="backgrounds">
              </ul>
            </li>
            <li><a href="#about" data-controls-modal="about" data-backdrop="static">About</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div id="about" class="modal hide fade in">
      <div class="modal-header"><a href="#" class="close">&times;</a><h3>About</h3></div>
      <div class="modal-body">BS News - Bootstrap Feed reader experiment: impressed with Twitter's Bootstrap, I set out to make a JavaScript-only app to learn bootstrap and demonstrate the features to others.</div>
      <div class="modal-footer">&copy; 2011 BS News</div>
    </div>
    <div id="custom-feed" class="modal hide fade in">
      <div class="modal-header"><a href="#" class="close">&times;</a><h3>Custom Feed</h3></div>
      <div class="modal-body">
        <form class='form-stacked'>
          <fieldset>
            <label for="i-custom-feed">Enter Feed URL</label>
            <input type="text" size="50" class="xlarge" id="i-custom-feed" name="i-custom-feed" placeholder="Enter Feed URL"><span class="help-inline">Any valid RSS feed should work.</span>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn primary xlarge" onclick="setCustomFeed();">Set Feed</button>
      </div>
    </div>
    <div class="container">
      <div id="content" class="content">
      </div>
      <footer>
        <p>&copy; 2011 BS News. Made with <a href="http://twitter.github.com/bootstrap/" target="_blank">Twitter Bootstrap</a>. And love, lots of love. </p>
      </footer>
    </div>
  </body>
</html>
