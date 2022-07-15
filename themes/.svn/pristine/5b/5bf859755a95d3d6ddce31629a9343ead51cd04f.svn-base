<?php
/**********************
Template Name: Kontaktsida
**********************/

get_header(); ?>

    <div id="wrapper">
            <?php include('page-header.php'); ?>

            <div class="col0">
                <?php include('submenu.php');?>

                <?php //include('share.php') ;?>

            </div>

            <div class="col1">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <?php
                        if (strlen(get_field('long_title')) > 0) {
                    ?>
                    <h1><?php the_field('long_title'); ?></h1>
                    <?php } else{ ?>
                        <h1><?php the_title(); ?></h1>
                    <?php } ?>

                    <?php if (function_exists('has_excerpt') && has_excerpt()) the_excerpt(); ?>
                    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'big'); if ( has_post_thumbnail() ) { ?>
                    <img class="featured-image pie" src="<?php echo $thumb[0]; ?>" alt="<?php the_title(); ?>" /> <?php } ?>
                    <?php include('meta.php');?>
                    <?php the_content(); ?>

                <?php endwhile; else: ?>
                        Det finns inget innehåll på denna sida
                    <?php endif; ?>



                <?php

                    $contact_sections = get_field('contact_sections');

                    if($contact_sections):
                ?>

                        <nav class="contact-persons-nav">
                            <h4>Snabblänkar:</h4>
                            <ul class="contact-persons-link-list">
                                <?php
                                    $section_count = count($contact_sections);

                                    foreach ($contact_sections as $key => $contact_section):
                                        $current_count = $key + 1;
                                ?>
                                    <li>
                                        <a href="#contact-section-<?php echo $key; ?>"><?php echo $contact_section['contact_section_header'];?></a><?php if($current_count < $section_count) echo ', '; ?>
                                    </li>
                                <?php
                                    endforeach;
                                ?>
                            </ul>
                        </nav>


                        <section class="contact-persons-wrapper">

                            <h2 class="contact-persons-main-header">Kontaktuppgifter</h2>

                            <?php
                                foreach ($contact_sections as $key => $contact_section):
                                ?>
                                    <section class="contact-persons-section">
                                        <h3 id="contact-section-<?php echo $key; ?>" class="contact-persons-section-header"><?php echo $contact_section['contact_section_header'];?></h3>
                                        <div class="contact-persons-container">
                                            <?php
                                                foreach($contact_section['contact_person'] as $contact_person) {
                                                    $explode_mail = explode("@", $contact_person['contact_person_mail'], 2);
                                                    $shortmail = $explode_mail[0];
                                                ?>
                                                    <article class="contact-person">
                                                        <?php
                                                            if($contact_person['contact_person_img']):
                                                        ?>
                                                            <div class="contact-person-img">
                                                                <img src="<?php echo $contact_person['contact_person_img']['sizes']['press']; ?>" alt="<?php echo $contact_person['contact_person_name']; ?>">
                                                            </div>
                                                        <?php
                                                            endif;
                                                        ?>
                                                        <h4 class="contact-person-name">
                                                            <?php if($contact_person['contact_person_mail']): ?><a href="mailto:<?php echo $contact_person['contact_person_mail']; ?>" title="Skicka ett mail"><?php endif; ?>
                                                                <?php echo $contact_person['contact_person_name']; ?>
                                                            <?php if($contact_person['contact_person_mail']): ?></a><?php endif; ?>
                                                        </h4>
                                                        <div class="contact-person-position"><?php echo $contact_person['contact_person_position']; ?></div>
                                                        <ul class="contact-person-info">
                                                            <?php /*<li class="contact-person-mail">Mail: <a href="mailto:<?php echo $contact_person['contact_person_mail']; ?>" title="Skicka ett mail"><?php echo $shortmail; ?></a></li> */ ?>
                                                            <li class="contact-person-phone">Tel: <a href="tel:<?php echo $contact_person['contact_person_phone']; ?>" title="Ring"><?php echo $contact_person['contact_person_phone']; ?></a></li>
                                                        </ul>
                                                    </article>
                                                <?php
                                                }
                                            ?>
                                        </div>
                                    </section>
                                <?php
                                endforeach; // END CONTACT SECTIONS LOOP
                            ?>
                        </section>

                <?php

                    endif; // END CONTACT SECTIONS


                ?>

                
            </div>
    <?php get_sidebar(); ?>

    <?php get_footer(); ?>

	<div id="main">
