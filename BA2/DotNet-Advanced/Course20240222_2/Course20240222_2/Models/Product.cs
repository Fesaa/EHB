using System;
using System.ComponentModel.DataAnnotations;

namespace Course20240222_2.Models
{
	public class Product
	{

        public string Name { get; set; } = string.Empty;
        public string Description { get; set; } = string.Empty;
        public float Price { get; set; }
        public Category Category { get; set; }


        public static IEnumerable<Product> GetProducts()
        {
            List<Product> l = new List<Product>
            {
                new Product { Name = "Pink Perfume", Description = "Sweet and floral fragrance", Price = 29.99f, Category = Category.COSMETICA },
                new Product { Name = "Sparkling Lip Gloss", Description = "Shimmery gloss for a glamorous look", Price = 12.99f, Category = Category.COSMETICA },
                new Product { Name = "Floral Dress", Description = "Elegant dress with a floral pattern", Price = 49.99f, Category = Category.LOVE },
                new Product { Name = "Rose Gold Bracelet", Description = "Delicate bracelet with a touch of romance", Price = 39.99f, Category = Category.LOVE },
                new Product { Name = "Cherry Blossom Candle", Description = "Scented candle with a hint of cherry blossom", Price = 19.99f, Category = Category.COSMETICA },
                new Product { Name = "Enchanted Mirror", Description = "Magical mirror for a fairytale touch", Price = 59.99f, Category = Category.LOVE },
                new Product { Name = "Butterfly Hairpin Set", Description = "Set of hairpins with butterfly motifs", Price = 9.99f, Category = Category.LOVE },
                new Product { Name = "Sweetheart Earrings", Description = "Heart-shaped earrings for a sweet touch", Price = 24.99f, Category = Category.LOVE },
                new Product { Name = "Fairy Tale Book", Description = "Collection of enchanting fairy tales", Price = 14.99f, Category = Category.LOVE },
                new Product { Name = "Magical Unicorn Plush", Description = "Cuddly unicorn plush for a magical companion", Price = 34.99f, Category = Category.LOVE },
                new Product { Name = "Glamorous Makeup Kit", Description = "Complete kit for a glamorous makeover", Price = 49.99f, Category = Category.COSMETICA },
                new Product { Name = "Rose Petal Bath Bombs", Description = "Relaxing bath bombs with a rose petal scent", Price = 15.99f, Category = Category.COSMETICA },
                new Product { Name = "Pearl-Encrusted Headband", Description = "Headband adorned with pearls for an elegant look", Price = 18.99f, Category = Category.LOVE },
                new Product { Name = "Diamond Studded Bracelet", Description = "Luxurious bracelet with diamond studs", Price = 79.99f, Category = Category.LOVE },
                new Product { Name = "Champagne Glass Set", Description = "Set of champagne glasses for special occasions", Price = 29.99f, Category = Category.LOVE },
                new Product { Name = "Cupcake Pajama Set", Description = "Cozy pajama set with cute cupcake prints", Price = 32.99f, Category = Category.LOVE },
                new Product { Name = "Crystal-Infused Face Mask", Description = "Face mask infused with healing crystals", Price = 24.99f, Category = Category.COSMETICA },
                new Product { Name = "Butterfly Charm Bracelet", Description = "Charm bracelet featuring delicate butterflies", Price = 22.99f, Category = Category.LOVE },
                new Product { Name = "Vintage Rose Perfume", Description = "Vintage-inspired perfume with a rose essence", Price = 39.99f, Category = Category.COSMETICA },
                new Product { Name = "Lace-trimmed Socks Set", Description = "Set of socks with lace trim for a cute touch", Price = 14.99f, Category = Category.LOVE },
            };

            return l;
        }
        
    }

    public enum Category
    {
        [Display(Name = "Food")] FOOD,
        [Display(Name = "Cosmetica")] COSMETICA,
        [Display(Name = "Love")] LOVE
    }
}

