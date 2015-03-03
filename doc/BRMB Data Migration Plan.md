BetterRecipes / MixingBowl Site Migration Timeline
==================================================

Prior to 7/25
-------------

Meredith provide Excel sheet for Mixing Bowl recipe categories.

7/25
----

**00:01** Meredith shuts down (disables) addition of new content for betterrecipes.com and mixingbowl.com.

**16:00** Meredith provides (via ftp.resolute.com) RD with database dumps for betterrecipes.com (Oracle) and mixingbowl.com (MSSQL).

7/26
----

**17:00** RD provides OneSite (via ftp.resolute.com) with converted MySQL dumps.

7/27
----

**08:00** OneSite de-conflicts users and populates Meredith Registration Services profile ids for each mixingbowl.com user.

**09:00** Meredith changes DNS TTL for betterrecipes.com, *.betterrecipes.com, mixingbowl.com and www.mixingbowl.com to 1800 seconds (30 minutes).

**23:00** RD finishes download (incremental) of recipe images from betterrecipes.com and mixingbowl.com and updates image URLs in DB to pull from RD's servers.

**23:00** OneSite finishes download (incremental) of remaining mixingbowl.com group images and user avatars.

7/28
----

**23:00** DNS for betterrecipes.com, *.betterrecipes.com, mixingbowl.com, www.mixingbowl.com are pointed to 69.10.59.146.
  > For mixingbowl.com and ALL of the subdomains of betterrecipes.com, including betterrecipes.com please use the following zone records:

        betterrecipes.com.    A       69.10.59.147
        *.betterrecipes.com.  CNAME   betterrecipes.com.
        mixingbowl.com.       A       69.10.59.147
        www.mixingbowl.com.   CNAME   mixingbowl.com.

**23:59** Site migration complete.


