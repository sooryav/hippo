<?hh

namespace Config;

class SiteConfig {
  const string MAIL_TEMPLATES_DIR = __DIR__ . '/../html/view/templates/';
  const string EMAIL_ADDRESS = 'hippos@hippo.com';
  const string WEBSITE_NAME = 'Hippo';
  const string WEBSITE_URL = 'localhost';
  const int MASTER_ACCOUNT = 1;
  const bool EMAIL_ACTIVATION = false;
  const string RESEND_ACTIVATION_THRESHOLD = '0';
}
