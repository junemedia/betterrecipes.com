#!/bin/bash
echo "starting"
mysqldump -uroot -p blogs > blogs.sql
#sed -e s/blogs.local/brblogs.local/g blogs.sql > blogs_stage.sql
#sed -e s/blogs.mydevstaging.com/brblogs.local/g blogs_stage.sql > blogs_stage2.sql
#sed -e s:/blogs/daily-dish/:/:g blogs_stage2.sql > blogs_stage3.sql
#sed -e s:brblogs.local//files:brblogs.local/wp-content/blogs.dir/27/files:g blogs.sql > blogs_stage1.sql
#sed -e s:www.betterrecipes.com/2012:www.betterrecipes.com/blogs/daily-dish/2012:g blogs.sql > blogs_stage1.sql
#sed -e s:www.betterrecipes.com/2013:www.betterrecipes.com/blogs/daily-dish/2013:g blogs_stage1.sql > blogs_stage2.sql
#sed -e s:www.betterrecipes.com/2014:www.betterrecipes.com/blogs/daily-dish/2014:g blogs_stage2.sql > blogs_stage3.sql
#sed -e s:www.betterrecipes.com/2010:www.betterrecipes.com/blogs/daily-dish/2010:g blogs_stage3.sql > blogs_stage4.sql
sed -e s:www.betterrecipes.com:www.betterrecipes.local:g blogs.sql > blogs_stage5.sql
mysqladmin -f -uroot -p  drop blogs;
mysqladmin -f -uroot -p  create blogs;
mysql -uroot -p blogs < blogs_stage5.sql
php fix_serialize_prod.php
echo "ending"
