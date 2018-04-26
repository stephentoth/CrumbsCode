<?php
include 'blogpost.php';
include 'user.php';

$mysqli = new mysqli("/*server*/", "/*mysql user*/", "/*mysql password for user*/", "/*database*/");


function GetPosts($inId=null, $inTagId =null)
{
        global $mysqli;
        if (!empty($inId))
        {
                $query = mysqli_query($mysqli, "SELECT * FROM posts WHERE id = " . $inId . " ORDER BY id DESC");
        }
        else if (!empty($inTagId))
        {
                $query = mysqli_query($mysqli, "SELECT posts.* FROM post_tags LEFT JOIN (posts) ON (post_tags.postID = posts.id) WHERE post_tags.tagID =" . $tagID . " ORDER BY posts.id DESC");
        }
        else
        {
                $query = mysqli_query($mysqli, "SELECT * FROM posts ORDER BY id DESC");
        }

        $postArray = array();
        while ($row = mysqli_fetch_assoc($query))
        {
                $myPost = new blogpost($mysqli, $row["id"], $row['title'], $row['post_url'], $row['author_id'], $row['date_posted']);
                array_push($postArray, $myPost);
        }
        return $postArray;
}

function GetPostFromUrl($inUrl)
{
	global $mysqli;
	$query = mysqli_query($mysqli, "SELECT * FROM `posts` WHERE `post_url` LIKE '" . $inUrl . "'");
	$row = mysqli_fetch_assoc($query);
	$postInfo = new blogpost($mysqli, $row["id"], $row['title'], $row['post_url'], $row["author_id"], $row['date_posted']);
	return $postInfo;
}
function GetUserFromId($inId){
	global $mysqli;
	$query = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `id` = " . $inId );
	$row = mysqli_fetch_assoc($query);
	return new user($mysqli, $row['id'], $row['first_name'], $row['last_name'], $row['username'], $row['url'], $row['email'], $row['bio']);
}
?>
