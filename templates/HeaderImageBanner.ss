<% if $showHibImages %>
	<style>.nivoSlider { width:{$hibGetWidth}px; height:{$hibGetHeight}px; }</style>
	<div class="slider-wrapper theme-default"><ul id="slider" class="nivoSlider"><% loop $showHibImages(5) %><li><img src="$hibCroppedImage.URL" alt="Photo credit: $hibCroppedImage.Title" title="Photo credit: $hibCroppedImage.Title" /></li><% end_loop %>
	<% if $singleHibImage %><% loop $showHibImages(1) %><div class="nivo-caption" style="opacity: 0.8;"><p>Photo credit: $hibCroppedImage.Title</p></div><% end_loop %><% end_if %>
	</ul></div>
	<% if $singleHibImage %><% else %>$startSlider<% end_if %>
<% end_if %>
