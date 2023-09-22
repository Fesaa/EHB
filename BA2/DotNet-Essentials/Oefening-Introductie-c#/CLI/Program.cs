namespace cli;

using Helper;

internal class Program
{
    static void Main(string[] _)
    {
        Console.WriteLine("Hello World");

        // Oef 1
        int a = 10;
        int b = 20;

        Console.WriteLine($"a: {a}, b: {b}");
        Utils.Wissel(ref a, ref b);
        Console.WriteLine($"a: {a}, b: {b}");

        // Oef 2
        string sentence = "current month is September";
        Console.WriteLine($"As camelCase: {Utils.ToCamelCase(sentence)}");

        // Oef 3
        Maand currentMonth = new Maand();
        currentMonth.Jaar = 2002;
        currentMonth.Maandnr = 11;
        Console.WriteLine(currentMonth);

    }

}
