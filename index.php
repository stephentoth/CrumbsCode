<html>
<head>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>🍪 Crumbs - Blog</title>
        <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body>
	<header>
    <h1><a href="/">Crumbs</a></h1>
		 <h2>Be Sure to Clear Your Cookies</h2>
  </header>

	<main>	
                <div id="blogPosts">
                        <?php
                        include 'php/includes.php';

                        $dot = ".";
                        $blogPosts = GetPosts();

                        foreach ($blogPosts as $post)
                        {
                                $postAuthor = GetUserFromId($post->authorId);
                                $postContent = strip_tags(file_get_contents($post->postUrl . "post.htm"));
                                if ($post->id != count($blogPosts))
                                {
                                        echo "<div class='post'>";
                                        echo "<a class='post-link' href=" . $post->postUrl . ">";
                                        echo "<h1>" . $post->title . "</h1>";
                                        echo "<h4 class='post-excerpt'>" . substr($postContent, 0, stripos($postContent, $dot)) . ".</h4>";
                                        echo "</a>";
                                        echo "<div class='footer'> <p>" . $post->datePosted . ' by  <a href="' . $postAuthor->url . '">' . $post->author . "</a></p></div>";
                                        echo"</div>";
                                } else {

					echo "<div class='post'>";
					echo "<a class='post-link' href=" . $post->postUrl . ">";
					echo "<h1>" . $post->title . "</h1>";
					echo "<h4 class='post-excerpt'>" . substr($postContent, 0, 280) . "...</h4>";
					echo "</a>";
					echo "<div class='footer'> <p>" . $post->datePosted . ' by  <a href="' . $postAuthor->url . '">' . $post->author . "</a></p></div>";
					echo"</div>";
                                }

                        }

                        ?>
                </div>
	</main>

	<?php readfile($_SERVER['DOCUMENT_ROOT'] . '/util/footer.htm'); ?>
</body>
</html>
