<?php

namespace Model;

require_once(__DIR__ . '/Util.php');
require_once(__DIR__ . '/../core/Context.php');
require_once(__DIR__ . '/../config/SiteConfig.php');

//UserCake uses a text based system with hooks to replace various strs in txt email templates
class userCakeMail {

  public $contents = null;
  private $m_context = null;

  public function __construct(\Core\Context $context) {
    $this->m_context = $context;
  }

  //Function used for replacing hooks in our templates
  public function newTemplateMsg($template,$additionalHooks) {

    $this->contents = file_get_contents(\Config\SiteConfig::MAIL_TEMPLATES_DIR.$template);

    //Check to see we can access the file / it has some contents
    if(!$this->contents || empty($this->contents)) {
      return false;
    } else {
      //Replace default hooks
      $this->contents = $this->replaceDefaultHook($this->contents);
      //Replace defined / custom hooks
      $this->contents = str_replace($additionalHooks["searchStrs"],$additionalHooks["subjectStrs"],$this->contents);
      return true;
    }
  }

  public function sendMail($email,$subject,$msg = NULL) {

    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $header .= "From: ". \Config\SiteConfig::WEBSITE_NAME . " <" . \Config\SiteConfig::EMAIL_ADDRESS . ">\r\n";

    //Check to see if we sending a template email.
    if($msg == NULL) {
      $msg = $this->contents;
    }
    $message = $msg;
    $message = wordwrap($message, 70);
    return mail($email,$subject,$message,$header);
  }

  //Replaces hooks with specified text
  private function replaceDefaultHook($str) {
    return str_replace(
      $this->getDefaultHooks(),
      $this->getDefaultReplace(),
      $str
    );
  }

  private function getDefaultHooks() {
    return array('#WEBSITENAME#','#WEBSITEURL#','#DATE#');
  }

  private function getDefaultReplace() {
    return array(
      \Config\SiteConfig::WEBSITE_NAME,
      \Config\SiteConfig::WEBSITE_URL,
      date('dmy'),
    );
  }

}

?>
