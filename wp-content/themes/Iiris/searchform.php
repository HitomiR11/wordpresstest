<!--this is for search form and wordpress makes automatically-->
<form action="/" method="get">
    <label for="search">Search</label>

    <!--category search. name's cat means category. This will be category of number(value) first-->
    <input type="hidden" name="cat" value="">

    <input type="text" name="s" id="search" value="<?php the_search_query();?>" required>
    <!--name's s means wordpress of search-->
    <button type="submit">Search!</button>

</form>
