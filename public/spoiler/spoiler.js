$(function() {
    // Hide Spoiler by default
    $('div.spoiler-title').children().first().attr('class', 'spoiler-toggle show-icon');

	$('div.spoiler-title').click(function() {
		$(this)
			.children()
            .first()
			.toggleClass('show-icon')
			.toggleClass('hide-icon');
		$(this)
			.parent().children().last().toggle();
	});
});