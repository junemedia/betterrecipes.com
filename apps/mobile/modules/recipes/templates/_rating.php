<? /* <p class="rate-bar">Rating: <span class="rating"><span style="width:<?= $rating * 100 / 5 ?>%" ></span></span></p> */ ?>
<div class="rate-bar the-rating">
	<p>Rating: </p>
  <ul class="hornav stars<?= round($rating); ?>">
    <li><a class="one">1 star</a></li>
    <li><a class="two">2 stars</a></li>
    <li><a class="three">3 stars</a></li>
    <li><a class="four">4 stars</a></li>
    <li><a class="five">5 stars</a></li>
  </ul>
</div>
<div class="rate-bar">
<? include_partial('user_rating', compact('user_rating')) ?>
</div>