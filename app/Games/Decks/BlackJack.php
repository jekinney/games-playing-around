<?php

namespace App\Games\Decks;

abstract class BlackJack
{
	public static function deck()
	{
		return [
			["suit" => "Spades", "value" => 2, 'alt_value' => 2, 'image' => '/images/cards/2_of_spades.png'],
			["suit" => "Spades", "value" => 3, 'alt_value' => 3, 'image' => '/images/cards/3_of_spades.png'],
			["suit" => "Spades", "value" => 4, 'alt_value' => 4, 'image' => '/images/cards/4_of_spades.png'],
			["suit" => "Spades", "value" => 5, 'alt_value' => 5, 'image' => '/images/cards/5_of_spades.png'],
			["suit" => "Spades", "value" => 6, 'alt_value' => 6, 'image' => '/images/cards/6_of_spades.png'],
			["suit" => "Spades", "value" => 7, 'alt_value' => 7, 'image' => '/images/cards/7_of_spades.png'],
			["suit" => "Spades", "value" => 8, 'alt_value' => 8, 'image' => '/images/cards/8_of_spades.png'],
			["suit" => "Spades", "value" => 9, 'alt_value' => 9, 'image' => '/images/cards/9_of_spades.png'],
			["suit" => "Spades", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/10_of_spades.png'],
			["suit" => "Spades", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/jack_of_spades.png'],
			["suit" => "Spades", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/queen_of_spades.png'],
			["suit" => "Spades", "value" => 10, 'alt_value' => 10,'image' => '/images/cards/king_of_spades.png'],
			["suit" => "Spades", "value" => 1, 'alt_value' => 11, 'image' => '/images/cards/ace_of_spades.png'],
			["suit" => "Hearts", "value" => 2, 'alt_value' => 2, 'image' => '/images/cards/2_of_hearts.png'],
			["suit" => "Hearts", "value" => 3, 'alt_value' => 3, 'image' => '/images/cards/3_of_hearts.png'],
			["suit" => "Hearts", "value" => 4, 'alt_value' => 4, 'image' => '/images/cards/4_of_hearts.png'],
			["suit" => "Hearts", "value" => 5, 'alt_value' => 5, 'image' => '/images/cards/5_of_hearts.png'],
			["suit" => "Hearts", "value" => 6, 'alt_value' => 6, 'image' => '/images/cards/6_of_hearts.png'],
			["suit" => "Hearts", "value" => 7, 'alt_value' => 7, 'image' => '/images/cards/7_of_hearts.png'],
			["suit" => "Hearts", "value" => 8, 'alt_value' => 8, 'image' => '/images/cards/8_of_hearts.png'],
			["suit" => "Hearts", "value" => 9, 'alt_value' => 9, 'image' => '/images/cards/9_of_hearts.png'],
			["suit" => "Hearts", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/10_of_hearts.png'],
			["suit" => "Hearts", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/jack_of_hearts.png'],
			["suit" => "Hearts", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/queen_of_hearts.png'],
			["suit" => "Hearts", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/king_of_hearts.png'],
			["suit" => "Hearts", "value" => 1,  'alt_value' => 11, 'image' => '/images/cards/ace_of_hearts.png'],
			["suit" => "Diamonds", "value" => 2, 'alt_value' => 2, 'image' => '/images/cards/2_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 3, 'alt_value' => 3, 'image' => '/images/cards/3_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 4, 'alt_value' => 4, 'image' => '/images/cards/4_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 5, 'alt_value' => 5, 'image' => '/images/cards/5_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 6, 'alt_value' => 6, 'image' => '/images/cards/6_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 7, 'alt_value' => 7, 'image' => '/images/cards/7_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 8, 'alt_value' => 8, 'image' => '/images/cards/8_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 9, 'alt_value' => 9, 'image' => '/images/cards/9_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/10_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/jack_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/queen_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/king_of_diamonds.png'],
			["suit" => "Diamonds", "value" => 1, 'alt_value' => 11, 'image' => '/images/cards/ace_of_diamonds.png'],
			["suit" => "Clubs", "value" => 2, 'alt_value' => 2, 'image' => '/images/cards/2_of_clubs.png'],
			["suit" => "Clubs", "value" => 3, 'alt_value' => 3, 'image' => '/images/cards/3_of_clubs.png'],
			["suit" => "Clubs", "value" => 4, 'alt_value' => 4, 'image' => '/images/cards/4_of_clubs.png'],
			["suit" => "Clubs", "value" => 5, 'alt_value' => 5, 'image' => '/images/cards/5_of_clubs.png'],
			["suit" => "Clubs", "value" => 6, 'alt_value' => 6, 'image' => '/images/cards/6_of_clubs.png'],
			["suit" => "Clubs", "value" => 7, 'alt_value' => 7, 'image' => '/images/cards/7_of_clubs.png'],
			["suit" => "Clubs", "value" => 8, 'alt_value' => 8, 'image' => '/images/cards/8_of_clubs.png'],
			["suit" => "Clubs", "value" => 9, 'alt_value' => 9, 'image' => '/images/cards/9_of_clubs.png'],
			["suit" => "Clubs", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/10_of_clubs.png'],
			["suit" => "Clubs", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/jack_of_clubs.png'],
			["suit" => "Clubs", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/queen_of_clubs.png'],
			["suit" => "Clubs", "value" => 10, 'alt_value' => 10, 'image' => '/images/cards/king_of_clubs.png'],
			["suit" => "Clubs", "value" => 1, 'alt_value' => 11, 'image' => '/images/cards/ace_of_clubs.png'],
		];
	}
}