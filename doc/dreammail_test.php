<?

// Larry, put these in the project's (not frontend/config) app.yml:
$servername = 'dm17';
$clientname = 'Meredith_BetterRecip';
$username = 'bsanders';
$password = 'AppL3TReE7645';
$sitename = 'Meredith_BetterRecip';
$campaign = '11_PhotoFaves';
$mailing = 'BR_Photos_11';
$dmurl = 'http://rtm.na.epidm.net/weblet/weblet.dll';


$xml = sprintf('<RTMWeblet xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://rtm.na.epidm.net/weblet/RTMWebletReq.xsd">
  <RTMEmailToEmailAddress>
    <ClientName>%s</ClientName>
    <SiteName>%s</SiteName>
    <CampaignName>%s</CampaignName>
    <MailingName>%s</MailingName>
    <ToEmailAddress>
      <EventEmailAddress>
        <EmailAddress>%s</EmailAddress>
      </EventEmailAddress>
    </ToEmailAddress>
  </RTMEmailToEmailAddress>
</RTMWeblet>
'
,$clientname
,$sitename
,$campaign
,$mailing
,'adam@chal.net'
);



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $dmurl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
$mailing_http_headers[] = 'ServerName: '.$servername;
$mailing_http_headers[] = 'UserName: '.$username;
$mailing_http_headers[] = 'Password: '.$password;
curl_setopt($ch, CURLOPT_HTTPHEADER, $mailing_http_headers);

$response = curl_exec($ch);

echo $response.PHP_EOL;

