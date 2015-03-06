<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Twitter Challenge</title>
  <link href="bootstrap-3.0.0/css/bootstrap.min.css" rel="stylesheet">
  <script type="text/javascript" src="bootstrap-3.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<div class="page-header">
	  <h1>Twitter Challenge <small>http://www.kayako.com/challenge/twitter/</small></h1>
	</div>
	<div class="row">
	  <div class="col-sm-6 col-md-8">
		<div class="thumbnail">
		  
		  <div class="caption">
			<h3>Tweets #custserv</h3>
			<p><?php 
			
				try{
					require 'TwitterHook.php';
					$twitterHook = TwitterHook::singleton();
					$tweets = $twitterHook->getTweetsReTweeted();
				
					foreach ($tweets as $tweet){
						if($tweet->retweet_count === 0) continue;?>
						<div class="panel panel-default">
						  <div class="panel-body">
							<?php echo $tweet->text;?>
							<span class="label label-default">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $tweet->user->name;?>
								<span class="label label-success"><?php echo $tweet->retweet_count;?></span>
							</span>
						  </div>
						</div>
				<?php }
				} catch (Exception $e) {
					echo $e->getMessage();
				}
				
				?></p>
		  </div>
		</div>
	  </div>

	  <div class="col-sm-6 col-md-4">
		<div class="thumbnail">
		  <div class="caption">
			<h3>Twitter Challenge!</h3>
			<p>Wohoo! You have made this far, great job. Here is your challenge:</p>

				<p>Write a simple Twitter API client in PHP. This client simply has to fetch and display Tweets that
				<ul><li>a) Have been re-Tweeted at least once and</li>
				<li>b) Contain the hashtag #custserv</li></ul></p>

				<p>Why we are asking you to do this: We believe that code is poetry. This short, simple test will help you demonstrate not just your programming talent, but your approach to designing an application. We don’t just want to see the coder in you - we want to see the engineer.</p>

					<ul><li>Plan well. The goal here is not to finish the task as quickly as possible, but to demonstrate your careful thinking and planning.</li>
					<li>Write for the future. Write your code as if someone else will be working with it the next day. That person should be able to hit the ground running immediately.</li>
					<li>OOP. You don’t have to over-engineer this, but we do expect your small app to be object oriented.</li>
					<li>Craft your code. At Kayako, we write beautiful code. A big part of code beauty is readability and reusability, which is made up of simple stuff like spacing, layout and consistency.</li></ul>

				<p>Good luck!</p>
		  </div>
		</div>
	  </div>
	</div>

</div>
</body>
</html>