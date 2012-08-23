<?php

class getvoteTask extends sfBaseTask {

  protected function configure() {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
        new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
        new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
        new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
        new sfCommandOption('num-contestants', null, sfCommandOption::PARAMETER_REQUIRED, 'The number of contestants', 0),
            // add your own options here
    ));

    $this->namespace = 'br';
    $this->name = 'get-vote';
    $this->briefDescription = 'Retrieves the vote count for all contestants from the currently active contests';
    $this->detailedDescription = <<<EOF
The [get-vote|INFO] task retrieves the vote count for all contestants ordered by rank for all currently active contests.
  Use param num-contestants to specify the number of contestants to retrieve. Default is 0 -> all contestants
  
Call it with:
  [php symfony br:get-vote|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    ///Update rankings - should be done nightly
    $contests = ContestTable::getActiveContests()->execute();

    foreach ($contests as $c) {
      echo '----- Contest: '.$c->getName()." -----\n\n";
      $this->log(str_pad('Rank', 5).str_pad('Recipe', 60).str_pad('User Display Name', 24).str_pad('Vote Count', 6));
      //Get the top 10 contestants
      $q = Doctrine_Core::getTable('Contestant')->createQuery('ct')->where('ct.contest_id = ?', $c->getId())->orderBy('ct.rank ASC');
      if (is_int((int)$options['num-contestants']) && count((int)$options['num-contestants']) > 0) {
        $q->limit((int)$options['num-contestants']);
      }
      $contestants = $q->execute();
      foreach ($contestants as $i => $ct) {
        $this->log(str_pad($ct->getRank().'.', 5).str_pad($ct->getRecipe()->getName(), 60).str_pad($ct->getUser()->getDisplayName(), 24).str_pad($ct->getVoteCount(), 6));
      }
      echo "\n";
    }
    echo "\n";
  }

}

