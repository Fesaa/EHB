﻿namespace cli;

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
        currentMonth.Year = 2002;
        currentMonth.MonthNr = 11;
        Console.WriteLine(currentMonth);

        // extra 3
        while (true)
        {
            Console.Write("Enter a month number: ");
            string? input = Console.ReadLine();
            if (input == null)
            {
                break;
            }
            if (int.TryParse(input, out int monthNr))
            {
                if (monthNr > 0 && monthNr < 13)
                {
                    currentMonth.MonthNr = monthNr;
                    Console.WriteLine(currentMonth);
                }
                else
                {
                    break;
                }
            }
            else
            {
                break;
            }
        }

    }

}
