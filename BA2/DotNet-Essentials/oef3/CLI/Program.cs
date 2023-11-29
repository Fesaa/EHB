using System;
using System.Linq;
using System.Collections.Generic;

namespace CLI
{
    class Program
    {
        static void Main(string[] args)
        {

            List<Product> products = new List<Product>();
            products.Add(new Product("Apple", "Fruit", 1.99m, "A1"));
            products.Add(new Product("Orange", "Fruit", 2.99m, "A1"));
            products.Add(new Product("Banana", "Fruit", 3.99m, "A1"));
            products.Add(new Product("Pear", "Fruit2", 4.99m, "A2"));
            products.Add(new Product("Pineapple", "Fruit2", 5.99m, "A2"));
            products.Add(new Product("Strawberry", "Fruit2", 6.99m, "A2"));

            Product duurste = products.OrderByDescending(p => p.UnitPrice).First();
            decimal gemiddelde = products.Average(p => p.UnitPrice);
            Console.WriteLine($"Duurste product: {duurste}");
            Console.WriteLine($"Gemiddelde prijs: {gemiddelde}");

            products.GroupBy(p => p.Category).ToList()
                .ForEach(cat =>
                {
                    Console.WriteLine($"Category: {cat.Key}");
                    Console.WriteLine($"Aantal producten: {cat.Count()}");
                    Console.WriteLine($"Duurste product: {cat.OrderByDescending(p => p.UnitPrice).First()}");
                    Console.WriteLine($"Gemiddelde prijs: {cat.Average(p => p.UnitPrice)}");
                    Console.WriteLine($"Goedkoopste product: {cat.OrderBy(p => p.UnitPrice).First()}");
                    Console.WriteLine();
                });
        }
    }
}
