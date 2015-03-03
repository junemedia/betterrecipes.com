<?php

class rankingsTask extends sfBaseTask
{

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
    $this->name = 'rankings';
    $this->briefDescription = 'Updates nightly contestant rankings & unofficial weekly winner';
    $this->detailedDescription = <<<EOF
The [rankings|INFO] updates nightly contestant rankings based on user votes. Also updates the unofficial winner for the current contest period and
prints out the final unofficial contest winner for the week if it is the last day of the contest.

Call it with:

  [php symfony br:rankings|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    //Initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    //Update rankings - should be done nightly
    $contests = ContestTable::getContestsToRank()->execute(); // Doctrine_Core::getTable('Contest')->createQuery('c')->execute();

    foreach ($contests as $c) {
      echo '----- Current Contest: ' . $c->getName() . " -----\n";
      echo "----- New Contestant Rankings -----\n\n";
      //Go through all users in each contest and update there ranking based on the vote_count
      $c->updatedUnofficialWinner(true);
    }
    date_default_timezone_set(timezone_name_from_abbr("EST"));
  }

}
