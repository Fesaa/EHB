
namespace CLI
{
    public class Product
    {
        public string Name { get; set; }
        public string Category { get; set; }
        public decimal UnitPrice { get; set; }
        public string ProductCode { get; set; }

        public override string ToString()
        {
            return $"Name: {Name}, Category: {Category}, UnitPrice: {UnitPrice}, ProductCode: {ProductCode}";
        }

        public Product(string name, string category, decimal unitPrice, string productCode)
        {
            Name = name;
            Category = category;
            UnitPrice = unitPrice;
            ProductCode = productCode;
        }
    }
}
