<?php
/*
Template Name: Display Sessions
*/
get_header();
?>
<div id="primary">
	<div id="content" role="main">
		<?php query_posts(array('post_type'=>'session')); ?>
		<?php $mypost = array('post_type'=>'session');
		$loop= new WP_Query($mypost);?>
		<?php while($loop->have_posts()) : $loop->the_post();?>
		<article id="post-<?php the_ID();?>" <?php post_class(); ?>>
		<header class="entry-header">
		<div style="float:top;margin:10px">
			<?php the_post_thumbnail(array(100,100));?>
		</div>
		<div style="font-size:40px;">
		<strong><?php the_title();?></strong></br>
		</div>
		<div class="entry-content" style="font-size:15px;"><?php the_content() ?></div>
		<div style="font-size:15px;"><strong>Speaker:</strong></br>
		<?php $val=get_post_meta(get_the_ID(),'spk',true);
		$link=explode(';',$val);
		foreach($link as $i)
		{
			echo "<a href=\"http://localhost/wordpress/?speakers=".$i."\">".$i."</a>"."</br>";
		}
		 ?></br></br>
		 </hr>	
		</div>
		</header> 
		</article>
		</hr></br></hr>
		<?php endwhile; ?>	
		</div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer();?>
