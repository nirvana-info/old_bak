<?php

	CLASS ISC_PRODUCTARTICLE_PANEL extends PANEL
	{
		function SetPanelSettings()
		{
			if(!isset($GLOBALS['ISC_CLASS_PRODUCT'])) {
				$this->DontDisplay = true;
				return;
			}

			$article = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductArticle();
			if(strpos($article, "<") === false) {
				$article = nl2br($article);
			}
			$article_file = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductArtFile();
			if ($article_file != "")
			{

$pos2 = stripos($article_file, "http://");

if ($pos2 === false) {
     $article_file = "article_file/".$article_file;
} 

			$GLOBALS['ArticleFile'] = '<a href="'.$article_file.'" target="_blank">Read Article File</a>';
			}
			else
			{
$GLOBALS['HidePanels'][] = 'ProductArticle';

			}

			$GLOBALS['ProductArticle'] = $article;
			

if ( $article == "" and $article_file == "")
			{
				$this->DontDisplay = true;

			}

		}
	}

?>