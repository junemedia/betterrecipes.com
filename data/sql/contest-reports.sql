select ct.recipe_id, r.`name`, r.created_at from contestant ct inner join recipe r on ct.recipe_id = r.id where ct.contest_id = 142  and r.created_at >= '2014-02-01 00:00:00' ORDER BY r.created_at ASC

select distinct ct.user_id, u.profile_id, u.created_at from contestant ct inner join user u on ct.user_id = u.id where ct.contest_id = 142 and u.created_at >= '2014-02-01 00:00:00' ORDER BY u.created_at ASC

-- please note, substitute the correct contest_id and created_at date so that the report is run on the current contest that is open.