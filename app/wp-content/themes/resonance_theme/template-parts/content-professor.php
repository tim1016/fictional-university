<div class="row">
    <li class="person-card__list-item">
        <a class="person-card" href="<?php the_permalink(); ?>">
            <img class="person-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>">
            <span class="person-card__name"><?php the_title(); ?></span>
        </a>
    </li>
</div>