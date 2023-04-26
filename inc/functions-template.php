<?php

/**
 * Custom functions
 *
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;


function singlePerfomanceCard() {

  return <<<HTML
  <div class="performance">
    <div class="performance__header">
      <h6 class="performance__header_title title">Repertuar</h6>
      <a href="#" class="performance__header_cast">Obsada</a>
      <p class="performance__header_category {category-slug}">{category}</p>
    </div>
    <div class="performance__body">
      <div class="performance__body_date">
        <p>
          <span>{date}</span><br>
          {time}
        </p>
      </div>
      <div class="performance__body_image">
        <a href="{show_url}">
          {show_image}
        </a>
      </div>
      <div class="performance__body_content">
        <a href="{show_url}"><h6>{title}</h6> </a>
        <div class="btns">
          <a class="btns__btn" href="{show_url}">Wiecej</a>
          <a href="{buy}" class="btn">Kup bilet</a>
        </div>
      </div>
    </div>
  </div>
  HTML;
}

function pageSwitcher() {
  $show = is_page_template('show.php')  ? 'class="active"' : '';
  $perfomances = is_page_template('perfomances.php') ? 'class="active"' : '';

  $url = get_site_url();

  return <<<HTML
  <ul class="pages">
    <li>
      <a href="$url/spektakle/" $perfomances>Spektakle</a>
    </li>
    <li>
      <a href="$url/repertuar-teatru/" $show>Repertuar teatru</a>
    </li>
    <li>
      <a href="$url">Repertuar imprez gościnnych</a>
    </li>
  </ul>
  HTML;
}