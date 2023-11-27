using System;
using System.Globalization;
using System.Linq;
using System.Collections.Generic;
using Vector;

namespace CLI
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine("Hello World!");

            VectorImpl<int> v = new VectorImpl<int>();

            v.PushBack(12);
            v.PushBack(13);
            v.PushBack(11);
            v.PushBack(19);
            v.PopBack();

            Console.WriteLine(v.ToString());

            foreach (int i in v)
            {
                Console.WriteLine(i);
            }

            VectorImpl<Email> emails = new VectorImpl<Email>();

            List<string> to = new List<string>();
            to.Add("test1@email");
            to.Add("test2@email");

            emails.PushBack(new Email("Hello, World!", "Hello, World!", "example@email", to, DateTime.Now.AddDays(-1)));
            emails.PushBack(new Email("Hello, World 1!", "Hello, World!", "example2@email", to, DateTime.Now.AddHours(-1)));
            emails.PushBack(new Email("Hello, World 2!", "Hello, World!", "example3@email", to, DateTime.Now));


            emails.Where(e => e.Datum.Date == DateTime.Now.Date).OrderByDescending(e => e.Datum).ToList().ForEach(e => Console.WriteLine(e.ToString()));
            emails.Where(e => e.Datum.Year == DateTime.Now.Year).OrderByDescending(e => e.Datum).ToList().ForEach(e => Console.WriteLine(e.ToString()));

            string zoekTerm = Console.ReadLine();
            if (zoekTerm == null) return;

            emails.Where(e => e.Inhoud.Contains(zoekTerm)).OrderByDescending(e => e.Datum).ToList().ForEach(e => Console.WriteLine(e.ToString()));
            Console.WriteLine(emails.Where(e => ISOWeek.GetWeekOfYear(e.Datum) == ISOWeek.GetWeekOfYear(DateTime.Now)).OrderByDescending(e => e.Datum).Count());
            Console.WriteLine(emails.OrderByDescending(e => e.Datum).First().ToString());

            int[] numbers = { 5, 4, 1, 3, 9, 8, 6, 7, 2, 0 };

            Console.WriteLine("Grootste 3: " + String.Join(", ", numbers.OrderBy(n => n).TakeLast(3)));
            Console.WriteLine("Som: " + numbers.Sum());
            Console.WriteLine("Gemiddelde: " + numbers.Average());
            Console.WriteLine("Even getallen: " + String.Join(", ", numbers.Where(n => n % 2 == 0)));
        }
    }
}
