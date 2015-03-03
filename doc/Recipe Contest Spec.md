BetterRecipes: Recipe Contests
==============================

Contest Logic
-------------
1. Recipe contests are created by an admin, who selects a start date and end date for a recipe contest.  These dates are immutable for the contest.

2. Upon start/end date selection, the contest is broken down into weekly contests running week-to-week.

CURRENT:

3. These weekly contests run from start day of the contest to the same day of the next week. Ex) If the contest was started on a Sunday, 
each weekly contest would be Sunday to Sunday (technically ends on Saturday 23:59:59)

4. Admins can only select an end date with the same day as the start day.  Ex) If Sunday is chosen is the start day, the end date
can be any future Sunday

5. A contest can start at any time, but must span over at least one (1) week.

OPTION: 

3. These weekly contests run from Monday at 00:00:00 to Sunday 23:59:59.

4. A contest can span multiple Sundays.

5. Admins can only select a Sunday as the end date.  Contests must end on a Sunday at 23:59:59.

6. A contest can start at any time, but must span over at least one (1) Sunday.


Contestants
-----------

1. Contestants must be registered.

2. Contestants can enter many of their recipes to a single contest.  A contestant may NOT submit a single recipe to multiple contests running at the same time (with overlapping start/end dates).

3. Contestants may only enter into an active contest (once the contest has started).

4. Upon entering a contest, the contestant information is passed to DreamMail via their API.


Ranking
-------

1. CURRENT: Unofficial contest winners are updated every night for the current week for each contest. 
   OPTION:  Unofficial contest winners are selected every Sunday at 23:59:59.

2. CURRENT: Official contest winners must be selected by an admin for each contest every week after the end date. 
   (Based on starting day - Ex) If contest starts on a Sunday, each weekly Contest ends on Saturday at Midnight and an official winner should be chosen after that.                                                                                                                                          
   OPTION:  Official contest winners must be selected by an admin for each contest every week after Sunday at 23:59:59.

3. Admin should select editor choice winner for each contest every week after the end date. (same as official winners)

4. Admins can change the official winner for any past contests.

5. The rankings of recipes within a contests are updated every night at midnight.

6. There will be no admin function to "punish" a recipe.  This will be handled manually by an RD developer.

7. No vote counts will every be displayed on the front-end.

8. Votes will be logged with IP address and timestamp for disaster recovery / proof of vote purposes.

9. There is no overall contest winner for a contest that spans multiple weeks. (No Grand Prize Winner)


Voting
------

1. Any website visitor may vote on a recipe.

2. Visitors are limited to vote once daily on a single recipe in a contest.  They may vote for multiple recipes within a contest, but only once per recipe.  (Similar to PhotoFaves)

3. CURRENT:  ALL users must successfully complete a SolveMedia Captcha before casting every vote.
   OPTION:   Non-registered users must successfully complete a SolveMedia Captcha before casting every vote.

4. **CHANGED**: Registered users will NOT be presented with a captcha, since their identity is verified and persistent.
    **TO**: ALL users will be presented with a captcha, whether they are logged in or logged out.