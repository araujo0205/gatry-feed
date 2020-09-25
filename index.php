<?php

// Assuming you installed from Composer:
require 'vendor/autoload.php';
use PHPHtmlParser\Dom;

$dom = new Dom;

echo '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
  >
  <channel>
        <title>Gatry</title>
        <link>"https://gatry.com"</link>
        <description>Promocoes</description>
        <language>pt-BR</language>
    <generator>"Code in Ruby"</generator>';

    foreach (range(0, 27, 9) as $qtde) {
        $dom->loadFromUrl("https://gatry.com/home/mais_promocoes?qtde=$qtde&onlyPromocao=true");

        foreach ($dom->find('article.promocao') as $item) {
            $id          = $item->getAttribute('id');
            $post        = $item->find('.informacoes a')[0];
            $preco       = $item->find('.informacoes span[itemprop=price]')[0]->innerHtml;
            $data_criado = $item->find('.informacoes span.data_postado')[0]->getAttribute('title');
            $comentario  = '';
            if ($item->find('.informacoes p.preco.comentario')[0]) {
                $comentario  = $item->find('.informacoes p.preco.comentario')[0]->innerhtml;
            }

            echo "<item>\n";
            echo '  <title>' . $post->innerHtml . ' [R$ ' . $preco . ']</title>';
            echo '  <link>' . $post->getAttribute('href') . '</link>';
            echo '  <pubDate>' . $data_criado . '</pubDate>';
            echo ' <description>' . $comentario . '</description>';
            echo "  <guid isPermaLink='false'>" . $id . '</guid>';
            echo "</item>\n";
        }
    }

echo '</channel>
    </rss>';
