namespace FirstConsoleApp;
internal class Program
{
    static void Main(string[] _)
    {
        Console.WriteLine("Hello, what is your name?");
        string? name = Console.ReadLine();
        if (name == null) {
            Console.WriteLine("Why you null??");
        } else
        {
            Console.WriteLine($"Hello, {name}. Here is a sum for you! {Sum(5, 1)}");
        }

        // Keep console open until enter is pressed - visual studio is dumb
        Console.ReadLine();
    }

    /// <summary>
    /// Sum of two ints - addition is communitive
    /// </summary>
    /// <param name="a">First</param>
    /// <param name="b">Second</param>
    /// <returns>Addition</returns>
    public static int Sum(int a, int b)
    {
        return a + b;
    }
}

