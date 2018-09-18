<?php
/**
 * Modal template.
 */
?>
<script type="text/html" id="tmpl-profile">
	<article class="post">
		<header class="post-header">
			<div class="featured-image">
				<img src="{{ data.image }}" alt="{{ data.title }}" />
			</div>
			<div class="header-content">
				<h1 id="profile-title" class="entry-title">{{ data.title }}</h1>
				<em>{{ data.job_title }}</em>
			</div>
		</header>
		<div class="post-content" id="dialog-description">
			{{{ data.content }}}
		</div>

	</article>
	<# if ( data.next_article ) { #>
	<a class="next-link previous" href="{{data.next_article}}" data-id="{{data.next_id}}">
		<<span class="screen-reader-text">Next Article</span></a>
	<# } #>
	<# if ( data.previous_article ) { #>
	<a class="next-link next" href="{{data.previous_article}}" data-id="{{data.previous_id}}">
		><span class="screen-reader-text">Previous Article</span></a>
	<# } #>
</script>
