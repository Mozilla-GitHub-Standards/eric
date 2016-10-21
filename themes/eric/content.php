<?php
/**
 * The template used for displaying services page content
 */
?>

<?php
  $thumbnail = get_the_post_thumbnail( $post->ID, 'full', array( 'class' => 'img-responsive', 'alt' => $post->post_tilte ) );
  $link_url = get_permalink($post->ID);
?>
<article id="post-<?php echo $post->ID;?>" class="hentry">
  <h3 class="entry-title"><?php echo $post->post_title;?></h3>
  <div class="entry-meta"><?php echo date('F d, Y', strtotime($post->post_date));?></div>
      
  <div class="entry-content">
    <?php echo the_content();?>
  </div>
</article>
