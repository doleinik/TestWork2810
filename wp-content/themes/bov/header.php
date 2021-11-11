<!doctype html>
<html <?php language_attributes() ?>>
<head>
    <meta charset=<?php bloginfo('charset'); ?>>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>

    <style><?php include "custom-styles.css" ?></style>
</head>

<body <?php body_class(); ?>>

<?php include "js/inline-js.php" ?>


<?php $header = get_field('header', 'option') ?>
<div class="main-wrapper">
    <header class="header" id="header">
        <div class="container">
            <div class="header__inner">
                <div class="header__logo">
                    <a class="header__logo-link  " href="<?= get_home_url(); ?>">
                        <?php echo wp_get_attachment_image($header['logo'], 'full'); ?>
                    </a>
                </div>

                <nav class="header__menu">
                    <?php echo getMenu('main-menu-header', 'header',
                        new HierarchyMenuWalker());
                    ?>
                </nav>

                <div class="header__hamburger">
                    <div class="header__hamburger-item"></div>
                    <div class="header__hamburger-item"></div>
                    <div class="header__hamburger-item"></div>
                </div>

                <div class="header__hamburger-close">
                    <div class="header__hamburger-close-item"></div>
                    <div class="header__hamburger-close-item"></div>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">






