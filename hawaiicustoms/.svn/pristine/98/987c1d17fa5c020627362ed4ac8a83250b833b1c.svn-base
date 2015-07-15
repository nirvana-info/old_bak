<?php
/**
 * Logo Configuration File
 *
 * This is a PHP file that sets up variables specific for a template.
 * It can also be used to run PHP code for a template.
 *
 */

class Automotive_logo extends LogoMaker
{
	/**
	 * TextFieldCount
	 * If a logo uses a by-line or similar, this can come in handy
	*/
	var $TextFieldCount = 2;

	/**
	 * Name of the recommended template to use this logo for.
	*/
	var $FileType = 'png';

	function __construct()
	{
		parent::__construct();
		$this->Text[0] = 'Performance';
		$this->Text[1] = 'Parts';
	}

	function GenerateLogo()
	{
		$this->NewLogo($this->FileType); // defaults to png. can use jpg or gif as well

		$this->FontPath = dirname(__FILE__) . '/fonts/';
		$this->ImagePath = dirname(__FILE__) . '/';
		$logo_image = 'back.png';
		$this->SetBackgroundImage($logo_image, LOGOMAKER_REPEAT_X);

		list($img_width, $img_height, $img_type, $img_attr) = getimagesize($this->ImagePath . $logo_image);

		// we need the height of the text box to position the image and then caculate the text position
		$t_box = $this->TextBox($this->Text[0], 'ITCEdscr.ttf', 'FFFFFF', 45, 0, 0);

		// determine the y position for the text
		$y_pos = 8+(($img_height - $t_box['height'])/2);

		if(strlen($this->Text[0]) > 0) {
			// AddText() - text, font, fontcolor, fontSize (pt), x, y, center on this width
			$text_position = $this->AddText($this->Text[0], 'ITCEdscr.ttf', 'FFFFFF', 45, 20, $y_pos);
		}

		if(strlen($this->Text[1]) > 0) {
			// put in our second bit of text
			$text_position2 = $this->AddText($this->Text[1], 'ITCEdscr.ttf', 'e02b01', 45, $text_position['top_right_x']+20, $y_pos);
			$top_right = $text_position2['top_right_x'];
		}
		else {
			$top_right = $img_width;
		}
		$this->SetImageSize($top_right+20, 90);

		return $this->MakeLogo();
	}
}
?>