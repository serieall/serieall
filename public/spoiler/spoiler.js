$(function() {
    // Hide Spoiler by default
	var spoilerTitle = 'div.spoiler-title';

    $(spoilerTitle).children.attr('class', 'spoiler-toggle show-icon');

	$(spoilerTitle).click(function() {
		$(this)
			.children
            .first()
			.toggleClass('show-icon')
			.toggleClass('hide-icon');
		$(this)
			.parent().children().last().toggle();
	});
});