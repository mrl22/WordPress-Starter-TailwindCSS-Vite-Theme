<form action="<?php bloginfo('url'); ?>/" method="get" class="flex">
    <fieldset class="flex w-full">
        <div class="flex w-full">
            <input type="text" name="s" id="search" placeholder="Search" value="<?php the_search_query(); ?>" class="form-input w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-r-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Search</button>
        </div>
    </fieldset>
</form>