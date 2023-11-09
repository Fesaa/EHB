
namespace ConsoleApp
{
    public class ConsoleApp
    {

        public static void Main(string[] args)
        {
            Console.WriteLine("Welcome to Adventure Game, what is your name?");
            string? name = Console.ReadLine();
            if (name == null)
            {
                Console.WriteLine("Give a name, don't be shy!");
                return;
            }

            Console.WriteLine("How many rooms do you want?");
            string? roomCountString = Console.ReadLine();
            if (roomCountString == null)
            {
                Console.WriteLine("Give a number, don't be shy!");
                return;
            }

            if (!int.TryParse(roomCountString, out int roomCount))
            {
                Console.WriteLine("Give a number, don't be shy!");
                return;
            }

            ConsoleGameLoop gameLoop = new ConsoleGameLoop(name, roomCount);
            gameLoop.Run();
        }

    }

}
