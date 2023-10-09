<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    private static array $bookSets = array(
        1 => array(
            "name" => "Magical World Adventure Book Set",
            "description" => "Embark on a thrilling journey with this enchanting book set filled with magical creatures, daring quests, and epic adventures. Perfect for young readers who love to escape into the world of fantasy and imagination."
        ),
        2 => array(
            "name" => "Fantasy Chronicles: The Quest Begins",
            "description" => "Join the heroes in this epic saga as they embark on a perilous quest to save the kingdom from an ancient evil. Filled with magic, mystery, and unforgettable characters, this book set is a must-read for fantasy lovers."
        ),
        3 => array(
            "name" => "Enchanted Forest Tales",
            "description" => "Explore the secrets of the enchanted forest in this captivating book set. Meet mystical creatures, solve riddles, and uncover the hidden wonders of this magical realm. Perfect for young adventurers."
        ),
        4 => array(
            "name" => "Wizards and Wonders: The Complete Collection",
            "description" => "Dive into the world of wizards, spells, and enchantments with this complete collection of magical adventures. Join young wizards on their journey to discover the true power of magic."
        ),
        5 => array(
            "name" => "Dragons and Destiny: The Legendary Saga",
            "description" => "Experience the thrill of dragon-riding and the challenges of destiny in this legendary saga. Follow the chosen heroes as they battle dragons and unlock their true potential."
        )
    );

    public static function getBookSets(): array
    {
        return self::$bookSets;
    }
}
