<?php
/*
Template Name: Display Speakers
*/
get_header();
?>
<div id="primary">
	<div id="content" role="main">
		<?php query_posts(array('post_type'=>'speakers')); ?>
		<?php $mypost = array('post_type'=>'speakers');
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
		<div style="font-size:15px;"><strong>Links to the speaker:</strong></br>
		<?php $val=get_post_meta(get_the_ID(),'links',true);
		$link=explode(';',$val);
		foreach($link as $i)
		{
			echo "<a href=\"".$i."\">".$i."</a>"."</br>";
		}
		 ?></br></br>
		 </hr>
		<strong>Sessions:</strong></br>
		<?php $val=get_post_meta(get_the_ID(),'sessions',true);
		$link=explode(';',$val);
		echo "<p>";
		foreach($link as $i)
		{
			echo $i."</br>";
		}
		 ?>
		</p>
		<?php //echo get_post_meta(get_the_ID(),'sessions',true); ?>
		</div>
		</header> 
		 	
		 	</article>
		</hr></br></hr>
		 	<?php endwhile; ?>	
		</div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer();?>
