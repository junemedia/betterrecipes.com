<?php

/**
 * User form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
//class UserForm extends BaseUserForm {
class OnesiteUserForm extends BaseForm {

  protected $gender = array(
      0 => 'male',
      1 => 'female',
      2 => 'unsure',
      3 => 'undisclosed'
  ); // 0 (male) or 1 (female) 2 (undefined) or 3 (unspecified)
  protected $dob_display = array(
      'private' => 'private',
      'friends' => 'visible to friends',
      'age_only' => 'age only',
      'birthday_only' => 'birthday only',
      'full' => 'full'
  ); // One of ('full', 'birthday_only', 'age_only', 'private', 'friends')
  protected $account_status = array(
      'pending' => 'pending',
      'good-standing' => 'good standing',
      'delinquent' => 'delinquent',
      'inactive' => 'inactive',
      'disabled' => 'disabled',
      'deleted' => 'deleted'
  ); // One of ('pending', 'good-standing', 'delinquent', 'inactive', 'disabled', 'deleted')
  protected $user_type = array(
      'network_admin' => 'network admin',
      'node_admin' => 'node admin',
      'user' => 'user'
  ); // One of ('network_admin', 'node_admin', 'user')
  protected $message_privacy = array(
      0 => 'Allow messages from all users',
      1 => 'Allow messages from friends only'
  );
  protected $friends_approval = array(
      0 => 'Manually approve friend requests',
      1 => 'Auto-approve friend requests'
  );
  protected $comments_approval = array(
      0 => 'Manually approve comments',
      1 => 'Auto-approve all comments',
      2 => 'Auto-approve comments from friends, but manually approve others'
  );
  protected $email_notification = array(
      'ongoing' => 'ongoing',
      'daily' => 'daily',
      'weekly' => 'weekly',
      'none' => 'none'
  ); // One of ('none', 'daily', 'weekly', 'ongoing')
  protected $state_list = array(
      'AL' => "Alabama",
      'AK' => "Alaska",
      'AZ' => "Arizona",
      'AR' => "Arkansas",
      'CA' => "California",
      'CO' => "Colorado",
      'CT' => "Connecticut",
      'DE' => "Delaware",
      'DC' => "District Of Columbia",
      'FL' => "Florida",
      'GA' => "Georgia",
      'HI' => "Hawaii",
      'ID' => "Idaho",
      'IL' => "Illinois",
      'IN' => "Indiana",
      'IA' => "Iowa",
      'KS' => "Kansas",
      'KY' => "Kentucky",
      'LA' => "Louisiana",
      'ME' => "Maine",
      'MD' => "Maryland",
      'MA' => "Massachusetts",
      'MI' => "Michigan",
      'MN' => "Minnesota",
      'MS' => "Mississippi",
      'MO' => "Missouri",
      'MT' => "Montana",
      'NE' => "Nebraska",
      'NV' => "Nevada",
      'NH' => "New Hampshire",
      'NJ' => "New Jersey",
      'NM' => "New Mexico",
      'NY' => "New York",
      'NC' => "North Carolina",
      'ND' => "North Dakota",
      'OH' => "Ohio",
      'OK' => "Oklahoma",
      'OR' => "Oregon",
      'PA' => "Pennsylvania",
      'RI' => "Rhode Island",
      'SC' => "South Carolina",
      'SD' => "South Dakota",
      'TN' => "Tennessee",
      'TX' => "Texas",
      'UT' => "Utah",
      'VT' => "Vermont",
      'VA' => "Virginia",
      'WA' => "Washington",
      'WV' => "West Virginia",
      'WI' => "Wisconsin",
      'WY' => "Wyoming"
  );
  protected $country_list = array(
      'AF' => 'AFGHANISTAN',
      'AL' => 'ALBANIA',
      'DZ' => 'ALGERIA',
      'AS' => 'AMERICAN SAMOA',
      'AD' => 'ANDORRA',
      'AO' => 'ANGOLA',
      'AI' => 'ANGUILLA',
      'AQ' => 'ANTARCTICA',
      'AG' => 'ANTIGUA AND BARBUDA',
      'AR' => 'ARGENTINA',
      'AM' => 'ARMENIA',
      'AW' => 'ARUBA',
      'AU' => 'AUSTRALIA',
      'AT' => 'AUSTRIA',
      'AZ' => 'AZERBAIJAN',
      'BS' => 'BAHAMAS',
      'BH' => 'BAHRAIN',
      'BD' => 'BANGLADESH',
      'BB' => 'BARBADOS',
      'BY' => 'BELARUS',
      'BE' => 'BELGIUM',
      'BZ' => 'BELIZE',
      'BJ' => 'BENIN',
      'BM' => 'BERMUDA',
      'BT' => 'BHUTAN',
      'BO' => 'BOLIVIA',
      'BA' => 'BOSNIA AND HERZEGOVINA',
      'BW' => 'BOTSWANA',
      'BV' => 'BOUVET ISLAND',
      'BR' => 'BRAZIL',
      'IO' => 'BRITISH INDIAN OCEAN TERRITORY',
      'BN' => 'BRUNEI DARUSSALAM',
      'BG' => 'BULGARIA',
      'BF' => 'BURKINA FASO',
      'BI' => 'BURUNDI',
      'KH' => 'CAMBODIA',
      'CM' => 'CAMEROON',
      'CA' => 'CANADA',
      'CV' => 'CAPE VERDE',
      'KY' => 'CAYMAN ISLANDS',
      'CF' => 'CENTRAL AFRICAN REPUBLIC',
      'TD' => 'CHAD',
      'CL' => 'CHILE',
      'CN' => 'CHINA',
      'CX' => 'CHRISTMAS ISLAND',
      'CC' => 'COCOS (KEELING) ISLANDS',
      'CO' => 'COLOMBIA',
      'KM' => 'COMOROS',
      'CG' => 'CONGO',
      'CD' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
      'CK' => 'COOK ISLANDS',
      'CR' => 'COSTA RICA',
      'CI' => 'COTE D IVOIRE',
      'HR' => 'CROATIA',
      'CU' => 'CUBA',
      'CY' => 'CYPRUS',
      'CZ' => 'CZECH REPUBLIC',
      'DK' => 'DENMARK',
      'DJ' => 'DJIBOUTI',
      'DM' => 'DOMINICA',
      'DO' => 'DOMINICAN REPUBLIC',
      'TP' => 'EAST TIMOR',
      'EC' => 'ECUADOR',
      'EG' => 'EGYPT',
      'SV' => 'EL SALVADOR',
      'GQ' => 'EQUATORIAL GUINEA',
      'ER' => 'ERITREA',
      'EE' => 'ESTONIA',
      'ET' => 'ETHIOPIA',
      'FK' => 'FALKLAND ISLANDS (MALVINAS)',
      'FO' => 'FAROE ISLANDS',
      'FJ' => 'FIJI',
      'FI' => 'FINLAND',
      'FR' => 'FRANCE',
      'GF' => 'FRENCH GUIANA',
      'PF' => 'FRENCH POLYNESIA',
      'TF' => 'FRENCH SOUTHERN TERRITORIES',
      'GA' => 'GABON',
      'GM' => 'GAMBIA',
      'GE' => 'GEORGIA',
      'DE' => 'GERMANY',
      'GH' => 'GHANA',
      'GI' => 'GIBRALTAR',
      'GR' => 'GREECE',
      'GL' => 'GREENLAND',
      'GD' => 'GRENADA',
      'GP' => 'GUADELOUPE',
      'GU' => 'GUAM',
      'GT' => 'GUATEMALA',
      'GN' => 'GUINEA',
      'GW' => 'GUINEA-BISSAU',
      'GY' => 'GUYANA',
      'HT' => 'HAITI',
      'HM' => 'HEARD ISLAND AND MCDONALD ISLANDS',
      'VA' => 'HOLY SEE (VATICAN CITY STATE)',
      'HN' => 'HONDURAS',
      'HK' => 'HONG KONG',
      'HU' => 'HUNGARY',
      'IS' => 'ICELAND',
      'IN' => 'INDIA',
      'ID' => 'INDONESIA',
      'IR' => 'IRAN, ISLAMIC REPUBLIC OF',
      'IQ' => 'IRAQ',
      'IE' => 'IRELAND',
      'IL' => 'ISRAEL',
      'IT' => 'ITALY',
      'JM' => 'JAMAICA',
      'JP' => 'JAPAN',
      'JO' => 'JORDAN',
      'KZ' => 'KAZAKSTAN',
      'KE' => 'KENYA',
      'KI' => 'KIRIBATI',
      'KP' => 'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',
      'KR' => 'KOREA REPUBLIC OF',
      'KW' => 'KUWAIT',
      'KG' => 'KYRGYZSTAN',
      'LA' => 'LAO PEOPLES DEMOCRATIC REPUBLIC',
      'LV' => 'LATVIA',
      'LB' => 'LEBANON',
      'LS' => 'LESOTHO',
      'LR' => 'LIBERIA',
      'LY' => 'LIBYAN ARAB JAMAHIRIYA',
      'LI' => 'LIECHTENSTEIN',
      'LT' => 'LITHUANIA',
      'LU' => 'LUXEMBOURG',
      'MO' => 'MACAU',
      'MK' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
      'MG' => 'MADAGASCAR',
      'MW' => 'MALAWI',
      'MY' => 'MALAYSIA',
      'MV' => 'MALDIVES',
      'ML' => 'MALI',
      'MT' => 'MALTA',
      'MH' => 'MARSHALL ISLANDS',
      'MQ' => 'MARTINIQUE',
      'MR' => 'MAURITANIA',
      'MU' => 'MAURITIUS',
      'YT' => 'MAYOTTE',
      'MX' => 'MEXICO',
      'FM' => 'MICRONESIA, FEDERATED STATES OF',
      'MD' => 'MOLDOVA, REPUBLIC OF',
      'MC' => 'MONACO',
      'MN' => 'MONGOLIA',
      'MS' => 'MONTSERRAT',
      'MA' => 'MOROCCO',
      'MZ' => 'MOZAMBIQUE',
      'MM' => 'MYANMAR',
      'NA' => 'NAMIBIA',
      'NR' => 'NAURU',
      'NP' => 'NEPAL',
      'NL' => 'NETHERLANDS',
      'AN' => 'NETHERLANDS ANTILLES',
      'NC' => 'NEW CALEDONIA',
      'NZ' => 'NEW ZEALAND',
      'NI' => 'NICARAGUA',
      'NE' => 'NIGER',
      'NG' => 'NIGERIA',
      'NU' => 'NIUE',
      'NF' => 'NORFOLK ISLAND',
      'MP' => 'NORTHERN MARIANA ISLANDS',
      'NO' => 'NORWAY',
      'OM' => 'OMAN',
      'PK' => 'PAKISTAN',
      'PW' => 'PALAU',
      'PS' => 'PALESTINIAN TERRITORY, OCCUPIED',
      'PA' => 'PANAMA',
      'PG' => 'PAPUA NEW GUINEA',
      'PY' => 'PARAGUAY',
      'PE' => 'PERU',
      'PH' => 'PHILIPPINES',
      'PN' => 'PITCAIRN',
      'PL' => 'POLAND',
      'PT' => 'PORTUGAL',
      'PR' => 'PUERTO RICO',
      'QA' => 'QATAR',
      'RE' => 'REUNION',
      'RO' => 'ROMANIA',
      'RU' => 'RUSSIAN FEDERATION',
      'RW' => 'RWANDA',
      'SH' => 'SAINT HELENA',
      'KN' => 'SAINT KITTS AND NEVIS',
      'LC' => 'SAINT LUCIA',
      'PM' => 'SAINT PIERRE AND MIQUELON',
      'VC' => 'SAINT VINCENT AND THE GRENADINES',
      'WS' => 'SAMOA',
      'SM' => 'SAN MARINO',
      'ST' => 'SAO TOME AND PRINCIPE',
      'SA' => 'SAUDI ARABIA',
      'SN' => 'SENEGAL',
      'SC' => 'SEYCHELLES',
      'SL' => 'SIERRA LEONE',
      'SG' => 'SINGAPORE',
      'SK' => 'SLOVAKIA',
      'SI' => 'SLOVENIA',
      'SB' => 'SOLOMON ISLANDS',
      'SO' => 'SOMALIA',
      'ZA' => 'SOUTH AFRICA',
      'GS' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
      'ES' => 'SPAIN',
      'LK' => 'SRI LANKA',
      'SD' => 'SUDAN',
      'SR' => 'SURINAME',
      'SJ' => 'SVALBARD AND JAN MAYEN',
      'SZ' => 'SWAZILAND',
      'SE' => 'SWEDEN',
      'CH' => 'SWITZERLAND',
      'SY' => 'SYRIAN ARAB REPUBLIC',
      'TW' => 'TAIWAN, PROVINCE OF CHINA',
      'TJ' => 'TAJIKISTAN',
      'TZ' => 'TANZANIA, UNITED REPUBLIC OF',
      'TH' => 'THAILAND',
      'TG' => 'TOGO',
      'TK' => 'TOKELAU',
      'TO' => 'TONGA',
      'TT' => 'TRINIDAD AND TOBAGO',
      'TN' => 'TUNISIA',
      'TR' => 'TURKEY',
      'TM' => 'TURKMENISTAN',
      'TC' => 'TURKS AND CAICOS ISLANDS',
      'TV' => 'TUVALU',
      'UG' => 'UGANDA',
      'UA' => 'UKRAINE',
      'AE' => 'UNITED ARAB EMIRATES',
      'GB' => 'UNITED KINGDOM',
      'US' => 'UNITED STATES',
      'UM' => 'UNITED STATES MINOR OUTLYING ISLANDS',
      'UY' => 'URUGUAY',
      'UZ' => 'UZBEKISTAN',
      'VU' => 'VANUATU',
      'VE' => 'VENEZUELA',
      'VN' => 'VIET NAM',
      'VG' => 'VIRGIN ISLANDS, BRITISH',
      'VI' => 'VIRGIN ISLANDS, U.S.',
      'WF' => 'WALLIS AND FUTUNA',
      'EH' => 'WESTERN SAHARA',
      'YE' => 'YEMEN',
      'YU' => 'YUGOSLAVIA',
      'ZM' => 'ZAMBIA',
      'ZW' => 'ZIMBABWE'
  );
  protected $timezones = array(
      '' => '',
      'Pacific/Midway' => "(GMT-11:00) Midway Island",
      'US/Samoa' => "(GMT-11:00) Samoa",
      'US/Hawaii' => "(GMT-10:00) Hawaii",
      'US/Alaska' => "(GMT-09:00) Alaska",
      'US/Pacific' => "(GMT-08:00) Pacific Time (US &amp; Canada)",
      'America/Tijuana' => "(GMT-08:00) Tijuana",
      'US/Arizona' => "(GMT-07:00) Arizona",
      'US/Mountain' => "(GMT-07:00) Mountain Time (US &amp; Canada)",
      'America/Chihuahua' => "(GMT-07:00) Chihuahua",
      'America/Mazatlan' => "(GMT-07:00) Mazatlan",
      'America/Mexico_City' => "(GMT-06:00) Mexico City",
      'America/Monterrey' => "(GMT-06:00) Monterrey",
      'Canada/Saskatchewan' => "(GMT-06:00) Saskatchewan",
      'US/Central' => "(GMT-06:00) Central Time (US &amp; Canada)",
      'US/Eastern' => "(GMT-05:00) Eastern Time (US &amp; Canada)",
      'US/East-Indiana' => "(GMT-05:00) Indiana (East)",
      'America/Bogota' => "(GMT-05:00) Bogota",
      'America/Lima' => "(GMT-05:00) Lima",
      'America/Caracas' => "(GMT-04:30) Caracas",
      'Canada/Atlantic' => "(GMT-04:00) Atlantic Time (Canada)",
      'America/La_Paz' => "(GMT-04:00) La Paz",
      'America/Santiago' => "(GMT-04:00) Santiago",
      'Canada/Newfoundland' => "(GMT-03:30) Newfoundland",
      'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
      'Greenland' => "(GMT-03:00) Greenland",
      'Atlantic/Stanley' => "(GMT-02:00) Stanley",
      'Atlantic/Azores' => "(GMT-01:00) Azores",
      'Atlantic/Cape_Verde' => "(GMT-01:00) Cape Verde Is.",
      'Africa/Casablanca' => "(GMT) Casablanca",
      'Europe/Dublin' => "(GMT) Dublin",
      'Europe/Lisbon' => "(GMT) Lisbon",
      'Europe/London' => "(GMT) London",
      'Africa/Monrovia' => "(GMT) Monrovia",
      'Europe/Amsterdam' => "(GMT+01:00) Amsterdam",
      'Europe/Belgrade' => "(GMT+01:00) Belgrade",
      'Europe/Berlin' => "(GMT+01:00) Berlin",
      'Europe/Bratislava' => "(GMT+01:00) Bratislava",
      'Europe/Brussels' => "(GMT+01:00) Brussels",
      'Europe/Budapest' => "(GMT+01:00) Budapest",
      'Europe/Copenhagen' => "(GMT+01:00) Copenhagen",
      'Europe/Ljubljana' => "(GMT+01:00) Ljubljana",
      'Europe/Madrid' => "(GMT+01:00) Madrid",
      'Europe/Paris' => "(GMT+01:00) Paris",
      'Europe/Prague' => "(GMT+01:00) Prague",
      'Europe/Rome' => "(GMT+01:00) Rome",
      'Europe/Sarajevo' => "(GMT+01:00) Sarajevo",
      'Europe/Skopje' => "(GMT+01:00) Skopje",
      'Europe/Stockholm' => "(GMT+01:00) Stockholm",
      'Europe/Vienna' => "(GMT+01:00) Vienna",
      'Europe/Warsaw' => "(GMT+01:00) Warsaw",
      'Europe/Zagreb' => "(GMT+01:00) Zagreb",
      'Europe/Athens' => "(GMT+02:00) Athens",
      'Europe/Bucharest' => "(GMT+02:00) Bucharest",
      'Africa/Cairo' => "(GMT+02:00) Cairo",
      'Africa/Harare' => "(GMT+02:00) Harare",
      'Europe/Helsinki' => "(GMT+02:00) Helsinki",
      'Europe/Istanbul' => "(GMT+02:00) Istanbul",
      'Asia/Jerusalem' => "(GMT+02:00) Jerusalem",
      'Europe/Kiev' => "(GMT+02:00) Kyiv",
      'Europe/Minsk' => "(GMT+02:00) Minsk",
      'Europe/Riga' => "(GMT+02:00) Riga",
      'Europe/Sofia' => "(GMT+02:00) Sofia",
      'Europe/Tallinn' => "(GMT+02:00) Tallinn",
      'Europe/Vilnius' => "(GMT+02:00) Vilnius",
      'Asia/Baghdad' => "(GMT+03:00) Baghdad",
      'Asia/Kuwait' => "(GMT+03:00) Kuwait",
      'Europe/Moscow' => "(GMT+03:00) Moscow",
      'Africa/Nairobi' => "(GMT+03:00) Nairobi",
      'Asia/Riyadh' => "(GMT+03:00) Riyadh",
      'Europe/Volgograd' => "(GMT+03:00) Volgograd",
      'Asia/Tehran' => "(GMT+03:30) Tehran",
      'Asia/Baku' => "(GMT+04:00) Baku",
      'Asia/Muscat' => "(GMT+04:00) Muscat",
      'Asia/Tbilisi' => "(GMT+04:00) Tbilisi",
      'Asia/Yerevan' => "(GMT+04:00) Yerevan",
      'Asia/Kabul' => "(GMT+04:30) Kabul",
      'Asia/Yekaterinburg' => "(GMT+05:00) Ekaterinburg",
      'Asia/Karachi' => "(GMT+05:00) Karachi",
      'Asia/Tashkent' => "(GMT+05:00) Tashkent",
      'Asia/Kolkata' => "(GMT+05:30) Kolkata",
      'Asia/Kathmandu' => "(GMT+05:45) Kathmandu",
      'Asia/Almaty' => "(GMT+06:00) Almaty",
      'Asia/Dhaka' => "(GMT+06:00) Dhaka",
      'Asia/Novosibirsk' => "(GMT+06:00) Novosibirsk",
      'Asia/Bangkok' => "(GMT+07:00) Bangkok",
      'Asia/Jakarta' => "(GMT+07:00) Jakarta",
      'Asia/Krasnoyarsk' => "(GMT+07:00) Krasnoyarsk",
      'Asia/Chongqing' => "(GMT+08:00) Chongqing",
      'Asia/Hong_Kong' => "(GMT+08:00) Hong Kong",
      'Asia/Irkutsk' => "(GMT+08:00) Irkutsk",
      'Asia/Kuala_Lumpur' => "(GMT+08:00) Kuala Lumpur",
      'Australia/Perth' => "(GMT+08:00) Perth",
      'Asia/Singapore' => "(GMT+08:00) Singapore",
      'Asia/Taipei' => "(GMT+08:00) Taipei",
      'Asia/Ulaanbaatar' => "(GMT+08:00) Ulaan Bataar",
      'Asia/Urumqi' => "(GMT+08:00) Urumqi",
      'Asia/Seoul' => "(GMT+09:00) Seoul",
      'Asia/Tokyo' => "(GMT+09:00) Tokyo",
      'Asia/Yakutsk' => "(GMT+09:00) Yakutsk",
      'Australia/Adelaide' => "(GMT+09:30) Adelaide",
      'Australia/Darwin' => "(GMT+09:30) Darwin",
      'Australia/Brisbane' => "(GMT+10:00) Brisbane",
      'Australia/Canberra' => "(GMT+10:00) Canberra",
      'Pacific/Guam' => "(GMT+10:00) Guam",
      'Australia/Hobart' => "(GMT+10:00) Hobart",
      'Australia/Melbourne' => "(GMT+10:00) Melbourne",
      'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
      'Australia/Sydney' => "(GMT+10:00) Sydney",
      'Asia/Vladivostok' => "(GMT+10:00) Vladivostok",
      'Asia/Magadan' => "(GMT+11:00) Magadan",
      'Pacific/Auckland' => "(GMT+12:00) Auckland",
      'Pacific/Fiji' => "(GMT+12:00) Fiji",
      'Asia/Kamchatka' => "(GMT+12:00) Kamchatka",
  );

  public function setup() {
    parent::configure();

    $years = range(date('Y') - 105, date('Y') - 5);
    $this->years = array_combine($years, $years);

    $this->setWidgets(array(
        'user_id' => new sfWidgetFormInputHidden(),
        'firstname' => new sfWidgetFormInputText(),
        'lastname' => new sfWidgetFormInputText(),
        'username' => new sfWidgetFormInputHidden(),
        'display_name' => new sfWidgetFormInputText(),
        'email' => new sfWidgetFormInputText(),
        'password' => new sfWidgetFormInputPassword(),
        'phone' => new sfWidgetFormInputText(),
        'address' => new sfWidgetFormInputText(),
        'address2' => new sfWidgetFormInputText(),
        'city' => new sfWidgetFormInputText(),
        'state' => new sfWidgetFormChoice(array('choices' => $this->state_list)),
        'zip' => new sfWidgetFormInputText(),
        'country' => new sfWidgetFormChoice(array('choices' => $this->country_list)),
        'display_location' => new sfWidgetFormInputText(),
        'geo_zip' => new sfWidgetFormInputText(),
        'geo_market' => new sfWidgetFormInputText(),
        'personal_quote' => new sfWidgetFormTextarea(),
        'birth' => new sfWidgetFormDate(array('years' => $this->years)),
        'gender' => new sfWidgetFormChoice(array('choices' => $this->gender)),
        'dob_display' => new sfWidgetFormChoice(array('choices' => $this->dob_display)),
        'timezone' => new sfWidgetFormChoice(array('choices' => $this->timezones)),
        'account_status' => new sfWidgetFormChoice(array('choices' => $this->account_status)),
        'user_type' => new sfWidgetFormChoice(array('choices' => $this->user_type)),
        'message_privacy' => new sfWidgetFormChoice(array('choices' => $this->message_privacy)),
        'friends_approval' => new sfWidgetFormChoice(array('choices' => $this->friends_approval)),
        'comments_approval' => new sfWidgetFormChoice(array('choices' => $this->comments_approval)),
        'email_notification' => new sfWidgetFormChoice(array('choices' => $this->email_notification)),
        'is_searchable' => new sfWidgetFormChoice(array('choices' => array(1 => 'yes', 0 => 'no'))),
        'group_broadcast' => new sfWidgetFormChoice(array('choices' => array(1 => 'yes', 0 => 'no'))),
        'show_online_now' => new sfWidgetFormChoice(array('choices' => array(1 => 'yes', 0 => 'no'))),
        'comments_html' => new sfWidgetFormChoice(array('choices' => array(1 => 'yes', 0 => 'no'))),
//        'style_id' => new sfWidgetFormInputText(),
//        'parent_user' => new sfWidgetFormInputText(),
//        'ext_profile' => new sfWidgetFormInputText(),
    ));
    
    $this->widgetSchema->setLabels(array(
        'user_id' => 'User ID',
        'firstname' => 'First Name',
        'lastname' => 'Last Name',
        'username' => 'Username',
        'display_name' => 'Display Name',
        'email' => 'Email',
        'password' => 'Password',
        'phone' => 'Phone',
        'address' => 'Address',
        'address2' => 'Address 2',
        'city' => 'City',
        'state' => 'State',
        'zip' => 'Zip Code',
        'country' => 'Country',
        'display_location' => 'Display Location',
        'geo_zip' => 'Geo Zip',
        'geo_market' => 'Geo Market',
        'personal_quote' => 'About Me',
        'birth' => 'Birth Date',
        'gender' => 'Gender',
        'dob_display' => 'DOB Display',
        'timezone' => 'Timezone',
        'account_status' => 'Account Status',
        'user_type' => 'User Type',
        'message_privacy' => 'Message Privacy',
        'friends_approval' => 'Friends Aproval',
        'comments_approval' => 'Comments Approval',
        'email_notification' => 'Email Notification',
        'is_searchable' => 'Is Searchable',
        'group_broadcast' => 'Group Broadcast',
        'show_online_now' => 'Show Online Now',
        'comments_html' => 'Comments HTML',
//        'style_id' => new sfWidgetFormInputText(),
//        'parent_user' => new sfWidgetFormInputText(),
//        'ext_profile' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
        'user_id' => new sfValidatorInteger(array('required' => false)),
        'username' => new sfValidatorString(array('max_length' => 70)),
        'password' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
        'email' => new sfValidatorEmail(array('max_length' => 192, 'required' => true)),
        'firstname' => new sfValidatorString(array('max_length' => 128, 'required' => true)),
        'lastname' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
        'phone' => new sfValidatorString(array('max_length' => 25, 'required' => false)),
        'birth' => new sfValidatorDate(array('min' => date('Y-m-d', strtotime('-105 years')), 'max' => date('Y-m-d', strtotime('-5 years')), 'required' => false)),
        'address' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
        'address2' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
        'city' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
        'state' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->state_list))),
        'zip' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
        'country' => new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->country_list))),
        'display_name' => new sfValidatorString(array('max_length' => 128, 'required' => true)),
        'personal_quote' => new sfValidatorString(array('required' => false)),
        'gender' => new sfValidatorAnd(array(
            new sfValidatorChoice(array('choices' => array_keys($this->gender), 'required' => false)),
            new sfValidatorInteger()
        )),
        'dob_display' => new sfValidatorChoice(array('choices' => array_keys($this->dob_display), 'required' => false)),
        'timezone' => new sfValidatorAnd(array(
            new sfValidatorChoice(array('choices' => array_keys($this->timezones), 'required' => false)),
            new sfValidatorInteger()
        )),
        'account_status' => new sfValidatorChoice(array('choices' => array_keys($this->account_status), 'required' => false)),
        'user_type' => new sfValidatorChoice(array('choices' => array_keys($this->user_type), 'required' => false)),
        'message_privacy' => new sfValidatorAnd(array(
            new sfValidatorChoice(array('choices' => array_keys($this->message_privacy), 'required' => false)),
            new sfValidatorInteger()
        )),
        'friends_approval' => new sfValidatorChoice(array('choices' => array_keys($this->friends_approval), 'required' => false)),
        'comments_approval' => new sfValidatorChoice(array('choices' => array_keys($this->comments_approval), 'required' => false)),
        'geo_zip' => new sfValidatorString(array('required' => false)),
        'geo_market' => new sfValidatorString(array('required' => false)),
        'email_notification' => new sfValidatorChoice(array('choices' => array_keys($this->email_notification), 'required' => false)),
        'is_searchable' => new sfValidatorChoice(array('choices' => array(0, 1), 'required' => false)),
        'display_location' => new sfValidatorString(array('required' => false)),
        'group_broadcast' => new sfValidatorChoice(array('choices' => array(0, 1), 'required' => false)),
        'show_online_now' => new sfValidatorChoice(array('choices' => array(0, 1), 'required' => false)),
        'comments_html' => new sfValidatorChoice(array('choices' => array(0, 1), 'required' => false)),
//        'style_id' => new sfValidatorString(array('required' => false)),
//        'parent_user' => new sfValidatorString(array('required' => false)),
//        'ext_profile' => new sfValidatorString(array('required' => false)),
    ));


    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];

    $this->widgetSchema->moveField('password_again', 'after', 'password');
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
    
    
    $this->widgetSchema['profile_photo'] = new sfWidgetFormInputFileEditable(array(
                'label' => 'Profile Photo',
                'file_src' => $this->getDefault('profile_img'),
                'is_image' => true,
                'edit_mode' => true,
                'template' => '<fieldset class="edit_img"><span class="imgmask100">%file%</span><fieldset class="upload_btn">%input%</fieldset><fieldset class="delete_btn">%delete_label% %delete%</fieldset></fieldset>',
    ));

    $this->validatorSchema['profile_photo'] = new sfValidatorFile(array(
                'required' => false,
                'path' => sfConfig::get('sf_upload_dir').'/tmp',
                'mime_types' => 'web_images',
    ));
    $this->validatorSchema['profile_photo_delete'] = new sfValidatorPass();
    

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  /**
   * Save User data
   * 
   * @return type 
   */
  public function save() {
    if (!$this->isValid()) {
      throw $this->getErrorSchema();
    }
    
    $rpc = $this->getOnesite()->getRpc();
    $rest = $this->getOnesite()->getRest();
    $values = $this->values;
    
    if (!empty($values['birth']) && ($birth = strtotime($values['birth']))) {
      $values['birth_year'] = date('Y', $birth);
      $values['birth_month'] = date('m', $birth);
      $values['birth_day'] = date('d', $birth);
      unset($values['birth']);
    }
    
    if (!empty($values['user_id']) && !empty($values['email'])) 
      $values['username'] = $values['email'];
    
    if (empty($values['first_name']) && !empty($values['firstname'])) 
      $values['first_name'] = $values['firstname'];
    
    if (empty($values['last_name']) && !empty($values['lastname'])) 
      $values['last_name'] = $values['lastname'];
    
    unset($values['password_again']);
    
    if (!empty($values['profile_photo'])) {
      $profile_photo = $values['profile_photo'];
      unset($values['profile_photo']);
      
      $profile_photo->save();
      
      $photo_url = str_replace(sfConfig::get('sf_web_dir'), UrlToolkit::getDomainUri(), $profile_photo->getSavedName());
      
      $response = $rest->setProfilePhoto($values['user_id'], 'user', $photo_url);
      sfContext::getInstance()->getUser()->setAttribute('clear_user_cache', true);
    }
    
    $response = $rpc->userUpdate($values);
    
    if ($response['response']) {
      sfContext::getInstance()->getUser()->setAttribute('clear_user_cache', true);
      
      $user = UserTable::getInstance()->retrieveUser(array(
          'onesite_id' => $values['user_id']
      ));
      
      if (!$user) {
        $user = new User();
      }
      
      $user->fromOnesiteArray($values); //auto saves on change

      return $user;
    } else {
      return false;
    }
  }
}
