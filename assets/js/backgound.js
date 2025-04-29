/******************************************************************

 ******************************************************************


	------------------------
	-- TABLE OF CONTENTS --
	------------------------
	
	--  1. Init Background
	--  2. Square Background
 
 ******************************************************************/


/** 1. BACKGROUND INIT
*******************************************************************/

function init_backgrounds() {

	var error_msg = "Error! No background is set or something went wrong";

	if (is_mobile_device == true && option_hero_background_mode_mobile != "match") {
		option_hero_background_mode = option_hero_background_mode_mobile;
	}

	function url_var_handling() {
		let searchParams = new URLSearchParams(window.location.search);
		if (searchParams.has('bg')) option_hero_background_mode = searchParams.get('bg');
	} url_var_handling();

	switch (option_hero_background_mode) {

		case "color": colorBackground(); break;
		case "square": squareBackground(); break;
		case "twisted": twistedBackground(); break;
		case "asteroids": asteroidsBackground(); break;
		case "circle": circleBackground(); break;
		case "lines": linesBackground(); break;
		default: alert(error_msg); console.log(error_msg); break;

	}

} init_backgrounds();



/** 2. SQUARE BACKGROUND
*******************************************************************/

function squareBackground() {
	$("body").append('<div class="bg-color" style="background-color:' + option_hero_background_square_bg + '"></div>');

	const container = $('<div class="svg-bubbles"></div>');

	const shapeTypes = ['rect', 'circle', 'triangle'];

	for (let i = 0; i < 10; i++) {
		const size = 20 + Math.floor(Math.random() * 80);
		const left = Math.floor(Math.random() * 100);
		const delay = Math.floor(Math.random() * 15);
		const duration = 20 + Math.floor(Math.random() * 20);
		const opacity = 0.02 + Math.random() * 0.08;

		const type = shapeTypes[Math.floor(Math.random() * shapeTypes.length)];

		let shape;

		switch (type) {
			case 'circle':
				shape = `<circle cx="50" cy="50" r="40" />`;
				break;
			case 'triangle':
				shape = `<polygon points="50,15 90,85 10,85" />`;
				break;
			default:
				shape = `<rect width="100" height="100" rx="12" />`;
		}

		const svg = $(`
		<svg class="bubble" style="
		  width:${size}px;
		  height:${size}px;
		  left:${left}%;
		  animation-delay:${delay}s;
		  animation-duration:${duration}s;
		  opacity:${opacity};
		" viewBox="0 0 100 100">
		  ${shape}
		</svg>
	  `);

		// Add click-to-bounce interaction
		svg.on("click", function () {
			$(this).addClass("bounce");
			setTimeout(() => $(this).removeClass("bounce"), 300);
		});

		container.append(svg);
	}

	$("#main").append(container);
}

