<?php

require_once(__DIR__ . '/model.php');
require_once(__DIR__ . '/post.php');

class Post_model extends Model
{
	public function store_post($post)
	{
		$username 		= $this->sanitize_string($post->get_username());
		$insert_time 	= date ("Y-m-d H:i:s");
		$post 			= $this->sanitize_string($post->get_post());

		$query  = "INSERT INTO posts VALUES(null, '$username', '$insert_time', '$post')";
		$result = $this->conn->query($query);
		$this->handle_db_result_error($result);

		return true;
	}

	// Get all posts
	public function get_posts($limit = null)
	{	
		$query = "SELECT * FROM posts ORDER BY insert_time";
		
		if ($limit) 
		{
			$query .= " LIMIT $limit";
		}
		
		$result = $this->conn->query($query);
		$this->handle_db_result_error($result);

		return $this->get_objects_from_table($result);
	}

	// Get a row from a database representing a post and transform it to Post object
	protected function get_object($array)
	{
		$post = new Post();
		$post->set_username($array['username']);
		$post->set_insert_time(date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $array['insert_time']))));
		$post->set_post($array['post']);
		return $post;
	}
}

?>