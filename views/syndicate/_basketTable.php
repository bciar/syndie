<div class="basketTable">
<div class="headerRow">
<div class="cell topLeft">Game</div>
<div class="cell">Syndie Name</div>
<div class="cell">Creator</div>
<div class="cell">Draw Date</div>
<div class="cell">Est. Jackpot</div>
<div class="cell">Cost per Share</div>
<div class="cell">Lines per Share</div>
<div class="cell">No. of Shares</div>
<div class="cell">Subtotal</div>
<?php

if (!isset($hideActions)) { $hideActions = 0; }

if ($hideActions == 0)  {
	echo '<div style="width: 120px" class="cell topRight">Actions</div>';
}

?>
</div>

