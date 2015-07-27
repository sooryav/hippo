<?hh

require_once(__DIR__ . '/HeaderView.php');
require_once(__DIR__ . '/FooterView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

abstract class :x:page:view extends :x:element {

  const string BOOTSTRAP_CSS_CDN =
      '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css';
  const string BOOTSTRAP_JQUERY_CDN =
      '//code.jquery.com/jquery-1.11.0.min.js';
  const string BOOTSTRAP_JS_CDN =
      '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js';
  const string LOGIN_CSS = __DIR__ . '/../css/login.css';
  const string LOGIN_JS = __DIR__ . '/../js/login.js';

  public function render() {
    return
      <html>
        <head>
          <meta
            http-equiv="Content-Type"
            content="text/html; charset=utf-8"
          />
          <!-- Latest compiled and minified CSS -->
          <link
            rel="stylesheet"
            href={self::BOOTSTRAP_CSS_CDN}
          />
          <link
            rel="stylesheet"
            type="text/css"
            href={$this->getCSS()}
          />
          <!-- script src={self::BOOTSTRAP_JQUERY_CDN} />
          <!-- Latest compiled and minified JavaScript -->
          <script
            src={self::BOOTSTRAP_JS_CDN}
          />
          <script
            src={$this->getJS()}
          />
        </head>
        <body>
          <header:view />
          {$this->getBody()}
          <footer:view />
        </body>
     </html>;
  }

  protected function getBody(): :x:frag {
    return <x:frag/>;
  }

  protected function getCSS(): string {
    return '';
  }
  protected function getJS(): string {
    return '';
  }

}
