<?php defined('BASEPATH') OR exit; ?>

<article class="post">
    <header>
        <h2><a href="<?php print $post->link; ?>" title="<?php print $post->title; ?>"><?php print $post->title; ?></a></h2>
    </header>
    <?php print (string) $post->children('http://purl.org/rss/1.0/modules/content/')->encoded; ?>
    <p class="contread"><a href="<?php print $post->link; ?>" title="Continue Reading <?php print $post->title; ?>">Continue Reading &rarr;</a></p>
    
    <div class="meta">
        <?php $timestamp = strtotime($post->pubDate); ?>
        <span class="time"><?php print date('l, M j, g:i a'); ?></span>
        <span class="links">
            <a href="<?php print $post->comments; ?>" title="Comments">Comments</a>
        </span>
        <div class="clear-fix">&nbsp;</div>
    </div>
</article>