<?php
require_once('template.php');
require_once('model/post_model.php');
require_once('model/post.php');

class Communicate extends Template
{
	protected function render_body() 
	{
		echo "<h1>Communicate</h1>";

		
		$post = new Post();
		$post->set_username("tata");
		$post->set_post("basdanskjajksdfhsdjaf");
		$post_model = new Post_model();
		$post_model->store_post($post);

		$posts =  $post_model->get_posts(6);
		print_r($posts);

	}
}

?>