<?php

/**
 *Template Name: People
 * @package teatr
 */

get_header(); ?>

<main id="primary" class="site-main">
  <?php the_content();
  $role = !empty($_GET["rola"]) ? $_GET["rola"] : "dyrekcja";
  $taxonomy = 'categories';
  $args = array(
    'post_type' => 'people',
    'posts_per_page'   => -1,
    'tax_query' => array(
      array(
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $role
      )
    )
  );
  $query = new WP_Query($args);


  $terms = get_terms([
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
  ]);
  $role_term_id = get_term_by('slug', $role, $taxonomy);

  ?>

  <section class="people">
    <div class="container">
      <ul class="people__categories">
        <form id="role" hidden>
          <input type="text" id="filter_role" name="rola" hidden value="<?php echo $role; ?>" />
        </form>
        <?php
        foreach ($terms as $key => $term) {
          if ($term->parent === 0) {
            $active_class = $term->slug == $query->tax_query->queries[0]['terms'][0] ? 'class="active"' : '';
            echo ' <li>
                <a href="' . get_site_url() . '/zespol/?rola=' . $term->slug . '" ' . $active_class . '>' . $term->name . '</a>
              </li>';
          }
        } ?>
      </ul>
      <div class="box">
        <div class="loader"></div>
      </div>
      <div class="people__items">
        <?php
        if ($query->tax_query->queries[0]['terms'][0] == 'dyrekcja' || $query->tax_query->queries[0]['terms'][0] == 'kierownictwo') {
          if ($query->have_posts()) {
            while ($query->have_posts()) {
              $query->the_post();
              $avatar = get_the_post_thumbnail() ?
                get_the_post_thumbnail() :
                '<img src="' . get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp" alt="avtar-image">';
              echo '<div class="people__items_item">
        <a href="' .  get_permalink() . '">' .
                $avatar . '
          <p>' . get_the_title() . '</p>
        </a>
      </div>';
              wp_reset_postdata();
            }
          }
        } else {

          $sub_terms = get_terms($taxonomy, [
            'parent'       => $role_term_id->term_id,
            'hide_empty' => true,
          ]);
          foreach ($sub_terms as $term) {

            if ($term->count != 0) {
              echo '<div class="category__wrap">';
              echo '<div class="category__wrap-name">' . $term->name . '</div>';
              $args = array(
                'post_type' => 'people',
                'posts_per_page'   => -1,
                'tax_query' => array(
                  array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $term->slug
                  )
                )
              );
              echo '<div class="category__wrap-items">';
              $n_query = new WP_Query($args);
              if ($n_query->have_posts()) {
                while ($n_query->have_posts()) {
                  $n_query->the_post();
                  $link = get_the_content() ? '<a href="' . get_permalink() . '">' . get_the_title() . '</a>'  : '<p>' . get_the_title() . '</p>';
                  echo $link;
                }
                echo '</div>';
              }
              echo '</div>';
              wp_reset_postdata();
            }
          }
        }
        wp_reset_postdata(); ?>
      </div>
    </div>
  </section>

</main><!-- #main -->

<?php get_footer();
