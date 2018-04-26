<?php
include $_SERVER['DOCUMENT_ROOT'] . '/php/includes.php';
$url = substr($_SERVER['REQUEST_URI'], 1);
$postInfo = GetPostFromUrl($url);
$postAuthor = GetUserFromId($postInfo->authorId);
$postContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $postInfo->postUrl . "post.htm");

preg_match_all ('/<p.*?>(.*?)<\/p>/', $postContent, $postContentP, PREG_PATTERN_ORDER);
$postContentP = htmlspecialchars(strip_tags(implode("  ", $postContentP[0])), ENT_QUOTES);

echo "<!DOCTYPE html>";

echo "<html>";
echo "<head>";
echo "<title>". $postInfo->title . " - Crumbs</title>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<meta name='description' content='". substr($postContentP, 0, 160) ."'>";
echo "<link rel='stylesheet' type='text/css' href='/css/style.css'>";
echo "</head>";


echo "<body>";

readfile($_SERVER['DOCUMENT_ROOT'] . '/util/header.htm');

echo "<main>";
echo "<div class='post-wrapper'>";
echo "<div class='posthead'>";
echo "<h1>" . $postInfo->title . "</h1>";
echo "<p>" . $postInfo->datePosted .  " by <a href=' ". $postAuthor->url ." '>" . $postInfo->author . "</a> </p>";
echo "<hr>";
echo "</div>";
echo "<div class='content-wrapper'>";
echo $postContent;
echo "</div>";
echo "</div>";
echo "</main>";

//comments
echo "<hr>";
echo "<div class='comments'>";
echo "<h1><i>Comments</i></h1>";
echo "<h3>Comming Soon</h3>";
echo "</div>";

readfile($_SERVER['DOCUMENT_ROOT'] . '/util/footer.htm');

echo "</body>";
echo "</html>";
?>
