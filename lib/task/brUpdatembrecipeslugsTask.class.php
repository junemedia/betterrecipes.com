<?php

class brUpdatembrecipeslugsTask extends sfBaseTask
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
    ;
    $this->briefDescription = 'Changes mixingbowl slugs from legacy ids to actual slugs';
    $this->detailedDescription = <<<EOF
The [br:update-mb-recipe-slugs|INFO] Changes mixingbowl slugs from legacy ids to actual slugs.
Call it with:

  [php symfony br:update-mb-recipe-slugs|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $block_size = 100;
    $recipes = new sfDoctrinePager('Recipe', $block_size);
    $recipes->setQuery(Doctrine_Core::getTable('Recipe')->createQuery('r')->where('r.source = ?', 'mb')->orderBy('r.sponsor_id DESC, r.created_at ASC'));
    $recipes->setPage(1);
    $recipes->init();
    echo "total number of batches:" . $recipes->getLastPage() . "\n";
    for ($i = 1; $i <= $recipes->getLastPage(); $i++) {
      $start = time();
      $recipes->setPage($i);
      $recipes->init();
      foreach ($recipes as $j => $recipe) {
        $recipe->updateSlugFromName();
        $recipe->free();
        unset($recipe);
        echo "|";
      }
      echo "\n";
      echo $i . " is completed in " . (time() - $start) . " seconds\n";
    }
  }

}