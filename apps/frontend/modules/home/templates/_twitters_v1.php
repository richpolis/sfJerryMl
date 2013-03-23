<?php use_helper('Escaping')?>
<?php $cont=0;?>
<?php foreach ($twitters as $key=>$twitt): ?>
<?php $cont++;?>
<div class="twitt twitt-<?php echo $twitt->id_str?>" <?php echo ($cont==1?'style="margin-top: 50px;border-top:1px solid gray;padding-top: 5px;"':'')?>>
    <table >
        <tr>
            <td rowspan="2">
                <div class="twitt-imagen">
                    <img src="<?php echo $twitt->user->profile_image_url_https?>" width="48" height="48"/>
                </div>
            </td>
            <td>
                <div class="twitt-name">
                    <?php echo $twitt->user->name?>
                    <span class="twitt-screen-name">@<?php echo $twitt->user->screen_name?></span>
                    <div class="twitt-tiempo">
                        <?php echo sfRichSys::twitter_time($twitt->created_at)?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            
            <td>
                <div class="twitt-texto twitt-<?php echo $key?>">
                    <?php echo sfRichSys::TextToUrls($twitt->text) ?>
                </div>
                <div class="twitt-controles" style="text-align: right;">
                    <a class="bbp-action bbp-reply-action" title="Reply" target="_blank" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $twitt->id_str?>&related=themergency">
                    <span>
                    <em style="margin-left: 1em;"></em>
                    <strong>Reply</strong>
                    </span>
                    </a>
                    <a class="bbp-action bbp-retweet-action" title="Retweet" target="_blank" href="https://twitter.com/intent/retweet?tweet_id=<?php echo $twitt->id_str?>&related=themergency">
                    <span>
                    <em style="margin-left: 1em;"></em>
                    <strong>Retweet</strong>
                    </span>    
                    </a>
                    <a class="bbp-action bbp-favorite-action" title="Favorite" target="_blank" href="https://twitter.com/intent/favorite?tweet_id=<?php echo $twitt->id_str?>&related=themergency">
                    <span>
                    <em style="margin-left: 1em;"></em>
                    <strong>Favorite</strong>
                    </span>
                    </a>
                </div>
            </td>
        </tr>
    </table>
    
</div>
<?php endforeach; ?>
<div id="twitter-feed">
	<!--script src="http://widgets.twimg.com/j/2/widget.js"></script-->
	<script>
	new TWTR.Widget({
	  version: 2,
	  type: 'search',
	  search: 'jerryml1',
	  interval: 1000,
	  title: 'Twitter Feed',
	  subject: 'Jerry ML',
	  width: 'auto',
	  height: 300,
	  theme: {
	    shell: {
	      background: '#ffffff',
	      color: '#000000'
	    },
	    tweets: {
	      background: '#ffffff',
	      color: '#444444',
	      links: '#1985b5'
	    }
	  },
	  features: {
	    scrollbar: false,
	    loop: true,
	    live: true,
	    hashtags: true,
	    timestamp: true,
	    avatars: true,
	    toptweets: false,
	    behavior: 'default'
	  }
	}).render().start();
	</script>	
	<img id="sign" src="img/sign.svg">
        </div>