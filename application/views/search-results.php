<?php defined('BASEPATH') OR exit; ?>
<?php

$iter = 1; $last_wardid = null;
foreach( $results as &$result ) :
    if( !isset($result->wardid) )
        $result->wardid = null;

    $classes = array();
    
    if( $result->wardid == $searched_location['ward']->wardnumber )
        $classes = array('highlight');
    
    if( 0 == ($iter % 2) && $last_wardid == $result->wardid ) :
        $classes[] = 'right';
    else:
        $classes[] = 'left';
    endif;
    
    $class = implode(' ', $classes);
    ?>
    <?php if( $last_wardid != $result->wardid ) : ?>
    <div class="clear-fix">&nbsp;</div>
    
    <?php if( !isset($hide_ward_labels) ) : ?>
    <h2 class="ward-name"><?php print sprintf('Ward %s', $result->wardid); ?></h2>
    <?php endif; endif; ?>
    
    <div class="result <?php print $class; ?>" id="ward<?php print !empty($result->wardid) ? ('-' . $result->wardid) : ''; ?>">
        <?php if( !empty($result->imageurl) ) : ?>
        <div class="float-right">
            <div class="photo">
                <img src="<?php print $result->imageurl; ?>" width="98px" alt="<?php print sprintf('%s %s', $result->firstname, $result->lastname) ?>" title="<?php print sprintf('%s %s', $result->firstname, $result->lastname); ?>" />
            </div>
        </div>
        <?php endif; ?>
        <h3 class="name"><?php print sprintf('%s %s', $result->firstname, $result->lastname); ?></h3>
        <div class="title"><?php print $result->representativetype; ?></div>
        
        <div class="indiv-details">
            <div class="address">
                <?php if( !empty($result->address) ) : print sprintf('<span class="line">%s</span>, ', $result->address); endif; ?>
                <?php print sprintf('<span class="line">%s</span>', $result->city); ?>
                <?php if( !empty($result->region) ) : print sprintf(', <span class="line">%s</span>', $result->region); endif; ?>
                <?php if( !empty($result->postalcode) ) : print sprintf(', <span class="line">%s</span>', $result->postalcode); endif; ?>
            </div>
            
            <?php if( !empty($result->workphone) ) : ?>
            <div class="phone"><span class="lbl">Phone (work):</span> <?php print sprintf('%s', $result->workphone); ?><?php if( !empty($result->workphoneext) ) : print sprintf(' Ext: %s', $result->workphoneext); endif; ?></div>
            <?php endif; ?>
            <?php if( !empty($result->cell) ) : ?>
            <div class="phone"><span class="lbl">Phone (cell):</span> <?php print sprintf('%s', $result->cell); ?></div>
            <?php endif; ?>
            
            <?php if( !empty($result->email) ) : ?>
            <div class="email"><span class="lbl">Email:</span> <?php print sprintf('<a href="mailto: %s" title="Send an email to %s %s">%s</a>', $result->email, $result->firstname, $result->lastname, $result->email); ?></div>
            <?php endif; ?>
            
            <?php if( !empty($result->website) ) : ?>
            <div class="website"><span class="lbl">Website:</span> <?php print sprintf('<a href="%s" title="Visit %s website">%s</a>', $result->website, sprintf("%s %s's", $result->firstname, $result->lastname), $result->website); ?></div>
            <?php endif; ?>
            
            <ul class="social">
                <li class="first">
                    <?php if( !empty($result->facebookurl) ) : ?>
                    <a href="<?php print $result->facebookurl; ?>" title="Facebook"><img src="<?php print $base_path; ?>assets/images/facebook.png" width="16px" height="16px" title="Facebook" alt="Facebook" /></a>
                    <?php else : ?>
                    <img src="<?php print $base_path; ?>assets/images/facebook-faded.png" width="16px" height="16px" title="Facebook" title="Facebook" />
                    <?php endif; ?>
                </li>
                <li>
                    <?php if( !empty($result->twitterusername) ) : ?>
                    <a href="http://twitter.com/<?php print $result->twitterusername; ?>" title="Twitter"><img src="<?php print $base_path; ?>assets/images/twitter.png" width="16px" height="16px" title="Twitter" alt="Twitter" /></a>
                    <?php else : ?>
                    <img src="<?php print $base_path; ?>assets/images/twitter-faded.png" width="16px" height="16px" title="Twitter" alt="Twitter" />
                    <?php endif; ?>
                </li>
                <li>
                    <?php if( !empty($result->flickrurl) ) : ?>
                    <a href="<?php print $result->flickrurl; ?>" title="Flickr"><img src="<?php print $base_path; ?>assets/images/flickr.png" width="16px" height="16px" title="Flickr" alt="Flickr" /></a>
                    <?php else : ?>
                    <img src="<?php print $base_path; ?>assets/images/flickr-faded.png" width="16px" height="16px" title="Flickr" alt="Flickr" />
                    <?php endif; ?>
                </li>
                <li class="last">
                    <?php if( !empty($result->youtubeurl) ) : ?>
                    <a href="<?php print $result->youtubeurl; ?>" title="YouTube"><img src="<?php print $base_path; ?>assets/images/youtube.png" width="16px" height="16px" title="YouTube" alt="YouTube" /></a>
                    <?php else: ?>
                    <img src="<?php print $base_path; ?>assets/images/youtube-faded.png" width="16px" height="16px" title="YouTube" alt="YouTube" />
                    <?php endif; ?>
                </li>
            </ul>
            <div class="clear-fix">&nbsp;</div>
        </div>
        <div class="clear-fix">&nbsp;</div>
    </div>
<?php ++$iter; $last_wardid = $result->wardid; endforeach; ?>
<div class="clear-fix">&nbsp;</div>