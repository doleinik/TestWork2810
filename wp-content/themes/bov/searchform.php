<div class="search-form">
  <form role="search" method="get" class="search-form__inner"
        action="<?php echo home_url( '/' ); ?>">
    <div class="search-form__inner2">
      <label for="search-input" class="visually-hidden">Search</label>
      <input type="search" class="search-form__input"
             placeholder="Search"
             required
             value="<?php echo get_search_query() ?>" name="s"/>

      <button type="submit" class="search-form__submit"
              value="">Search
      </button>
    </div>
  </form>
</div>