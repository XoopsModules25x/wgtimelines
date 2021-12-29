<small>
	<{if $item.rating.voted|default:false == 0}>
		<div class="timelines_ratingblock">
			<div id="unit_long<{$item.id}>">
				<div id="unit_ul<{$item.id}>" class="timelines_unit-rating">
					<div class="wgtimelines_current-rating" style="width:<{$item.rating.size}>;"><{$item.rating.text}></div>
					<div>
						<a class="timelines_r1-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=1&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING1}>" rel="nofollow">1</a>
					</div>
					<div>
						<a class="timelines_r2-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=2&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING2}>" rel="nofollow">2</a>
					</div>
					<div>
						<a class="timelines_r3-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=3&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING3}>" rel="nofollow">3</a>
					</div>
					<div>
						<a class="timelines_r4-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=4&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING4}>" rel="nofollow">4</a>
					</div>
					<div>
						<a class="timelines_r5-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=5&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING5}>" rel="nofollow">5</a>
					</div>
				</div>
				<div>
					<{$item.rating.text}>
				</div>
			</div>
		</div>
	<{else}>
		<div class="timelines_ratingblock">
			<div id="unit_long<{$item.id}>">
				<div id="unit_ul<{$item.id}>" class="timelines_unit-rating" style="width:<{$item.rating.maxsize}>;">
					<div class="wgtimelines_current-rating" style="width:<{$item.rating.size}>;"><{$item.rating.text}></div>
				</div>
				<div class="wgtimelines_voted">
					<{$item.rating.text}>
				</div>
			</div>
		</div>
	<{/if}>
</small>