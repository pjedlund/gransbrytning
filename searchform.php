<?php 
echo '<form role="search" method="get" id="searchform" action="' . bloginfo('url') . '" >
    <label class="assistive-text" for="s">' . __('Search for:') . '</label>
    <input type="text" placeholder="'.__("Sökord...").'" value="' . get_search_query() . '" name="s" id="s" />
    <input class="button" type="submit" id="searchsubmit" value="Sök" />
</form>';
?>