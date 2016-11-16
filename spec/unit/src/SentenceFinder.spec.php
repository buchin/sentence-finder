<?php
use Buchin\SentenceFinder\SentenceFinder;

describe('SentenceFinder', function(){
	given('sf', function(){
		return new SentenceFinder;
	});

	given('word', function(){
		return 'makan';
	});

	given('rss', function(){
		return '<?xml version="1.0" encoding="utf-8" ?><rss version="2.0"><channel><title>Bing: inbody:makan</title><link>http://www.bing.com:80/search?q=inbody%3amakan</link><description>Search results</description><image><url>http://www.bing.com:80/s/a/rsslogo.gif</url><title>inbody:makan</title><link>http://www.bing.com:80/search?q=inbody%3amakan</link></image><copyright>Copyright © 2016 Microsoft. All rights reserved. These XML results may not be used, reproduced or transmitted in any manner or for any purpose other than rendering Bing results within an RSS aggregator for your personal, non-commercial use. Any other use of these results requires express written permission from Microsoft Corporation. By accessing this web page or using these results in any manner whatsoever, you agree to be bound by the foregoing restrictions.</copyright><item><title>Groupon -11.11 Flash Sale Cashback 100% di ShopBack</title><link>http://groupon.co.id/</link><description>Deal diskon makan, minum, hotel, spa, salon, produk kecantikan, fotografi, liburan, serta banyak lagi di Jakarta, Bandung, Surabaya, Bali, Medan dan seluruh Indonesia!</description><pubDate>Sat, 12 Nov 2016 02:32:00 GMT</pubDate></item><item><title>Berita Hari Ini - Berita Harian Terbaru Terkini dan Terpopuler</title><link>http://www.viva.co.id/</link><description>Dikira Makan Sapi, Isi Perut Piton Ini Bikin Merinding; Pesta Paling Amoral yang Pernah Terjadi dalam Sejarah; Sepuluh Tanda Utama Terjadinya Kiamat Menurut Islam;</description><pubDate>Sat, 12 Nov 2016 13:52:00 GMT</pubDate></item><item><title>KASKUS - Forum Diskusi Terbesar &amp; Jual Beli Paling Murah ...</title><link>http://www.kaskus.co.id/</link><description>Pecah Belah &amp; Alat Makan; Perlengkapan Kantor ; Stationery; Perlengkapan Anak &amp; Bayi ; Perlengkapan Anak-Anak ; Perlengkapan Bayi; Furniture ; Perkakas ; Properti ...</description><pubDate>Fri, 11 Nov 2016 22:43:00 GMT</pubDate></item><item><title>LAKUPON.com - Voucher Belanja Online Harga Promosi Diskon ...</title><link>https://lakupon.com/</link><description>Hanya dengan voucher promosi diskon di Lakupon, Anda bisa makan hemat setiap hari. Anda bisa pilih banyak voucher resto, caf ...</description><pubDate>Sat, 12 Nov 2016 00:09:00 GMT</pubDate></item><item><title>Permainan online gratis di Games.co.id</title><link>http://www.games.co.id/</link><description>Mobil Makan Mobil 2: Impian Gila. Kategori Populer. Game Olahraga. Game Basket. Bola billiard. Papan luncur. Olahraga Musim Dingin. Golf. Sepak Bola. Tinju. Semua ...</description><pubDate>Sat, 12 Nov 2016 06:07:00 GMT</pubDate></item><item><title>Bhinneka.Com: Toko Online Komputer, Gadget, Fotografi ...</title><link>http://www.bhinneka.com/</link><description>Toko Online No. 1 dan Terbesar di Indonesia dengan produk LENGKAP, Kualitas TERJAMIN, Harga MURAH, CICILAN 0%, dan GRATIS Pengiriman</description><pubDate>Sat, 12 Nov 2016 05:09:00 GMT</pubDate></item><item><title>Otosia.com: Berita, Foto, Fakta Unik Otomotif Terlengkap ...</title><link>http://www.otosia.com/</link><description>Peugeot Makan Honda CBR. Tertabrak yang Jatuhnya Keren. Bus Amfibi, Melaju di Dua Alam. Efek Kurang Skil Berkendara. Tips Trik.</description><pubDate>Fri, 11 Nov 2016 17:42:00 GMT</pubDate></item><item><title>Sarinah - Official Site</title><link>http://www.sarinah.co.id/</link><description>Sarinah will host an event to celebrate the company’s redesigned Makan Nakam food court at its Malang location from 7th until 8th October 2016.</description><pubDate>Fri, 11 Nov 2016 15:19:00 GMT</pubDate></item><item><title>Vidio.com - Situs Berbagi Video</title><link>https://www.vidio.com/</link><description>Tips Makan Es Krim; Yakin sudah mencharge hape dengan benar; Lihat semua isi koleksi (15 vidio) Starlite 3. by Liputan6.com. Pesona Artis Cantik Turki yang Bersinar ...</description><pubDate>Sat, 12 Nov 2016 19:28:00 GMT</pubDate></item><item><title>Liputan6.com Berita Hari Ini - Kabar Harian Terbaru Terkini</title><link>http://www.liputan6.com/</link><description>WHOOPS: Viral, Video Balita Disabilitas Berusaha Makan Sendiri. Liga Indonesia 11 Nov 2016 23:26 Penalti Menit Akhir Selamatkan Persela dari Kekalahan.</description><pubDate>Sat, 12 Nov 2016 17:41:00 GMT</pubDate></item></channel></rss>';
	});

	given('result', function(){
		return ' Hanya dengan voucher promosi diskon di Lakupon, Anda bisa makan hemat setiap hari. Anda bisa pilih banyak voucher resto, caf ...';
	});

	describe('->getBingRss($word)', function(){
		context('when request failed', function(){
			it('should return false', function(){
				allow('GuzzleHttp\Psr7\Response')->toReceive('getStatusCode')->andReturn();

				$result = $this->sf->getBingRss($this->word);
				expect($result)->toBeFalsy();
			});
		});
		context('when request successful', function(){
			it('should return string', function(){
				$result = $this->sf->getBingRss($this->word);
				expect($result)->toBeA('string');
			});
		});
	});

	describe('->parseBingRss($rss)', function(){
		it('should return array of search results', function(){
			$results = $this->sf->parseBingRss($this->rss);

			expect($results)->toBeA('array');
			expect($results[0])->toBeA('string');
			expect($results[0])->toEqual('Deal diskon makan, minum, hotel, spa, salon, produk kecantikan, fotografi, liburan, serta banyak lagi di Jakarta, Bandung, Surabaya, Bali, Medan dan seluruh Indonesia!');
		});
	});

	describe('->parseResult($result)', function(){
		it('should return string containing sentence', function(){
			$sentence = $this->sf->parseResult($this->result, $this->word);

			expect($sentence)->toBe('Hanya dengan voucher promosi diskon di Lakupon, Anda bisa makan hemat setiap hari.');
			expect($sentence[0])->not->toBe(' ');
		});
	});
});