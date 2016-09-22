#!/bin/bash
#rsync -avzh --delete root@10.223.241.107:/srv/incoming/betterrecipes/ /srv/incoming/betterrecipes/ #web1->web2
rsync -avzh --delete root@10.223.241.112:/srv/incoming/betterrecipes/ /srv/incoming/betterrecipes/ #web2->web1


#sudo rsync -rltvcO --exclude=cache --exclude=log --exclude="._*" jshearer@10.223.241.107:/srv/sites/betterrecipes/ /srv/sites/betterrecipes/
