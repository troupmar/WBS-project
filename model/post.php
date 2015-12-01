<?php

class Post
{
	private $username;
	private $insert_time;
	private $post;

	public function get_username() 
	{
		return $this->username;
	}

	public function get_insert_time()
	{
		return $this->insert_time;
	}

	public function get_post()
	{
		return $this->post;
	}

	public function set_username($username)
	{
		$this->username = $username;
	}

	public function set_insert_time($insert_time)
	{
		$this->insert_time = $insert_time;
	}

	public function set_post($post)
	{
		$this->post = $post;
	}
}

?>