<? if (isset($user_rating) && $user_rating): ?>
  <p>Your Rating: </p>
  <ul class="hornav stars<?= round(is_object($user_rating) ? $user_rating->getRating() : $user_rating); ?>">
    <li><a class="one">1 star</a></li>
    <li><a class="two">2 stars</a></li>
    <li><a class="three">3 stars</a></li>
    <li><a class="four">4 stars</a></li>
    <li><a class="five">5 stars</a></li>
  </ul>
<? else: ?>
  <p>Rate: </p>
  <ul class="hornav">
    <li><a class="one" onclick="rate(1)" title="Rate this 1 star">Rate this 1 star</a></li>
    <li><a class="two" onclick="rate(2)" title="Rate this 2 stars">Rate this 2 stars</a></li>
    <li><a class="three" onclick="rate(3)" title="Rate this 3 stars">Rate this 3 stars</a></li>
    <li><a class="four" onclick="rate(4)" title="Rate this 4 stars">Rate this 4 stars</a></li>
    <li><a class="five" onclick="rate(5)" title="Rate this 5 stars">Rate this 5 stars</a></li>
  </ul>
<? endif; ?>