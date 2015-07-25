<?php

namespace Model;

require_once(__DIR__ . '/Util.php');
require_once(__DIR__ . '/../core/Context.php');

class userCakeMail {
  //UserCake uses a text based system with hooks to replace various strs in txt email templates
  public $contents = null;
  private $m_context = null;

  public function __construct(\Core\Context $context) {
    $this->m_context = $context;
  }

  //Function used for replacing hooks in our templates
  public function newTemplateMsg($template,$additionalHooks) {

    $this->contents = file_get_contents(\Core\Context::MAIL_TEMPLATES_DIR.$template);

    //Check to see we can access the file / it has some contents
    if(!$this->contents || empty($this->contents)) {
      return false;
    } else {
      //Replace default hooks
      $this->contents = Util::replaceDefaultHook($m_context, $this->contents);
      //Replace defined / custom hooks
      $this->contents = str_replace($additionalHooks["searchStrs"],$additionalHooks["subjectStrs"],$this->contents);
      return true;
    }
  }

  public function sendMail($email,$subject,$msg = NULL) {

    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $header .= "From: ". \Core\Context::WEBSITE_NAME . " <" . \Core\Context::EMAIL_ADDRESS . ">\r\n";

    //Check to see if we sending a template email.
    if($msg == NULL) {
      $msg = $this->contents;
    }
    $message = $msg;
    $message = wordwrap($message, 70);
    return mail($email,$subject,$message,$header);
  }
}

?>
