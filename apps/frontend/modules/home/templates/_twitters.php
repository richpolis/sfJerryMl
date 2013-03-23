<div id="twitter-feed">
	<!--script src="http://widgets.twimg.com/j/2/widget.js"></script-->
	<script>
	new TWTR.Widget({
	  version: 2,
	  type: 'search',
	  search: '<?php echo $usuario;?>',
	  interval: 1000,
	  title: 'Twitter Feed',
	  subject: '<?php echo $nombre;?>',
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
</div>