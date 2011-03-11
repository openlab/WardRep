<?php defined('BASEPATH') OR exit; ?>
    <div class="row content">
        <?php if( $has_error ) : ?>
        <div class="error-box">
            <p><?php print isset($error_message) && !empty($error_message) ? $error_message : 'An unknown error has occurred. Please try again.'; ?></p>
        </div>
        <?php endif; ?>
        <?php if( $has_ambiguous_terms && isset($geocoded_search_terms) ) : ?>
        <div class="search-ambiguous">
            <ul>
                <?php foreach( $geocoded_search_terms as $term ) : ?>
                <li><?php print anchor('/search/address/' . $term->formatted_address, $term->formatted_address); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="search">
            <form action="<?php print $base_path; ?>" method="post">
            <label for="search_terms">Address:</label>
            <input type="text" name="search_terms" id="search_terms" maxlength="255" size="80" class="text" value="<?php print $search_terms; ?>" />
            <input type="submit" name="search" value="Search" class="button" />
            </form>
        </div>
        <?php if( isset($has_results) && $has_results ) : ?>
        <div class="results">
            <?php if( $searched_location['representatives']['count'] > 0 ) : ?>
            <div class="quick-info">
                
                <?php if( 1 < $searched_location['representatives']['count'] ) : ?>
                <h1><?php print sprintf("Ward %s's Representatives are:", $searched_location['ward']->wardid); ?></h1>
                <?php else: ?>
                <h1><?php print sprintf("Ward %s's Representative is:", $searched_location['ward']->wardid); ?></h1>
                <?php endif; ?>
                
                <?php $this->load->view('search-results', array('results' => $searched_location['representatives']['data'], 'base_path' => $base_path, 'searched_location' => $searched_location)); ?>
            </div>
            <?php endif; ?>
            <?php if( isset($search_terms) && !empty($search_terms) ) : ?>
            <h3><?php print $geocoded_search_terms->formatted_address; ?></h3>
            <div class="clear-fix">&nbsp;</div>
            <?php endif; ?>
            <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.3"></script>
            <script type="text/javascript" src="<?php print $base_path; ?>assets/javascript/VEShape.prototype.js"></script>
            <script type="text/javascript" src="<?php print $base_path; ?>assets/javascript/Application.search.js"></script>
            <div id="bing-maps" class="bing-maps" style="position: relative; width: 100%; height: 380px;"></div>
            <div class="row information">
                <div class="representatives">
                    <div class="share-buttons">
                        <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                        
                        <a href="http://twitter.com/share" class="twitter-share-button" data-url="http://www.wardrep.ca/" data-text="WARDREP.CA helped me find my ward representative. #opendata #wardrep" data-count="horizontal">Tweet</a>
                        <fb:like href="http://www.wardrep.ca/" layout="button_count" show_faces="true" action="recommend" font="lucida grande"></fb:like>
                    </div>
                    
                    <ul class="tabs" id="nav-tabs">
                        <li class="first"><a title="Mayor" id="view-mayor">Mayor</a></li>
                        <?php if( 0 < $representative_result_count['regional councillor'] ) : ?>
                        <li><a title="Regional Councillors" id="view-regional-councillors">Regional Councillors</a></li>
                        <?php endif; ?>
                        <li class="last active"><a title="Councillors" id="view-councillors">Councillors</a></li>
                    </ul>
                    <div class="clear-fix">&nbsp;</div>
                    
                    <div class="view-all-details">
                        <div class="display-none" id="view-mayor-details">
                            <div class="details">
                                <?php $this->load->view('search-results', array('results' => $representative_results['mayor'], 'base_path' => $base_path, 'searched_location' => $searched_location)); ?>
                            </div>
                        </div>
                        
                        <?php if( 0 < $representative_result_count['regional councillor'] ) : ?>
                        <div class="display-none" id="view-regional-councollors-details">
                            <div class="details">
                                <?php $this->load->view('search-results', array('results' => $representative_results['regional councillor'], 'base_path' => $base_path, 'searched_location' => $searched_location)); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div id="view-councillors-details">
                            <div class="details">
                                <?php $this->load->view('search-results', array('results' => $representative_results['councillor'], 'base_path' => $base_path, 'searched_location' => $searched_location)); ?>
                            </div>
                            <div class="clear-fix">&nbsp;</div>    
                        </div>
                    </div>
                </div> <!--// end reps -->
                
            </div>
        </div>
        <?php endif; ?>
    </div>