<?hh

require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

abstract class :x:page:view extends :x:element {

  const string BOOTSTRAP_CSS_CDN =
      "//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css";
  const string BOOTSTRAP_JQUERY_CDN = 
      "//code.jquery.com/jquery-1.11.0.min.js";
  const string BOOTSTRAP_JS_CDN =
      "//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js";

  public function render() {
    return
      <html>
        <head>
          <!-- Latest compiled and minified CSS -->
          <link
            rel="stylesheet"
            href={self::BOOTSTRAP_CSS_CDN}
          />
          <script src={self::BOOTSTRAP_JQUERY_CDN} />
          <!-- Latest compiled and minified JavaScript -->
          <script
            src={self::BOOTSTRAP_JS_CDN}
          />
        </head>
        <body>
          {$this->getBody()}
        </body>
     </html>;
  }

  protected function getBody(): :x:frag {
    return <x:frag/>;
  }

}

