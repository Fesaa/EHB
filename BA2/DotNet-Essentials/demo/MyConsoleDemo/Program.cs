namespace MyConsoleDemo
{

    internal class Program
    {
        private static void Main(string[] args)
        {
            // Shorted turnary operator of value != null ? value : default
            // Pretty cool
            string name = Console.ReadLine() ?? "Unkown";

            Console.WriteLine($"Hello {name.ToUpper()}!");
        }
    }
}
