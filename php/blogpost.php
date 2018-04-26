<?php

class blogpost
{
	public $id;
	public $title;
	public $postUrl;
	public $author;
	public $authorId;
	public $tags;
	public $datePosted;

	function __construct($mysqli, $inId=null, $inTitle=null, $inPostUrl=null, $inAuthorId=null, $inDatePosted=null)
	{
		if (!empty($inId))
		{
			$this->id = $inId;
		}
		if (!empty($inTitle))
		{
			$this->title = $inTitle;
		}
		if (!empty($inPostUrl))
		{
			$this->postUrl = $inPostUrl;
		}

		if (!empty($inDatePosted))
		{
			$splitDate = explode("-", $inDatePosted);
			$this->datePosted = $splitDate[1] . "/" . $splitDate[2] . "/" . $splitDate[0];
		}

		if (!empty($inAuthorId))
		{
			$query = mysqli_query($mysqli, "SELECT first_name, last_name FROM users WHERE id = " . $inAuthorId);
			$row = mysqli_fetch_assoc($query);
			$this->author = $row["first_name"] . " " . $row["last_name"];
			$this->authorId = $inAuthorId;
		}

		$postTags = "No Tags";
		if (!empty($inId))
		{
			$query = mysqli_query($mysqli, "SELECT tags.* FROM post_tags LEFT JOIN (tags) ON (post_tags.tag_id = tags.id) WHERE post_tags.post_id = " . $inId);
			$tagArray = array();
			$tagIDArray = array();
			while($row = mysqli_fetch_assoc($query))
			{
				array_push($tagArray, $row["name"]);
				array_push($tagIDArray, $row["id"]);
			}
			if (sizeof($tagArray) > 0)
			{
				foreach ($tagArray as $tag)
				{
					if ($postTags == "No Tags")
					{
						$postTags = $tag;
					}
					else
					{
						$postTags = $postTags . ", " . $tag;
					}
				}
			}
		}
		$this->tags = $postTags;
	}

}

?>
