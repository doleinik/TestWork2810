<?php
/*
    Template name: Home
*/

?>
<?php get_header(); ?>

<?php $hero = get_field('hero'); ?>
<section class="hero" style="background-image: url(' <?= $hero['background'] ?> ')">
    <div class="container">
        <div class="hero__inner">
            <h1 class="hero__title">
                <?= $hero['title'] ?>
            </h1>
        </div>
    </div>
</section>

<?php $contacts = get_field('contacts'); ?>
<section class="contacts">
    <div class="container">
        <div class="contacts__inner">
            <h2 class="contacts__title">
                <?= $contacts['title'] ?>
            </h2>

            <div class="contacts__wrapper">
                <div class="contacts__elem">
                    <h3 class="contacts__elem-heading">
                        <?= $contacts['heading_1'] ?>
                    </h3>

                    <div class="contacts__info">
                        <div class="contacts__location">
                            <div class="contacts__address">
                                <?= $contacts['address'] ?>
                            </div>

                            <a class="contacts__link" href="tel:<?= $contacts['phone'] ?>"><?= $contacts['phone'] ?></a>
                        </div>

                        <ul class="contacts__list">
                            <?php foreach ($contacts['contact_wrapper'] as $item) { ?>
                                <li class="contacts__item">
                                    <div class="contacts__item-heading">
                                        <?= $item['item']['heading'] ?>
                                    </div>

                                    <a class="contacts__item-link" href="<?= $item['item']['address']['url'] ?>">
                                        <?= $item['item']['address']['text'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="contacts__elem">
                    <h3 class="contacts__elem-heading">
                        <?= $contacts['heading_2'] ?>
                    </h3>

                    <div class="contacts__text">
                        <?= $contacts['text'] ?>
                    </div>

                    <a class="contacts__link" href="tel:<?= $contacts['phone'] ?>"><?= $contacts['phone'] ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $offices = get_field('offices'); ?>
<section class="offices">
    <div class="container">
        <div class="offices__inner">
            <div class="offices__info">
                <h2 class="offices__title">Our Offices</h2>
                <div class="offices__wrapper">
                    <div class="offices__tab">
                        <ul class="offices__tab-toggle">
                            <?php foreach ($offices['tabs'] as $tab) { ?>
                                <li class="offices__tab-item" data-location_x="<?= $tab['tab']['location']['x'] ?>"
                                    data-location_y="<?= $tab['tab']['location']['y'] ?>">
                                    <?= $tab['tab']['name'] ?>
                                </li>
                            <?php } ?>
                        </ul>

                        <ul class="offices__content">
                            <?php foreach ($offices['tabs'] as $tab) { ?>
                                <li class="offices__content-item">
                                    <div class="offices__heading">
                                        <?= $tab['tab']['heading'] ?>
                                    </div>

                                    <div class="offices__address">
                                        <?= $tab['tab']['info'] ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                        <ul class="offices__map">
                            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
                            <?php
                            $i = 0;
                            foreach ($offices['tabs'] as $tab) {
                                ?>
                                <div class="offices__map-item" id="map">
                                    <script>
                                        google.maps.event.addDomListener(window, 'load', init);

                                        function init() {
                                            let mapOptions<?= $i ?> = {
                                                zoom: 16,
                                                center: new google.maps.LatLng(<?= $tab['tab']['location']['x'] ?>, <?= $tab['tab']['location']['y'] ?>),

                                            };

                                            let mapElement = document.querySelectorAll('.offices__map-item');

                                            let map = new google.maps.Map(mapElement[<?= $i ?>], mapOptions<?= $i ?>);

                                            let marker = new google.maps.Marker({
                                                position: new google.maps.LatLng(<?= $tab['tab']['location']['x'] ?>, <?= $tab['tab']['location']['y'] ?>),
                                                map: map,
                                                title: 'Snazzy!'
                                            });
                                        }
                                    </script>
                                </div>
                            <?php
                                $i = $i + 1;}?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>

<?php $contact_us = get_field('contact_us'); ?>
<section class="contact-us">
    <div class="container">
        <div class="contact-us__inner">
            <h2 class="contact-us__title">
                <?= $contact_us['title'] ?>
            </h2>

            <div class="contact-us__wrapper">

                <?= do_shortcode('[contact-form-7 id="70" title="Contact Us"]'); ?>
                <div id="result_form"></div>
                <div class="contact-us__info">
                    <?= $contact_us['text'] ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>

