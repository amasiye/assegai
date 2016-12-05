<?php
/**
 * The base configurations for BibleApp.
 *
 * This file has the following configurations: MySQL Settings,
 * BASEPATH, Secret Keys.
 *
 * @package Assegai
 */

//** MySQL Settings - This info should be available from the web host. **//

/** Web Host */
$db_host = '127.0.0.1';

/** MySQL database Username */
$db_user = 'root';

/** MySQL database password */
$db_pass = 'mtFE2MVsM8yFRaBN';

/** MySQL database name */
$db_name = 'assegai';

/** MySQL database charset */
$db_charset = 'utf8';

/** MySQL database collate type. Leave blank if unsure. */
$db_collate = '';

/** The default site locale */
$locale = 'en-US';

/** The base path (or absolute path) to the site's root directory. */
# Path information
define('BASEPATH',        "http://localhost/atatusoft/Assegai/assegai/");
define('CDNPATH',         BASEPATH . "app/{$locale }/content/");
define('LOGPATH',         BASEPATH . "app/{$locale}/content/logs/");
define('NOTICEPATH',      BASEPATH . "app/{$locale}/content/logs/");
define('NOTICEPATH_REL',  "app/{$locale}/content/logs/");
define('ABSRESPATH',      BASEPATH . "app/{$locale}/content/resources/");
define('RESPATH',         "app/{$locale}/content/resources/");
define('UPLOADSPATH',     BASEPATH . "uploads/");
define('VIEWSPATH',       "app/{$locale}/views/");
define('BLOGPATH',        "http://assegai.ml/");
define('ABOUTPATH',       "http://assegai.ml/about/");
define('SOFPATH',         "http://assegai.ml/about/statement-of-faith/");

/** Other helpful paths */
define('BOOTSTRAPCSS',    "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
define('BOOTSTRAPJSPATH', "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js");
define('JQUERYPATH',      "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js");

/**#@+
 * Authentication Unique Keys and Salts information.
 * Change these to force all users to log in again.
 */
define('AUTH_KEY',         'agkp1sgIi9M}5;L_Ju<ERzf*h&ZFH[Bt*;k|}t}xUR ]i!%M^F{I=G%DYS<_.,+9');
define('SECURE_AUTH_KEY',  'i7PP-8F]Yl:.!p1aI.:xZfc_We|gGOS35%;C`[p8(t+`NzPfx7C(R`u}Ws75e|0q');
define('LOGGED_IN_KEY',    'r1gYWCeCu^q+hMM~c +Ic0q+qj+Z|-qO#,Li^(xb?mb<yY@:>JXD3:-u2aP,aDFN');
define('NONCE_KEY',        '$E+RSNf*vSvT}%P&Y&VGvLLg!X^3X|I)Leb|kH+|+7GSq,UD[VH?26Jj^oj|c<u~');
define('AUTH_SALT',        'i3]t bWM>s{Y^/<_Cc,g_g$I+M` G|{9^T-CgZAu|ymI$[1wAJ M{etW R~ks5v-');
define('SECURE_AUTH_SALT', ')B$ >5|+}dXo.jRrp&muJ;`k(/-E|_F}&w}(@]DUp 6icpmO:MME184Y?E<f 4ne');
define('LOGGED_IN_SALT',   '#x@qqx7]^uhG}1= 6ZJHA]}rLyB_i22M- wsat-N<!2?06>k9,`F/7t1QsV*<t^p');
define('NONCE_SALT',       'Gc-RFFMg+PBBr2l@z+wC_sc-WxN|Qjnki0B7N>%0xCd1.T.AR%F~zgRCAmJgE?T.');
define('API_KEY',          'e3760bc1b657baa8fd3dd855205e14ca863cc99f1df8675787006a3ec7d4f7d8');

# App information
/*
 Versioning key: a.b.c
 a: Monumental landmark - change to architecture or overall functionality.
 b: Feature additions and implementations
 c: Bug fixes and minor revisions.
 */
define('APP_VER', '0.15.4');

# Site information
define('SITE_NAME', 'Assegai Test');
define('SITE_TAGLINE', 'This is the site tag line.');
define('SITE_PREFIX', 'assegai_');
define('SITE_TIMEZONE', 'America/Halifax');

# Session information
define('SESSION_USER_ID', 'uid');
define('SESSION_USER', 'ulog');
define('SESSION_USER_DISPLAY', 'udisp');
define('SESSION_HASH', 'sessh');

# Useful ids
define('ID_API_KEY',       'apik');
define('ID_TOKEN_NAME',    'tok');
define('TOKEN_NAME',       'tok');    // Deprecated - should use ID_TOKEN_NAME

# Regex patterns
define('REGEX_USERNAME', '/^[\w\d.-]+$/');
define('REGEX_PASSWORD', '/^[\w\d.-]+$/');

# Model table binding
define('DB_PREFIX', 'assg_');
define('POSTS_TABLE',   DB_PREFIX . 'posts');
define('ELEMENT_TABLE', DB_PREFIX . 'posts');
define('PAGE_TABLE',    DB_PREFIX . 'posts');
define('MEDIA_TABLE',   DB_PREFIX . 'posts');  /* Remember media are posts too! */
define('OPTIONS_TABLE', DB_PREFIX . 'options');
define('USERS_TABLE',   DB_PREFIX . 'users');

# Load status codes
require_once 'StatusCodes.php';

function change_locale($locale)
{
  $this->locale = $locale;
}

?>
