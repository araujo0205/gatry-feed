#!/usr/bin/ruby -w 
# coding: utf-8
require 'rubygems'
require 'nokogiri'
require 'open-uri'

urlBase = 'https://gatry.com/home/mais_promocoes?qtde=0&onlyPromocao=true'

page = Nokogiri::HTML(open("#{urlBase}"))   


puts '<?xml version="1.0" encoding="UTF-8"?>
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

# Filtrar o ítem onde está o título e o link
page.css('article.promocao').each do |item|
  id = item['id']
  post = item.css('.informacoes a').first
  preco = item.css('.informacoes span[itemprop=priceCurrency]').first.content + " " + item.css('.informacoes span[itemprop=price]').first.content
  data_criado = item.css('.informacoes span.data_postado').first['title']
  comentario = item.css('.informacoes p.preco.comentario').first.content

  puts "<item>\n"
  puts "  <title>#{post.content} [#{preco}]</title>"
  puts "  <link>#{post['href']}</link>"
  puts "  <pubDate>#{data_criado}</pubDate>"
  puts " <description>#{comentario}</description>"
  puts "  <guid isPermaLink='false'>#{id}</guid>"
  puts "</item>\n"
end

puts "</channel>
</rss>"
