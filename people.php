<?php 
/**
 *Template Name: People
 * @package teatr
 */

get_header(); ?>
 
   <main id="primary" class="site-main">
    <?php the_content();
    $taxonomy = 'categories';
    $args = array(
      'post_type' => 'people',
      'tax_query' => array(
        array(
          'taxonomy' => $taxonomy,
          'field'    => 'id',
          'terms'    => 4
        )
      )
    );
    $query = new WP_Query( $args );

    $terms = get_terms( [
      'taxonomy' => $taxonomy,
      'hide_empty' => false,
    ] ) ?>
    
    <section class="people">
      <div class="container">
        <ul class="people__categories">
          <?php 
          foreach ($terms as $key => $term) {
            if($term->parent === 0){
            $active_class = $term->term_id == $query->tax_query->queries[0]['terms'][0] ? 'class="active"' : '';
              echo ' <li>
                <a href="#" ' . $active_class . ' data-term-id="' . $term->term_id . '">' . $term->name . '</a>
              </li>';
            } 
          } ?>
        </ul>
        <div class="box"><div class="loader"></div></div>
        <div class="people__items">
          <?php 
          if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
              $query->the_post();
             if($query->tax_query->queries[0]['terms'][0] == 4 || $query->tax_query->queries[0]['terms'][0] == 5) {

              // var_dump($query->tax_query->queries[0]['terms'][0]);
              $avatar = get_the_post_thumbnail() ? 
              get_the_post_thumbnail() : 
              '<img src="' . get_template_directory_uri() . '/assets/image/teatr-nowy-brak-zdjecia.webp" alt="avtar-image">';
              ?>
              <div class="people__items_item">
                <a href="<?php echo get_permalink(); ?>">
                  <?php echo $avatar; ?>
                  <p><?php the_title(); ?></p>
                </a>
              </div>
              <?php
            }
              // else {
              //   var_dump( $query->tax_query->queries[0]['terms'][0]);
              //   $ck = get_term_children( $query->tax_query->queries[0]['terms'][0],  $taxonomy );
              //   var_dump($ck);
              //   foreach ( $ck as $child  ) {
              //     $term_child = get_term_by( 'id', $child,$taxonomy );
              //     echo '<a class="knowledge__item" href="' . get_term_link( $term_child ) . '">
              //       <div class="knowledge__item_img" style="background: url(' . get_template_directory_uri() . '/assets/img/tlo-kafelki.svg">
              //       <p>' . esc_html( $term_child->name ) . '</p>
              //       </div>
                    
              //     </a>';
              //     } 
              // }
            }
          }
          else {
            // Постов не найдено
            echo 'Sorry!';
          }
          
          // Возвращаем оригинальные данные поста. Сбрасываем $post.
          wp_reset_postdata();?>
         

          
        </div>
      </div>
    </section>

  </main><!-- #main -->

<?php get_footer();