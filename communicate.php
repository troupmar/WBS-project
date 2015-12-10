<?php
require_once('template.php');
require_once('model/post_model.php');
 
 
class Communicate extends Template
{
    protected function render_body()
    {
    	if (isset($_SESSION['username']))
		{
	    	$error_message = "";
	    	$post_model = new Post_model();

	        if (isset($_POST['sub'])) 
	        {
	        	$content = $this->sanitize_string($_POST['content']);
	        	if ($content) 
	        	{
	        		$post = new Post();
	        		$post->set_username($_SESSION['username']);
	        		$post->set_post($content);
	            	
	            	$post_model->store_post($post);
	            }
	            else
	            {
	            	$error_message = "The post cannot be left empty!";
	            }
	        }

		    echo "<h1>Communicate</h1>
	        <h2> What's in your mind!!</h2>
	        <p id='error-message'>$error_message</p>
	        <form action='alumni.php?page=communicate' method='post'>
	        <textarea cols ='70' rows='4' name='content' placeholder='write what you are thinking........'></textarea><br/>
	        <input type='submit' name='sub' value='Post to Timeline'>
	        </form>
	        <h3> Most Recent Discussions!</h3>";
		                       
		    $posts = $post_model->get_posts();
		    foreach($posts as $post) 
		    {
		        echo $post->get_username() . " [" . $post->get_insert_time() . "]<br />";
		        echo $post->get_post() . "\n" . "<br/ ><br />";
		    }
		}
		else
		{
			echo "<p>In order to see the communication page, you need to <a href='alumni.php?page=login'>Log in</a>!</p>";
		}

	}
 
}
 
?>