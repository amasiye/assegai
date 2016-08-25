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
$db_pass = '';

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
define('BASEPATH', "http://localhost/atatusoft/Assegai/assegai/");
define('CDNPATH', BASEPATH . "app/{$locale }/content/");
define('LOGPATH', BASEPATH . "app/{$locale}/content/logs/");

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
define('TOKEN_NAME',       'tok');

# App information
define('APP_VER', '0.1.0');

# Site information
define('SITE_NAME', '%SITE NAME%');
define('SITE_TAGLINE', 'His Word Is A Light Unto Our Feet.');
define('SITE_PREFIX', 'assegai_');

# Session information
define('SESSION_USER_ID', 'uid');
define('SESSION_USER', 'ulog');

# Load status codes
require_once 'StatusCodes.php';

function change_locale($locale)
{
  $this->locale = $locale;
}

?>
