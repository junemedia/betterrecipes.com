<?php

class fixvoteTask extends sfBaseTask {

  protected function configure() {

    $this->addArguments(array(
        //new sfCommandArgument('ipaddress', sfCommandArgument::OPTIONAL, 'Enter an ip address to make the votes inactive from', ''),
        //new sfCommandArgument('userid', sfCommandArgument::OPTIONAL, 'Enter a user id to make the votes inactive from', ''),
            // add your own arguments here
    ));

    $this->addOptions(array(
        new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
        new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
        new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
        new sfCommandOption('ipaddress', null, sfCommandOption::PARAMETER_OPTIONAL, 'Enter an ip address to make the votes inactive from', ''),
        new sfCommandOption('userid', null, sfCommandOption::PARAMETER_OPTIONAL, 'Enter a user id to make the votes inactive from', ''),
            // add your own options here
    ));
    //param for ip adress
    //param for user_id
    $this->namespace = 'br';
    $this->name = 'fix-vote';
    $this->briefDescription = 'Fixes vote - reranks contestants based on vote count';
    $this->detailedDescription = <<<EOF
The [fix-vote|INFO] task will rerank the contestants based on the number of votes in the vote table that are active and adjust the vote counts 
  for each contestant accordingly.
Call it with:

  [php symfony br:fix-vote|INFO]

Parameters
 ipaddress - enter ip address (ex: 10.10.10.1010) to make all votes from that ip address inactive
 userid - enter user-id to make all votes created from that user_id inactive
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    //Fix Vote Table
    //Check for ip address and change all matching votes' is_active field to 0
    if (isset($options['ipaddress']) && $options['ipaddress'] != '') {
      $IPAddress = ip2long($options['ipaddress']);
      $votes = Doctrine_Core::getTable('Vote')->createQuery('v')->where('v.ip_address = ?', $IPAddress)->execute();
      foreach ($votes as $v) {
        $v->setIsActive(0);
        $v->save();
      }
      echo count($votes)." votes changed based on IP Address\n\n";
    }
    //Check for user id and change all matching votes' is_active field to 0
    if (isset($options['userid']) && $options['userid'] != '') {
      $votes = Doctrine_Core::getTable('Vote')->createQuery('v')->where('v.user_id = ?', $options['userid'])->execute();
      foreach ($votes as $v) {
        $v->setIsActive(0);
        $v->save();
      }
      echo count($votes)." votes changed based on User ID\n\n";
    }
    //Fix vote count based on active votes in vote table
    $contestants = Doctrine_Core::getTable('Contestant')->createQuery('ct')->execute();
    foreach ($contestants as $c){
      $votes = Doctrine_Core::getTable('Vote')->createQuery('v')->where('v.contestant_id = ?', $c->getId())->andWhere('v.is_active = 1')->execute();
      $c->setVoteCount(count($votes));
      $c->save();
    }
    //Update rankings - should be done nightly
    $contests = ContestTable::getContestsToRank()->execute(); // Doctrine_Core::getTable('Contest')->createQuery('c')->execute();
    foreach ($contests as $c) {
      echo '----- Current Contest: '.$c->getName()." -----\n";
      echo "----- New Contestant Rankings -----\n\n";
      //Go through all users in each contest and update there ranking based on the vote_count
      $contestants = Doctrine_Core::getTable('Contestant')->createQuery('ct')->where('ct.contest_id = ?', $c->getId())->orderBy('ct.vote_count DESC')->execute();
      foreach ($contestants as $i => $ct) {
        $i++; //offset index
        $oldRank = $ct->getRank();
        $ct->setRank($i);
        $ct->save();
        echo $i.'. '.$ct->getRecipe()->getName().' by '.$ct->getUser()->getDisplayName().' - Previous Rank: #'.$oldRank;
        echo "\n";
      }
      echo "\n";
    }
  }

}