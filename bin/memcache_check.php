#!/usr/bin/php
<?
	$count = 0;
	$keycheck1CurrentValue = FALSE;
	$keycheck1NewValue = FALSE;
	$keycheck1Output = '';
	$keycheck2CurrentValue = FALSE;
	$keycheck2NewValue = FALSE;
	$keycheck2Output = '';
	$keycheck3CurrentValue = FALSE;
	$keycheck3NewValue = FALSE;
	$keycheck3Output = '';
	$keycheck4CurrentValue = FALSE;
	$keycheck4NewValue = FALSE;
	$keycheck4Output = '';
	while( $count < 200000 ) //runs for more then 2 days
	{
		$memcache = new Memcache();
		$memcache->connect('mmc', 11211);
		$keycheck1 = $memcache->get('br_pop_blogs_b74efe11df62be2b49fa8e71be22b19c');
		$keycheck2 = $memcache->get('br_pop_blogs_2dccd1ab3e03990aea77359831c85ca2');
		$keycheck3 = $memcache->get('br_pop_blogs_154f020f4c00a706fdcbdfd49bee9a36');
		$keycheck4 = $memcache->get('br_pop_recipes_b74efe11df62be2b49fa8e71be22b19c'); // Just for curious/Sanity reasons!!!!

		//key 1
		if( !empty($keycheck1) )
		{
			$keycheck1NewValue = TRUE;
			$keycheck1Output =  ' Key br_pop_blogs_b74efe11df62be2b49fa8e71be22b19c has a value now!';
		}else
		{
			$keycheck1NewValue = FALSE;
			$keycheck1Output =  ' Key br_pop_blogs_b74efe11df62be2b49fa8e71be22b19c does NOT have a value now!';
		}

		if( $keycheck1NewValue != $keycheck1CurrentValue )
		{
			echo 'At ' . date('D H:i:s') . $keycheck1Output . PHP_EOL;
		}
		$keycheck1CurrentValue = $keycheck1NewValue;

		//key 2
		if( !empty($keycheck2) )
		{
			$keycheck2NewValue = TRUE;
			$keycheck2Output =  ' Key br_pop_blogs_2dccd1ab3e03990aea77359831c85ca2 has a value now!';
		}else
		{
			$keycheck2NewValue = FALSE;
			$keycheck2Output =  ' Key br_pop_blogs_2dccd1ab3e03990aea77359831c85ca2 does NOT have a value now!';
		}

		if( $keycheck2NewValue != $keycheck2CurrentValue )
		{
			echo 'At ' . date('D H:i:s') . $keycheck2Output . PHP_EOL;
		}
		$keycheck2CurrentValue = $keycheck2NewValue;

		// key 3
		if( !empty($keycheck3) )
		{
			$keycheck3NewValue = TRUE;
			$keycheck3Output =  ' Key br_pop_blogs_154f020f4c00a706fdcbdfd49bee9a36 has a value now!';
		}else
		{
			$keycheck3NewValue = FALSE;
			$keycheck3Output =  ' Key br_pop_blogs_154f020f4c00a706fdcbdfd49bee9a36 does NOT have a value now!';
		}

		if( $keycheck3NewValue != $keycheck3CurrentValue )
		{
			echo 'At ' . date('D H:i:s') . $keycheck3Output . PHP_EOL;
		}
		$keycheck3CurrentValue = $keycheck3NewValue;

		//key 4
		if( !empty($keycheck4) )
		{
			$keycheck4NewValue = TRUE;
			$keycheck4Output =  ' Key br_pop_recipes_b74efe11df62be2b49fa8e71be22b19c has a value now!';
		}else
		{
			$keycheck4NewValue = FALSE;
			$keycheck4Output =  ' Key br_pop_recipes_b74efe11df62be2b49fa8e71be22b19c does NOT have a value now!';
		}

		if( $keycheck4NewValue != $keycheck4CurrentValue )
		{
			echo 'At ' . date('D H:i:s') . $keycheck4Output . PHP_EOL;
		}
		$keycheck4CurrentValue = $keycheck4NewValue;

		$memcache->close();
		sleep( 10 );
		$count++;
	}
?>