<?php

class emailcontestantsTask extends sfBaseTask {

    protected function configure()
    {
        // // add your own arguments here
        // $this->addArguments(array(
        //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
        // ));

        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));

        $this->namespace = 'br';
        $this->name = 'email-contestants';
        $this->briefDescription = 'Emails all contestants that have not recieved an email so far from dreammail';
        $this->detailedDescription = <<<EOF
The [email-contestants|INFO] task does things.
Call it with:

  [php symfony br:email-contestants|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $urlParams = array('protocol' => 'http://', 'domain' => 'betterrecipes.com');
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

        //Email all contestants who have not recieved an email so far
        $clientname = sfConfig::get('app_dreammail_clientname', 'Meredith_BetterRecip');
        $sitename = sfConfig::get('app_dreammail_sitename', 'Meredith_BetterRecip');
        $campaign = sfConfig::get('app_dreammail_campaign', '11_PhotoFaves');
        $mailing_br = sfConfig::get('app_dreammail_mailing', 'BR_Photos_11');
        $mailing_kellogs = sfConfig::get('app_dreammail_mailing_kellogs', 'BR_Photos_11_Kelloggs');
        $dmurl = sfConfig::get('app_dreammail_dmurl', 'http://rtm.na.epidm.net/weblet/weblet.dll');
        $servername = sfConfig::get('app_dreammail_servername', 'dm17');
        $username = sfConfig::get('app_dreammail_username', 'bsanders');
        $password = sfConfig::get('app_dreammail_password', 'AppL3TReE7645');

        //Get all contestants who have not had an email attempt sent to them yet
        $contestants = Doctrine_Core::getTable('Contestant')->createQuery('ct')->where('ct.email_status = 0')->execute();
        //IF PARAM FOR ERRORS IS SET - CURRENTLY OVERRIDE
        $contestants = Doctrine_Core::getTable('Contestant')->createQuery('ct')->where('ct.email_status = 0 OR ct.email_status = 2')->execute();


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $mailing_http_headers[] = 'ServerName: ' . $servername;
        $mailing_http_headers[] = 'UserName: ' . $username;
        $mailing_http_headers[] = 'Password: ' . $password;
        $mailing_http_headers[] = 'Expect:'; //Fix for error 417 Expectation Failed (occurs when sending $url & $imageURL)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $mailing_http_headers);

        foreach ($contestants as $c)
        {
            $email = $c->getUser()->getEmail();
            $url = (string) $urlParams['protocol'] . $c->getRecipe()->getFirstCategory()->getParent()->getSlug() . '.' . $urlParams['domain'] . '/' . $c->getRecipe()->getSlug() . '.html';
            if ($c->getRecipe()->hasPhoto())
            {
                $imageURL = (string) $urlParams['protocol'] . $urlParams['domain'] . '/uploads/photo' . $c->getRecipe()->getMainImage()->getImgSrc();
            } else
            {
                $imageURL = "";
            }
            //Determine which mailing variable to use (sponsored or non-sponsored)
            if ($c->getContest()->getSponsorId() == 1)
                $mailing = $mailing_kellogs;
            else 
                $mailing = $mailing_br;

            $xml = sprintf('<RTMWeblet xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://rtm.na.epidm.net/weblet/RTMWebletReq.xsd">
	              <RTMEmailToEmailAddress>
	                <ClientName>%s</ClientName>
	                <SiteName>%s</SiteName>
	                <CampaignName>%s</CampaignName>
	                <MailingName>%s</MailingName>
	                <ToEmailAddress>
					  <EventEmailAddress>
					  	<EmailAddress>%s</EmailAddress>
						<EventVariables>
					      <Variable>
						    <Name>ImageURL</Name>
							<Value>%s</Value>
						  </Variable>
						  <Variable>
						    <Name>URL</Name>
							<Value>%s</Value>
					      </Variable>
						</EventVariables >
					  </EventEmailAddress>
					</ToEmailAddress>
	              </RTMEmailToEmailAddress>
	            </RTMWeblet>'
                    , $clientname
                    , $sitename
                    , $campaign
                    , $mailing
                    , $email
                    , $imageURL
                    , $url
            );

            curl_setopt($ch, CURLOPT_URL, $dmurl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            $response = curl_exec($ch);
            $responseXml = @simplexml_load_string($response);
            if ($responseXml->Code == '1')
            {
                $c->setEmailStatus(1);
                $c->save();
                echo 'Email sent to: ' . $email . PHP_EOL;
            } else
            {
                $c->setEmailStatus(2);
                $c->save();
                echo 'Email failed to send to: ' . $email . PHP_EOL;
            }
            //echo $response.PHP_EOL;
        }
    }

}
