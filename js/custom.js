jQuery(document).ready(function () {
	jQuery("#block-menu-menu-iseek3-main-menu > ul.nav > li.leaf:nth-child(6) > a").click(function (e) {
		e.preventDefault();
                e.stopPropagation();
		jQuery('#toolkit-anchor').ScrollTo({
    			duration: 2000,
    			easing: 'linear'
		});
	});
});
