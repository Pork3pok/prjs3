<?php

/**
 * Classe gérant l'affichage d'une page.
 * Permet de garder un template général sur le site, et d'en changer facilement et rapidement
 */
class Page {
  /**
   * @var string Texte compris entre <head> et </head>
   */
  private $head  = null ;
  /**
   * @var string Texte compris entre <title> et </title>
   */
  private $title = null ;
  /**
   * @var string Texte compris entre <body> et </body>
   */
  private $body  = null ;

  /**
   * Constructeur
   * @param string $title Titre de la page
   */
  public function __construct($title = "Page sans titre") {
    $this->setTitle($title) ;
  }

  /**
   * Protéger les caractères spéciaux pouvant dégrader la page Web
   * @see http://php.net/manual/en/function.htmlentities.php
   * @param string $string La chaîne à protéger
   *
   * @return string La chaîne protégée
   */
  public function escapeString($string) {
    return htmlentities($string, ENT_QUOTES|ENT_HTML5, "utf-8") ;
  }

  /**
   * Affecter le titre de la page
   * @param string $title Le titre
   */
  public function setTitle($title) {
    $this->title = $title ;
  }

  /**
   * Ajouter un contenu dans head
   * @param string $content Le contenu à ajouter
   *
   * @return void
   */
  public function appendToHead($content) {
    $this->head .= $content ;
  }

  /**
   * Ajouter un contenu CSS dans head
   * @param string $css Le contenu CSS à ajouter
   *
   * @return void
   */
  public function appendCss($css) {
    $this->appendToHead(<<<HTML
  <style type='text/css'>
  $css
  </style>

HTML
) ;
  }

  /**
   * Ajouter l'URL d'un script CSS dans head
   * @param string $url L'URL du script CSS
   *
   * @return void
   */
  public function appendCssUrl($url) {
    $this->appendToHead(<<<HTML
  <link rel="stylesheet" type="text/css" href="{$url}">

HTML
) ;
  }

  /**
   * Ajouter un contenu JavaScript dans head
   * @param string $js Le contenu JavaScript à ajouter
   *
   * @return void
   */
  public function appendJs($js) {
    $this->appendToHead(<<<HTML
  <script type='text/javascript'>
  $js
  </script>

HTML
) ;
  }

  /**
   * Ajouter l'URL d'un script JavaScript dans head
   * @param string $url L'URL du script JavaScript
   *
   * @return void
   */
  public function appendJsUrl($url) {
    $this->appendToHead(<<<HTML
  <script type='text/javascript' src='$url'></script>

HTML
) ;
  }

  /**
   * Ajouter un contenu dans body
   * @param string $content Le contenu à ajouter
   *
   * @return void
   */
  public function appendContent($content) {
    $this->body .= $content ;
  }

  /**
   * Produire la page Web complète
   *
   * @return string
   */
  public function toHTML() {
    //TODO
    //Template générique du site

    return <<<HTML
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>{$this->title}</title>
        {$this->head}
    </head>
    <body>
        {$this->body}
    </body>
</html>
HTML;
  }
}
